<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Advice;
use App\Models\AdviceSituationLaw;
use App\Models\Assemblyman;
use App\Models\Company;
use App\Models\Destination;
use App\Models\Document;
use App\Models\DocumentSituation;
use App\Models\LawsProject;
use App\Models\Meeting;
use App\Models\MeetingFiles;
use App\Models\MeetingPauta;
use App\Models\Parameters;
use App\Models\Processing;
use App\Models\ProcessingDocument;
use App\Models\Responsibility;
use App\Models\ResponsibilityAssemblyman;
use App\Models\SessionPlace;
use App\Models\SessionType;
use App\Models\StatusProcessingDocument;
use App\Models\Structurepautum;
use App\Models\TypeVoting;
use App\Models\UserAssemblyman;
use App\Models\VersionPauta;
use App\Models\Votes;
use App\Models\Voting;
use App\Repositories\MeetingRepository;
use App\Services\StorageService;
use Artesaos\Defender\Facades\Defender;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MeetingController extends AppBaseController
{
    /**
     * @var StorageService
     */
    private static $storageService;

    /** @var MeetingRepository */
    private $meetingRepository;

    public function __construct(MeetingRepository $meetingRepo)
    {
        $this->meetingRepository = $meetingRepo;

        static::$storageService = new StorageService();
    }

    /**
     * Display a listing of the Meeting.
     *
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function index()
    {
        self::initSessions();

        if (! Defender::hasPermission('meetings.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $assemblyman_list = Assemblyman::whereIn('id', UserAssemblyman::where('users_id', Auth::user()->id)->pluck('assemblyman_id')->toArray())->pluck('short_name', 'id')->prepend('Selecione', 0);
        $meetings = Meeting::orderBy('date_start', 'desc')->paginate(20);

        return view('meetings.index', compact('assemblyman_list'))
            ->with('meetings', $meetings);
    }

    /**
     * Show the form for creating a new Meeting.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        self::initSessions();

        if (! Defender::hasPermission('meetings.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $version_pautas = VersionPauta::pluck('name', 'id');

        return view('meetings.create', compact('version_pautas'));
    }

    /**
     * Store a newly created Meeting in storage.
     *
     * @param CreateMeetingRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateMeetingRequest $request)
    {
        if (! Defender::hasPermission('meetings.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $this->meetingRepository->create($input);

        flash('Reunião salva com sucesso.')->success();

        return redirect(route('meetings.index'));
    }

    /**
     * Display the specified Meeting.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
        if (! Defender::hasPermission('meetings.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $meeting = $this->meetingRepository->findById($id);
        $assemblyman = Assemblyman::where('active', 1)->orderBy('short_name')->get();

        if (empty($meeting)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }

        return view('meetings.show', compact('assemblyman'))->with('meeting', $meeting);
    }

    /**
     * Show the form for editing the specified Meeting.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        self::initSessions();

        if (! Defender::hasPermission('meetings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $meeting = $this->meetingRepository->findById($id);

        if (empty($meeting)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }

        $version_pautas = VersionPauta::pluck('name', 'id');

        return view('meetings.edit', compact('version_pautas'))->with('meeting', $meeting);
    }

    /**
     * Update the specified Meeting in storage.
     *
     * @param int $id
     * @param UpdateMeetingRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateMeetingRequest $request)
    {
        if (! Defender::hasPermission('meetings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $meeting = $this->meetingRepository->findById($id);

        if (empty($meeting)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }

        $meeting = $this->meetingRepository->update($meeting, $request->all());
        MeetingPauta::where('meeting_id', $meeting->id)->get();

        flash('Reunião atualizada com sucesso.')->success();

        return redirect(route('meetings.index'));
    }

    /**
     * Remove the specified Meeting from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function destroy($id, Request $request)
    {
        if (! Defender::hasPermission('meetings.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $meeting = $this->meetingRepository->findById($id);

        if (empty($meeting)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }

        $this->meetingRepository->delete($meeting);

        if ($request->ajax()) {
            return 'success';
        }

        flash('Reunião removida com sucesso.')->success();

        return redirect(route('meetings.index'));
    }

    /**
     * Update status of specified Meeting from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('meetings.edit')) {
            return json_encode(false);
        }
        $register = $this->meetingRepository->findById($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function meetingsNextNumber($session_type_id)
    {
        $last_document = Meeting::where('session_type_id', $session_type_id)
            ->where('number', '!=', '')
            ->orderBy('number', 'DESC')
            ->first();

        if ($last_document) {
            $nextNumber = $last_document->number + 1;
        } else {
            $nextNumber = 1;
        }

        return $nextNumber;
    }

    public function meetingsCanNumber($number, $session_type_id)
    {
        $year = date('o');

        $parameter = Parameters::where('slug', 'permitir-criar-sessoes-fora-da-sequencia')->first();

        if ($parameter->value == 0) {
            $metting = Meeting::where('session_type_id', $session_type_id)
                ->whereYear('date_start', '=', $year)
                ->where('number', '>=', intval($number))
                ->first();
        } else {
            $metting = Meeting::where('session_type_id', $session_type_id)
                ->whereYear('date_start', '=', $year)
                ->where('number', '=', $number)
                ->first();
        }

        if ($metting) {
            $next = Meeting::where('session_type_id', $session_type_id)
                ->where('number', '!=', '')
                ->orderBy('number', 'DESC')
                ->first();

            if ($next) {
                $nextNumber = $next->number + 1;
            } else {
                $nextNumber = 1;
            }

            return ['success' => false, 'message' => 'Número já utilizado ou inferior ao último, a sua sugestão foi atualizada!', 'next_number' => $nextNumber];
        } else {
            return ['success' => true];
        }
    }

    public function newata($meeting_id)
    {
        if (! Defender::hasPermission('meetings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $meeting = $this->meetingRepository->findById($meeting_id);

        if (empty($meeting)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }
        $assemblyman = Assemblyman::where('active', 1)->orderBy('short_name')->get();

        return view('meetings.ata', compact('meeting', 'assemblyman'));
    }

    public function atasave(Request $request)
    {
        $input = $request->all();
        $meet = Meeting::find($input['meeting_id']);

        if (empty($meet)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }

        $meet->ata = $input['ata'];
        $meet->save();

        flash('Ata salva com sucesso!')->success();

        return redirect("/meetings/{$meet->id}/ata");
    }

    public function ataPDF($id)
    {

//        if(!Defender::hasPermission('meetings.show'))
//        {
//            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning(;
//            return redirect("/");
//        }

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Campo_Grande');

        $meeting = Meeting::find($id);

        require_once public_path().'/tcpdf/mypdf.php';

        $company = Company::first();

        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-ata')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;

        $pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $subHeader = $company->phone1.' - '.$company->email."\n";

        $pdf->setFooterData($meeting->id.'-'.date_timestamp_get($meeting->created_at), [0, 64, 0], [0, 64, 128]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda, $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(true, $margemInferior + 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->SetTitle('Pauta - '.$meeting->number);
//        $pdf->setListIndentWidth(4);

        $pdf->AddPage();

        $html = '<h2>'.$meeting->number.'º '.$meeting->session_type->name.'</h2><br>
                <h3 style=" color: #aaa;">Informações Básicas</h3>
                <span><strong>  Tipo da sessão:</strong> '.$meeting->session_type->name.'</span><br>
                <span><strong>Abertura: </strong> '.$meeting->date_start.'</span><br>
                <span><strong>Encerramento: </strong>'.$meeting->date_end.'</span>';

        $html .= '<h3 style=" color: #aaa;">Mesa Diretora</h3>';
        $data = $meeting->getDataMesa($meeting->date_start);
        foreach (Responsibility::where('order', '<', 15)->where('skip_board', 0)->orderBy('order')->get() as $item) {
            $resp = $item->Responsibilities()->where('date', '<=', $data)->orderBy('date', 'desc')->first();
            if (isset($resp->assemblyman->short_name)) {
                $html .= '<span><strong>'.$item->name.':</strong> '.$resp->assemblyman->short_name.'</span><br>';
            }
        }

        $html .= '<h3 style=" color: #aaa;">Lista de Presença</h3>';
        foreach ($meeting->assemblyman()->get() as $item) {
            $html .= '<span>'.$item->short_name.'</span><br>';
        }

        $html .= '<h3 style=" color: #aaa;">Narrativa</h3>';
        $html .= $meeting->ata;

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->Ln(5);

        if ($meeting->voting()->count() > 0) {
            $html2 = '<br><h3 style=" color: #aaa;">Matérias da Ordem do Dia</h3>';
            $html2 .= '<table cellspacing="2" cellpadding="5" style="border: 1px solid black;">';
            $html2 .= '<thead > ';
            $html2 .= '<tr style=" background-color: #ccc;">';
            $html2 .= '<th width="450px;">';
            $html2 .= 'Matéria';
            $html2 .= '</th>';
            $html2 .= '<th width="80px;">';
            $html2 .= 'Status';
            $html2 .= '</th>';
            $html2 .= '</tr>';
            $html2 .= '</thead>';
            $html2 .= '<tbody>';
            foreach ($meeting->voting()->where('version_pauta_id', $meeting->version_pauta_id)->whereNotNull('closed_at')->get() as $key => $item) {
                $no = $item->votes()->sum('no');
                $yes = $item->votes()->sum('yes');
                $html2 .= '<tr>';
                $html2 .= '<td style="font-size: 12px;" width="450px;">';
                if ($item->advice_id > 0) {
                    $html2 .= $key + 1 .' - <b>'.$item->advice->commission->name.'</b><br>'.$item->getNameAdvice();
                }

                if ($item->document_id > 0 || $item->law_id > 0) {
                    $html2 .= $key + 1 .' - '.$item->getName();
                }

                if ($item->ata_id > 0) {
                    $html2 .= $key + 1 .' - ATA : '.$item->getAta();
                }

                $html2 .= '</td>';
                $html2 .= '<td style="font-size: 12px;" width="80px;">';
                if ($yes > $no) {
                    $html2 .= '        Aprovada';
                } else {
                    $html2 .= '        Reprovada';
                }
                $html2 .= '</td>';
                $html2 .= '</tr>';
            }
            $html2 .= '</tbody>';
            $html2 .= '</table>';
            $pdf->writeHTMLCell(0, 0, '', '', $html2, 0, 1, 0, true, '', true);
        }

        $presidente = Parameters::where('slug', 'presidente-assina-pauta-e-ata')->first();
        $vicePresidente = Parameters::where('slug', 'vice-presidente-assina-pauta-e-ata')->first();
        $secretario = Parameters::where('slug', '1-secretario-assina-pauta-e-ata')->first();

        if (
            ($presidente && $presidente->value == 1) ||
            ($vicePresidente && $vicePresidente->value == 1) ||
            $secretario && $secretario->value == 1
        ) {
            $html1 = '<br> <br> <br>';
            $html1 .= '<table cellspacing="10" cellpadding="10" style="position:absolute; width: 100%; margin-top: 400px; margin-left: 8%;">';
            $html1 .= '<tbody>';
            $html1 .= '<tr  style="height: 300px; font-weight: bold;">';
            $html1 .= $presidente->value == 1 ? '<td style="text-align: center; vertical-align: text-top; ">'.ResponsibilityAssemblyman::where('responsibility_id', 1)->first()->assemblyman->short_name.'<br> Presidente </td>' : '';
            $html1 .= $vicePresidente->value == 1 ? '<td style="text-align: center; vertical-align: text-top;">'.ResponsibilityAssemblyman::where('responsibility_id', 2)->first()->assemblyman->short_name.'<br> Vice Presidente </td>' : '';
            $html1 .= $secretario->value == 1 ? '<td style="text-align: center; vertical-align: text-top;">'.ResponsibilityAssemblyman::where('responsibility_id', 3)->first()->assemblyman->short_name.'<br> 1º Secretário </td>' : '';
            $html1 .= '</tr>';
            $html1 .= '</tbody>';
            $html1 .= '</table>';
            $pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
        }

//        if($presidente->value == 1 || $vicePresidente->value == 1 || $secretario->value == 1) {
//            $pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 1, 0, true, '', true);
//        }

        $pdf->Output('ATA.pdf', 'I');
    }

    public function pautaPDF($id)
    {

//        if(!Defender::hasPermission('meetings.show'))
//        {
//            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning(;
//            return redirect("/");
//        }

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Campo_Grande');

        $pautas = MeetingPauta::where('meeting_id', $id)->whereNull('description')->get();
        $meeting = Meeting::find($id);

        $structurepautas = Structurepautum::whereNull('parent_id')->where('version_pauta_id', $meeting->version_pauta_id)->get();
        $documents = Document::where('read', '0')->where('approved', '0')->get();
        $laws = LawsProject::all();
        $lawscreate = $this->createLaw($laws);
        $docs = $this->createDocument($documents);

        if (empty($structurepautas)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }

        $meeting = Meeting::find($id);

        require_once public_path().'/tcpdf/mypdf.php';

        $company = Company::first();

        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-pauta')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;

        $pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $subHeader = $company->phone1.' - '.$company->email."\n";
        $pdf->setFooterData($meeting->id.'-'.date_timestamp_get($meeting->created_at), [0, 64, 0], [0, 64, 128]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda, $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(true, $margemInferior + 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->SetTitle('Pauta - '.$meeting->number);
        $pdf->setListIndentWidth(1);

        // $pdf->setHtmlVSpace(array(
        //     'li' => array(
        //         'h' => 5, // margin in mm
        //     )
        // ));
        $pdf->AddPage();

        $html = '<h2>PAUTA DA SESSÃO</h2><br>
                <span><strong>'.$meeting->session_type->name.'</strong></span><br>
                <span><strong>Sessão Nº:</strong> '.$meeting->number.'</span><br>
                <span><strong>Data: </strong>'.$meeting->date_start.'</span>';

        $structurepautas = Structurepautum::where('version_pauta_id', $meeting->version_pauta_id)->get()->toHierarchy();

        foreach ($structurepautas as $reg) {
            $html .= $this->renderPauta($reg, $id);
        }

        $presidente = Parameters::where('slug', 'presidente-assina-pauta-e-ata')->first();
        $vicePresidente = Parameters::where('slug', 'vice-presidente-assina-pauta-e-ata')->first();
        $secretario = Parameters::where('slug', '1-secretario-assina-pauta-e-ata')->first();

        if (
            ($presidente && $presidente->value == 1) ||
            ($vicePresidente && $vicePresidente->value == 1) ||
            $secretario && $secretario->value == 1
        ) {
            $html .= '<br> <br> <br>';
            $html .= '<table cellspacing="10" cellpadding="10" style="position:absolute; width: 100%; margin-top: 400px; margin-left: 8%;">';
            $html .= '<tbody>';
            $html .= '<tr  style="height: 300px; font-weight: bold;">';
            $html .= $presidente->value == 1 ? '<td style="text-align: center; vertical-align: text-top; ">'.ResponsibilityAssemblyman::where('responsibility_id', 1)->first()->assemblyman->short_name.'<br> Presidente </td>' : '';
            $html .= $vicePresidente->value == 1 ? '<td style="text-align: center; vertical-align: text-top;">'.ResponsibilityAssemblyman::where('responsibility_id', 2)->first()->assemblyman->short_name.'<br> Vice Presidente </td>' : '';
            $html .= $secretario->value == 1 ? '<td style="text-align: center; vertical-align: text-top;">'.ResponsibilityAssemblyman::where('responsibility_id', 3)->first()->assemblyman->short_name.'<br> 1º Secretário </td>' : '';
            $html .= '</tr>';
            $html .= '</tbody>';
            $html .= '</table>';
        }

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $pdf->Output('ATA.pdf', 'I');
    }

    protected function getPauta($meeting_id, $structure_id)
    {
        $pautas = MeetingPauta::where('meeting_id', $meeting_id)
            ->where('structure_id', $structure_id)
            ->get();

        return $pautas;
    }

    protected function renderPauta($node, $meeting_id)
    {
        $docs = $this->getPauta($meeting_id, $node->id);
        $html = '<style>
                    .list_show ol { list-style-type: decimal; }
                    .list_show ul { list-style-type: circle; }
                 </style>';

        $html .= '<ul style="list-style-type: none; padding-left:5px; margin-left:5px">';

        if ($node->isLeaf()) {
            $html .= '<li style="margin-bottom:10px;"><strong>'.$node->name.'</strong>';
            $html .= '<ul style="list-style-type: none; padding-left:5px; margin-left:5px">';
            foreach ($docs as $p) {
                if ($p->document_id) {
                    $documts = \App\Models\Document::where('id', $p->document_id)->first();
                    $texto = $documts->number.'/'.$documts->getYear($documts->date).' '.($documts->document_type->parent_id ? $documts->document_type->parent->name.'::'.$documts->document_type->name : $documts->document_type->name).' - '.$documts->owner->short_name;
                    $observation = $p->observation;

                    $html .= '<li style="margin-bottom:10px; text-transform: uppercase; font-weight: bold;" >';
                    $html .= '<a href="/documents/'.$p->document_id.'" target="_blank"><strong>'.$texto.'</strong></a>';

                    if ($observation != '') {
                        $html .= '<div style="font-style: italic; color: #999; text-align: justify; ">'.$p->observation.'</div>';
                    }
                    $html .= '</li> <br>';
                } elseif ($p->law_id) {
                    $law = \App\Models\LawsProject::where('id', $p->law_id)->first();
                    $texto = $law->project_number.'/'.$law->getYearLawPublish($law->law_date).' '.$law->law_type->name.' - '.($law->assemblyman_id ? $law->owner->short_name : '');
                    $observation = $p->observation;

                    $html .= '<li style="margin-bottom:30px; text-align: justify; ">';
                    $html .= '<a href="/lawsProjects/'.$p->law_id.'"><strong style="text-transform: uppercase;">'.$texto.'</strong><br>'.$law->title.'</a></li>';
                    if ($observation != '') {
                        $html .= '<div style="font-style: italic; color: #999; text-align: justify; text-transform: uppercase;">'.$p->observation.'</div>';
                    }
                } elseif ($p->advice_id) {
                    $advice = Advice::where('id', $p->advice_id)->first();
                    $texto = $advice->commission->name.'<br>';

                    if ($advice->laws_projects_id > 0) {
                        $texto .= 'PROJETO DE LEI : '.$advice->project->project_number.'/'.$advice->project->getYearLawPublish($advice->project->law_date).' '.$advice->project->law_type->name.' - '.($advice->project->assemblyman_id ? $advice->project->owner->short_name : '');
                        $html .= '<li style="margin-bottom:100px; text-align: justify;"><strong style="text-transform: uppercase;">'.$texto.'</strong><br>'.$advice->project->title.'</li> <br> ';
                    }

                    if ($advice->document_id > 0) {
                        $doc = 'DOCUMENTO : '.$advice->document->number.'/'.$advice->document->getYear($advice->document->date).' '.($advice->document->document_type->parent_id ? $advice->document->document_type->parent->name.'::'.$advice->document->document_type->name : $advice->document->document_type->name).' - '.$advice->document->owner->short_name;
                        $observation = $p->observation;

                        $html .= '<li style="margin-bottom:10px;"> <strong style="text-transform: uppercase;">'.$texto.$doc.'</strong>';

                        if ($observation != '') {
                            $html .= '<div style="font-style: italic; color: #999; text-align: justify; ">'.$p->observation.'</div>';
                        }
                        $html .= '</li> <br>';
                    }
                }
            }
            $html .= '</ul>';
            $html .= '</li>';
        } else {
            $html .= '<li><strong>'.strtoupper($node->name).'</strong>';

            $html .= '<ul style="list-style-type: none; padding-left:5px; margin-left:5px">';

            foreach ($node->children as $child) {
                $html .= $this->renderPauta($child, $meeting_id);
            }

            $html .= '</ul>';

            $html .= '</li>';
        }

        $pauta = MeetingPauta::where('meeting_id', $meeting_id)->where('structure_id', $node->id)->whereNotNull('description')->first();
        if ($pauta) {
            $html .= '<li style="margin-bottom:10px; text-align: justify;" class="list_show">'.($pauta->description).'</li> <br>';
        }

        $html .= '</ul>';

        return $html;
    }

    public function newpauta($meeting_id)
    {
        if (! Defender::hasPermission('meetings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $pautas = MeetingPauta::where('meeting_id', $meeting_id)->whereNull('description')->orderBy('created_at')->get();

        $documents = Document::where('read', '0')->where('approved', '0')->get();
        $laws = LawsProject::all();
        $advices = $this->createAdvice(Advice::where('closed', 0)->get());
        $lawscreate = $this->createLaw($laws);
        $docs = $this->createDocument($documents);
        $meeting = $this->meetingRepository->findById($meeting_id);
        $assemblyman = Assemblyman::where('active', 1)->orderBy('short_name')->get();
        $structurepautas = Structurepautum::whereNull('parent_id')->where('version_pauta_id', $meeting->version_pauta_id)->get();

        if (empty($structurepautas)) {
            flash('Reunião não encontrada')->error();

            return redirect(route('meetings.index'));
        }

        return view('meetings.pauta', compact('structurepautas', 'meeting_id', 'docs', 'laws', 'pautas', 'lawscreate', 'meeting', 'assemblyman', 'advices'));
    }

    public function createDocument($documents)
    {
        $data = [];
        foreach ($documents as $document) {
            try {
                $data[$document->id] = 'DOCUMENTO : '.$document->number.'/'.$document->getYear($document->date).' '.($document->document_type->parent_id ? $document->document_type->parent->name.'::'.$document->document_type->name : $document->document_type->name).' - '.$document->owner->short_name;
            } catch (Exception $e) {
                dd($document);
            }
        }

        return $data;
    }

    public function createLaw($documents)
    {
        $data = [];
        foreach ($documents as $document) {
            try {
                $data[$document->id] = 'PROJETO DE LEI : '.$document->project_number.'/'.$document->getYearLawPublish($document->law_date).' '.$document->law_type->name.' - '.($document->owner ? $document->owner->short_name : '');
            } catch (Exception $e) {
                dd($document);
            }
        }

        return $data;
    }

    public function createAdvice($documents)
    {
        $data = [];
        foreach ($documents as $document) {
            if ($document->document_id > 0 && $document->document) {
                $data[$document->id] = $document->commission->name.' : '.$document->document->number.'/'.$document->document->getYear($document->document->date).' '.($document->document->document_type->parent_id ? $document->document->document_type->parent->name.'::'.$document->document->document_type->name : $document->document->document_type->name).' - '.$document->document->owner->short_name;
            }

            if ($document->laws_projects_id > 0 && $document->project) {
                $data[$document->id] = $document->commission->name.' : '.$document->project->project_number.'/'.$document->project->getYearLawPublish($document->project->law_date).' '.$document->project->law_type->name.' - '.($document->project->assemblyman_id ? $document->project->owner->short_name : '');
            }
        }

        return $data;
    }

    public function addDocument(Request $request)
    {
        $input = $request->all();

        $input['law_id'] = $input['law_id'] ? $input['law_id'] : null;
        $input['document_id'] = $input['document_id'] ? $input['document_id'] : null;
        $input['advice_id'] = $input['advice_id'] ? $input['advice_id'] : null;
        $input['description'] = $input['description'] ? $input['description'] : null;
        $input['observation'] = $input['observation'] ? $input['observation'] : null;

        if ($input['document_id']) {
            ProcessingDocument::create([
                'document_id' => $input['document_id'],
                'document_situation_id' => DocumentSituation::where('name', 'Encaminhado')->first()->id,
                'status_processing_document_id' => StatusProcessingDocument::where('name', 'Em Trâmitação')
                    ->first()->id,
                'processing_document_date' => now()->format('d/m/Y'),
                'destination_id' => Destination::where('name', 'PLENÁRIO')->first()->id,
            ]);
        }

        if ($input['law_id']) {
            Processing::create([
                'law_projects_id' => $input['law_id'],
                'advice_situation_id' => AdviceSituationLaw::where('name', 'Encaminhado')->first()->id,
                'processing_date' => now()->format('d/m/Y H:i'),
                'destination_id' => Destination::where('name', 'PLENÁRIO')->first()->id,
            ]);
        }

        $obj = MeetingPauta::where('meeting_id', $input['meeting_id'])
            ->where('structure_id', $input['structure_id'])
            ->where('document_id', $input['document_id'])
            ->where('law_id', $input['law_id'])
            ->where('advice_id', $input['advice_id'])->first();

        if ($obj) {
            $id = $obj->id;
            if ($input['description']) {
                $obj->update($input);
            }

            return \GuzzleHttp\json_encode($id);
        } else {
            $obj = MeetingPauta::create($input);

            return \GuzzleHttp\json_encode($obj);
        }
    }

    public function removeDocument($id)
    {
        $doc = MeetingPauta::find($id);

        if ($doc) {
            if ($doc->law_id != null) {
                $doc->law->each(function ($law) {
                    if ($law->processing->isNotEmpty()) {
                        $law_query = $law->processing()
                            ->where('destination_id', Destination::where('name', 'PLENÁRIO')->first()->id)
                            ->orderByDesc('created_at');

                        $law_query->get()->isNotEmpty() && $law_query->first()->delete();
                    }
                });

                $voting = Voting::where('meeting_id', $doc->meeting_id)->where('law_id', $doc->law_id)->get();
                if ($voting->count() == 0) {
                    $doc->delete($id);

                    return \GuzzleHttp\json_encode(true);
                }
            } elseif ($doc->document_id != null) {
                $doc->document->each(function ($law) {
                    if ($law->processingDocument->isNotEmpty()) {
                        $law_query = $law->processingDocument()
                            ->where('destination_id', Destination::where('name', 'PLENÁRIO')->first()->id)
                            ->orderByDesc('created_at');

                        $law_query->get()->isNotEmpty() && $law_query->first()->delete();
                    }
                });

                $voting = Voting::where('meeting_id', $doc->meeting_id)->where('document_id', $doc->document_id)->get();
                if ($voting->count() == 0) {
                    $doc->delete($id);

                    return \GuzzleHttp\json_encode(true);
                }
            } elseif ($doc->advice_id != null) {
                $voting = Voting::where('meeting_id', $doc->meeting_id)->where('advice_id', $doc->advice_id)->get();
                if ($voting->count() == 0) {
                    $doc->delete($id);

                    return \GuzzleHttp\json_encode(true);
                }
            } elseif ($doc->description != null) {
                if ($doc->delete($id)) {
                    return \GuzzleHttp\json_encode(true);
                }
            }
        }

        return \GuzzleHttp\json_encode(false);
    }

    /**
     * @return string
     */
    public function getDates()
    {
        $obj = Meeting::all();

        $return = [];

        foreach ($obj as $data) {
            $return[] = $this->date_start_to_iso($data->date_start);
        }

        return \GuzzleHttp\json_encode($return);
    }

    /**
     * @param $date
     * @return string
     */
    public function date_start_to_iso($date)
    {
        $tmp = explode('/', (explode(' ', $date)[0]));

        return ltrim($tmp[0], '0').'-'.ltrim($tmp[1], '0').'-'.$tmp[2];
    }

    public function attachament($id)
    {
        if (! Defender::hasPermission('meetings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/meetings');
        }

        $meeting = Meeting::find($id);
        $meeting_files = MeetingFiles::where('meeting_id', $meeting->id)->get();

        return view('meetings.attachament')->with(compact('meeting', 'meeting_files'));
    }

    public function attachamentUpload($id, Request $request)
    {
        if (! Defender::hasPermission('meetings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/meetings');
        }

        $meeting = Meeting::find($id);

        $files = $request->file;

        if ($files) {
            foreach ($files as $file) {
                $filename = static::$storageService
                    ->inMeetingsFolder()
                    ->sendFile($file)
                    ->send();

                $new_file = new MeetingFiles();
                $new_file->meeting_id = $meeting->id;
                $new_file->filename = $filename;
                $new_file->save();
            }
        }

        return Redirect::route('meetings.attachament', $meeting->id);
    }

    public function attachamentDelete($id)
    {
        $file = MeetingFiles::find($id);
        $file->delete();

        return 'true';
    }

    public function presence($id)
    {
        $meeting = Meeting::find($id);
        $assemblyman = Assemblyman::where('active', 1)->orderBy('short_name')->get();

        return view('meetings.presence', compact('meeting', 'assemblyman'));
    }

    public function presenceSave(Request $request)
    {
        $input = $request->all();

        $meeting = Meeting::find($input['meeting_id']);
        $assemblyman = Assemblyman::where('active', 1)->orderBy('short_name')->get();

        if (isset($input['assemblymen_id'])) {
            $meeting->assemblyman()->sync($input['assemblymen_id']);
        } else {
            $meeting->assemblyman()->detach();
        }

        return view('meetings.presence', compact('meeting', 'assemblyman'));
    }

    public function presencePDF($id)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Campo_Grande');

        $meeting = Meeting::find($id);
        $assemblyman = Assemblyman::where('active', 1)->orderBy('short_name')->get();
        $ids = $meeting->assemblyman->pluck('id')->toArray();
        $presence = Assemblyman::whereNotIn('id', $ids)->where('active', 1)->orderBy('short_name')->get();

        require_once public_path().'/tcpdf/mypdf.php';

        $company = Company::first();

        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-pauta')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;

        $pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);

        $pdf->setFooterData($meeting->id.'-'.date_timestamp_get($meeting->created_at), [0, 64, 0], [0, 64, 128]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda, $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(true, $margemInferior + 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->SetTitle('Pauta - '.$meeting->number);
        $pdf->setListIndentWidth(1);

        $pdf->AddPage();

        $html = '<h2>RELATÓRIO DE PRESENÇA</h2>';
        $html .= '<p><strong style="text-transform: uppercase;">'.$meeting->session_type->name.' - '.$meeting->number.'</strong> <br>'.$meeting->date_start.'</p>';

        $html .= '<br/>';
        $html .= '<br/>';
        $html .= '<br/>';
        $html .= '<strong>TOTAL DE VERREADORES ('.$assemblyman->count().')</strong><br><br>';

        $html .= '<table>';
        $html .= '<thead><tr><th><strong>VERREADORES PRESENTES ('.$meeting->assemblyman()->count().')</strong></th></tr></thead>';
        $html .= '<tbody>';

        foreach ($meeting->assemblyman as $item) {
            $html .= '<tr>';
            $html .= '<td>';
            $html .= $item->short_name;

            if (! empty($item->party_assemblyman)) {
                $html .= ' - '.$item->party_assemblyman->last()->party->prefix;
            }

            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        $html .= '<br>';
        $html .= '<br>';
        $html .= '<strong>VERREADORES AUSENTES ('.$presence->count().')</strong>';
        $html .= '<br>';
        if ($presence->count() > 0) {
            $html .= '<table>';
//            $html .= "<thead><tr><th><strong>VERREADORES AUSENTES (" . $presence->count() .")</strong></th></tr></thead>";
            $html .= '<tbody>';
            foreach ($presence as $item) {
                $html .= '<tr>';
                $html .= '<td>';
                $html .= $item->short_name;
                if (! empty($item->party_assemblyman)) {
                    $html .= ' - '.$item->party_assemblyman->last()->party->prefix;
                }
                $html .= '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '<table>';
        }

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $pdf->Output('ATA.pdf', 'I');
    }

    public function voting($meeting)
    {
        $meeting = Meeting::find($meeting);

        $struct = Structurepautum::where('version_pauta_id', $meeting->version_pauta_id)->pluck('id')->toArray();

        $doc_ids = MeetingPauta::where('meeting_id', $meeting->id)->whereIn('structure_id', $struct)->whereNotNull('document_id')->pluck('document_id')->toArray();
        $law_ids = MeetingPauta::where('meeting_id', $meeting->id)->whereIn('structure_id', $struct)->whereNotNull('law_id')->pluck('law_id')->toArray();
        $advice_ids = MeetingPauta::where('meeting_id', $meeting->id)->whereIn('structure_id', $struct)->whereNotNull('advice_id')->pluck('advice_id')->toArray();

        $docs = Document::whereIn('id', $doc_ids)->get();
        $laws = LawsProject::whereIn('id', $law_ids)->get();
        $advices = Advice::whereIn('id', $advice_ids)->get();

        $doc_voting = Parameters::where('slug', 'realiza-votacao-de-documentos')->first()->value;
        $law_voting = Parameters::where('slug', 'realiza-votacao-em-projeto-de-lei')->first()->value;
        $ata_voting = Parameters::where('slug', 'realiza-votacao-de-ata')->first()->value;
        $advice_voting = Parameters::where('slug', 'realiza-votacao-de-parecer')->first()->value;

        $type_voting = TypeVoting::pluck('name', 'id')->prepend('Selecione', 0);
        $last_voting = Meeting::where('id', '<', $meeting->id)->get()->last();
        if ($meeting->voting()->count() > 0) {
            foreach ($meeting->voting()->where('meeting_id', $meeting->id)->get() as $voting) {
                if ($voting->version_pauta_id == null) {
                    $voting->version_pauta_id = $meeting->version_pauta_id;
                    $voting->save();
                }
            }
        }

        return view('meetings.voting', compact('doc_voting', 'law_voting', 'ata_voting', 'type_voting', 'docs', 'laws', 'last_voting', 'advices', 'advice_voting'))->with('meeting', $meeting);
    }

    public function votingCreate(Request $request)
    {
        $input = request()->except('_token');
        $meeting = Meeting::find($input['meeting_id']);
        $last_voting = Meeting::where('id', '<', $meeting->id)->get()->last();

        $input['meeting_id'] = $meeting->id;

        Parameters::where('slug', 'realiza-votacao-de-documentos')->first()->value;
        Parameters::where('slug', 'realiza-votacao-em-projeto-de-lei')->first()->value;
        $ata_voting = Parameters::where('slug', 'realiza-votacao-de-ata')->first()->value;
        Parameters::where('slug', 'realiza-votacao-de-parecer')->first()->value;

        $type_voting = TypeVoting::pluck('name', 'id')->prepend('Selecione', 0);

        if (Voting::whereNotNull('open_at')->whereNull('closed_at')->first()) {
            flash('Existe votação em aberto!')->warning();

            return redirect(route('meetings.voting', $meeting->id));
//            return view('meetings.voting',
//                compact('voting', 'meeting', 'assemblyman', 'doc_voting', 'law_voting', 'type_voting', 'last_voting', 'ata_voting'));
        }
        $input['version_pauta_id'] = $meeting->version_pauta_id;
        $voting = Voting::firstOrCreate($input);

        $assemblyman = Assemblyman::where('active', 1)->get();

        return view('meetings.start_voting', compact('voting', 'meeting', 'assemblyman', 'last_voting', 'ata_voting'));
    }

    public function votingDocument($meeting_id, $voting_id, $document_id)
    {
        $meeting = Meeting::find($meeting_id);
        $voting = Voting::find($voting_id)->where('document_id', $document_id)->first();

        $assemblyman = Assemblyman::where('active', 1)->get();

        return view('meetings.start_voting', compact('voting', 'meeting', 'assemblyman'));
    }

    public function votingLaw($meeting_id, $voting_id, $law_id)
    {
        $meeting = Meeting::find($meeting_id);
        $voting = Voting::find($voting_id)->where('law_id', $law_id)->first();

        $assemblyman = Assemblyman::where('active', 1)->get();

        return view('meetings.start_voting', compact('voting', 'meeting', 'assemblyman'));
    }

    public function votingAta($meeting_id, $voting_id, $ata_id)
    {
        $meeting = Meeting::find($meeting_id);
        $voting = Voting::find($voting_id)->where('ata_id', $ata_id)->first();
        $assemblyman = Assemblyman::where('active', 1)->get();

        return view('meetings.start_voting', compact('voting', 'meeting', 'assemblyman'));
    }

    public function votingAdvice($meeting_id, $voting_id, $advice_id)
    {
        $meeting = Meeting::find($meeting_id);
        $voting = Voting::find($voting_id)->where('advice_id', $advice_id)->first();
        $assemblyman = Assemblyman::where('active', 1)->get();

        return view('meetings.start_voting', compact('voting', 'meeting', 'assemblyman'));
    }

    public function updateAssemblyman($meeting_id, $voting_id, Request $request)
    {
        $input = $request->all();

        $assemblyman = Assemblyman::find($input['assemblyman_id']);
        $voting = Voting::find($voting_id);

        if ($input['assemblyman_id'] != null) {
            $voting->assemblyman_active = $assemblyman->id;
        } else {
            $voting->assemblyman_active = null;
        }

        if ($voting->save()) {
            return json_encode($assemblyman);
        }

        return json_encode(false);
    }

    public function registerVote(Request $request)
    {
        $input = $request->all();

        $vote = $input['votes'];

        $votes = Votes::firstOrCreate([
            'voting_id' => $input['voting_id'],
            'assemblyman_id' => $input['assemblyman_id'],
        ]);

        $votes->reset();
        $votes->$vote = 1;

        if ($votes->save()) {
            return json_encode(true);
        }

        return json_encode(false);
    }

    public function closeVoting($meeting_id, $voting_id)
    {
        $voting = Voting::find($voting_id);
        $meeting = Meeting::find($meeting_id);

        if ($voting->where('meeting_id', $meeting->id)->whereNull('closed_at')->first()->votes->count() < $meeting->assemblyman()->count()) {
            flash('Existe voto em aberto!')->warning();

            return view('meetings.start_voting', compact('voting', 'meeting', 'assemblyman'));
        } else {
            $voting->closed_at = Carbon::now();
            $voting->assemblyman_active = null;
            $voting->save();
        }

        return redirect(route('meetings.voting', [$meeting->id]));
    }

    public function cancelVoting($meeting_id, $voting_id)
    {
        $voting = Voting::find($voting_id);
        $meeting = Meeting::find($meeting_id);

        $votes = $voting->where('meeting_id', $meeting->id)->first()->votes();

        $votes = Votes::where('voting_id', $voting->id);

        if ($votes->delete()) {
            $voting->delete();
            flash('Votação cancelada!')->warning();
        }

        Assemblyman::where('active', 1)->orderBy('short_name')->get();

        return redirect(route('meetings.voting', $meeting->id));
//        return view('meetings.show', compact('meeting', 'assemblyman'));
    }

    public function painel()
    {
        $company = Auth::user()->company;

        return view('panelVoting.panel', compact('company'));
    }

    public function painelData()
    {
        $data = [];
        $data['status'] = false;

        $voting = Voting::open();

        if ($voting->get()->count() > 0) {
            $data['status'] = true;

            if ($voting->ata_id > 0) {
                $data['name'] = 'ATA - '.$voting->getAta();
            } else {
                if ($voting->advice_id > 0) {
                    $data['name'] = $voting->advice->commission->name.' - '.$voting->getNameAdvice();
                } else {
                    $data['name'] = ($voting->law_id ? $voting->getName() : $voting->getName());
                }
            }
            $name = Assemblyman::find($voting->assemblyman_active);

            if ($name) {
                $data['assemblyman_active']['name'] = $name->short_name.' - '.$name->party_assemblyman()->get()->last()->party->prefix;

                if (isset($name->image) && file_exists(public_path().$name->image)) {
                    $data['assemblyman_active']['image'] = $name->image;
                } else {
                    $data['assemblyman_active']['image'] = '/front/assets/img/sem-foto.jpg';
                }
            } else {
                $data['assemblyman_active']['name'] = '-';
                $data['assemblyman_active']['image'] = '';
            }

            $data['votes']['yes'] = $voting->votes()->get()->sum('yes');
            $data['votes']['no'] = $voting->votes()->get()->sum('no');

            $data['resume']['total'] = $data['votes']['yes'] + $data['votes']['no'];
            $data['resume']['yes'] = $data['votes']['yes'];
            $data['resume']['no'] = $data['votes']['no'];
            $data['resume']['abstention'] = $voting->votes()->get()->sum('abstention');

            foreach ($voting->votes as $key => $vote) {
                $data['list'][$key + 1]['assemblyman'] = $vote->assemblyman->short_name;

                if ($vote->yes) {
                    $data['list'][$key + 1]['vote'] = 'SIM';
                }

                if ($vote->no) {
                    $data['list'][$key + 1]['vote'] = 'NÃO';
                }

                if ($vote->abstention) {
                    $data['list'][$key + 1]['vote'] = 'ABSTENÇÃO';
                }

                if ($vote->out) {
                    $data['list'][$key + 1]['vote'] = 'AUSENTE';
                }
            }
        }

        return json_encode($data);
    }

    public function painelParlamentarData($id)
    {
        $voting = Voting::open();
        $assemblyman = Assemblyman::find($id);

        $data = [];
        $data['status'] = false;
        $data['assemblyman']['name'] = 'PARLAMENTAR - '.$assemblyman->short_name;

        if ($voting->count() > 0) {
            if ($voting->ata_id > 0) {
                $data['name'] = 'ATA - '.$voting->getAta();
            } else {
                if ($voting->advice_id > 0) {
                    $data['name'] = $voting->advice->commission->name.' - '.$voting->getNameAdvice();
                } else {
                    $data['name'] = ($voting->law_id ? $voting->getName() : $voting->getName());
                }
            }

//            $data['name'] = ($voting->law_id ? $voting->getName() : $voting->getName());
            $data['status'] = true;
            $voting->votes()->where('voting_id', $voting->id)->first();

            $meeting = Meeting::find($voting->meeting_id);
            if ($meeting) {
                $data['meeting']['session'] = 'SESSÃO - '.$meeting->number.'/'.Carbon::createFromFormat('d/m/Y H:i', $meeting->date_start)->year;
                $data['meeting']['type'] = 'TIPO - '.$meeting->session_type->name;
            }

            if ($voting->votes()->where('voting_id', $voting->id)->where('assemblyman_id', $assemblyman->id)->count() > 0) {
                $data['assemblyman']['id'] = $assemblyman->id;
            } else {
                $data['assemblyman']['id'] = 0;
            }
        }

        $data['active'] = ! (Meeting::find($voting->meeting_id)->assemblyman()->find($id) == null);

        return json_encode($data);
    }

    public function assemblymanVoting($id)
    {
        $voting = Voting::open();
        $assemblyman = UserAssemblyman::where('users_id', Auth::user()->id)->where('assemblyman_id', $id)->first();

        if ($assemblyman == null) {
            flash('Paralamentar inválido!')->warning();

            return redirect(url('/admin'));
        }

        $ids = UserAssemblyman::where('users_id', Auth::user()->id)->pluck('assemblyman_id')->toArray();
        $assemblyman_list = Assemblyman::whereIn('id', $ids)->pluck('short_name', 'id')->prepend('Selecione', 0);

        if ($voting->get()->count() > 0) {
            $meeting = Meeting::find($voting->meeting_id);
        }

        return view('meetings.assemblyman_vote', compact('meeting', 'voting', 'id', 'assemblyman_list'));
    }

    public function computeVoting(Request $request)
    {
        $input = $request->all();

        $vote = $input['votes'];

        $voting = Voting::open();

        $votes = Votes::firstOrCreate([
            'voting_id' => $voting->id,
            'assemblyman_id' => $input['assemblyman_id'],
        ]);

        $votes->reset();
        $votes->$vote = 1;

        if ($votes->save()) {
            return json_encode(true);
        }

        return json_encode(false);
    }

    public function getVotes()
    {
        $voting = Voting::open();

        if ($voting->count() > 0 && $voting->votes()->get()->count() > 0) {
            return json_encode($voting->votes);
        }

        return json_encode(false);
    }

    public function panelStage($id)
    {
        $meeting = Meeting::find($id);
        $company = Auth::user()->company;
        if ($company) {
            $company->stage = 'default';
            $company->save();
        }

        return view('panelVoting.dashboard', compact('company', 'meeting'));
    }

    public function discourse($id)
    {
        $meeting = Meeting::find($id);

        return view('meetings.discourse', compact('meeting'));
    }

    public function setAssemblyman(Request $request)
    {
        $company = Company::find(Auth::user()->company->id);
        if ($company) {
            $company->assemblyman_id = $request->assemblyman_id;
            $company->meeting_id = $request->meeting_id;
            if ($company->save()) {
                return json_encode($company);
            } else {
                return json_encode(false);
            }
        }
    }

    public function painelDiscourseData()
    {
        $data = [];
        $data['status'] = false;

        $assemblyman = Assemblyman::find(Auth::user()->company->assemblyman_id);
        $meeting = Meeting::find(Auth::user()->company->meeting_id);

        if ($assemblyman && $meeting) {
            $meeting->load('session_type');

            $data['status'] = true;
            $data['meeting'] = $meeting;
            $data['assemblyman_name'] = $assemblyman->short_name.' - '.$assemblyman->party_assemblyman()->get()->last()->party->prefix;
            $data['responsibility'] = $assemblyman->responsibility_assemblyman->last()->responsibility->name;

            if (isset($assemblyman->image) && file_exists(public_path().$assemblyman->image) && $assemblyman->image != '') {
                $data['image'] = $assemblyman->image;
            } else {
                $data['image'] = (new \App\Services\StorageService())->inAssemblymanFolder()
                    ->getPath($assemblyman->image);
            }
        } else {
            $data['status'] = false;
            $data['assemblyman_name'] = '-';
            $data['image'] = (new \App\Services\StorageService())->inAssemblymanFolder()
                ->getPath($assemblyman->image);
            $data['responsibility'] = '-';
        }

        return json_encode($data);
    }

    /*
     * GERAR GRAFICO COM OS VOTOS DA ULTIMA VOTAÇÃO
     */
    public function generateCharts()
    {
        $voting = Voting::lastVoting();

//        if ($voting->count() > 0){
//            return json_encode(false);
//        }else{
//            $voting = Voting::all()->last();
        $votes = $voting->votes()->with('assemblyman')->with('voting')->get();

        if ($voting->ata_id > 0) {
            $name = 'ATA - '.$voting->getAta();
            $votes->prepend($name);
        } else {
            if ($voting->advice_id == 0) {
                $name = $voting->getName();
            } else {
                $name = $voting->advice->commission->name.' - '.$voting->getNameAdvice();
            }
            $votes->prepend($name);
        }

        return json_encode($votes);
//        }
    }

    public function showResume($id)
    {
        $company = Auth::user()->company;
        $voting = Voting::find($id);

        return view('panelVoting.resume_show', compact('company', 'voting'));
    }

    public function generateChartsResume($id)
    {
        $voting = Voting::find($id);

        if (! $voting) {
            return json_encode(false);
        } else {
            $votes = $voting->votes()->with('assemblyman')->with('voting')->get();

            if ($voting->ata_id > 0) {
                $name = 'ATA - '.$voting->getAta();
                $votes->prepend($name);
            } else {
                if ($voting->advice_id == 0) {
                    $name = $voting->getName();
                } else {
                    $name = $voting->advice->commission->name.' - '.$voting->getNameAdvice();
                }

                $votes->prepend($name);
            }

            return json_encode($votes);
        }
    }

    public function panelDefault()
    {
        $company = Auth::user()->company;

        return view('panelVoting.default', compact('company'));
    }

    public function painelVoting()
    {
        $company = Auth::user()->company;

        return view('panelVoting.voting', compact('company'));
    }

    public function painelResume()
    {
        $company = Auth::user()->company;

        return view('panelVoting.resume', compact('company'));
    }

    public function painelDiscourse()
    {
        $company = Auth::user()->company;

        return view('panelVoting.discourse', compact('company'));
    }

    private function initSessions()
    {
        view()->share('session_type_list', SessionType::pluck('name', 'id')->prepend('Selecione', ''));
        view()->share('session_place_list', SessionPlace::pluck('name', 'id')->prepend('Selecione', ''));
    }
}
