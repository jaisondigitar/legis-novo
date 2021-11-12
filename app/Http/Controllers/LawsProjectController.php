<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLawsProjectRequest;
use App\Http\Requests\UpdateLawsProjectRequest;
use App\Models\Advice;
use App\Models\AdvicePublicationLaw;
use App\Models\AdviceSituationLaw;
use App\Models\Assemblyman;
use App\Models\Commission;
use App\Models\Company;
use App\Models\LawFile;
use App\Models\LawProjectsNumber;
use App\Models\LawSituation;
use App\Models\LawsPlace;
use App\Models\LawsProject;
use App\Models\LawsProjectAssemblyman;
use App\Models\LawsStructure;
use App\Models\LawsType;
use App\Models\Log;
use App\Models\MeetingPauta;
use App\Models\Parameters;
use App\Models\PartiesAssemblyman;
use App\Models\StatusProcessingLaw;
use App\Models\StructureLaws;
use App\Models\UserAssemblyman;
use App\Repositories\LawsProjectRepository;
use Artesaos\Defender\Facades\Defender;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Response;

class LawsProjectController extends AppBaseController
{
    /** @var  LawsProjectRepository */
    private $lawsProjectRepository;

    public function __construct(LawsProjectRepository $lawsProjectRepo)
    {
        $this->lawsProjectRepository = $lawsProjectRepo;
    }

    public function getAssemblymenList()
    {
        if (Auth::user()->sector_id == 2) {
            $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)
                ->leftJoin('assemblymen', function ($join) {
                    $join->on('assemblymen.id', '=', 'user_assemblyman.assemblyman_id');
                })
                ->where('assemblymen.active', '=', 1)
                ->get();
        } else {
            $assemblymens = Assemblyman::where('assemblymen.active', '=', 1)->get();
        }

        $assemblymen      = [];
        $assemblymensList = [null => 'Selecione...'];
        foreach ($assemblymens as $assemblyman) {
            $parties                            = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('date', 'DESC')->first();
            $assemblymensList[$assemblyman->id] = $assemblyman->short_name . ' - ' . $parties->party->prefix;
        }

        $assemblymens1 = Assemblyman::where('assemblymen.active', '=', 1)->get();
        foreach ($assemblymens1 as $assemblyman) {
            $parties                       = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('date', 'DESC')->first();
            $assemblymen[$assemblyman->id] = $assemblyman->short_name . ' - ' . $parties->party->prefix;
        }

        return [$assemblymen, $assemblymensList];
    }

    /**
     * Display a listing of the LawsProject.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (!Defender::hasPermission('lawsProjects.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $parameters = Parameters::where('slug', 'sempre-usa-protocolo-externo')->first();

        if (!$parameters->value) {
            $externo = 'readonly';
        } else {
            $externo = '';
        }

        if (count($request->all())) {

            if ($request->parecer) {
                $lawsProjects = LawsProject::join('advices', 'laws_projects_id', '=', 'laws_projects.id')->byDateDesc();
            } else {
                $lawsProjects = LawsProject::byDateDesc();
            }

            !empty($request->reg) ? $lawsProjects->where('updated_at', date('Y-m-d H:i:s', $request->reg)) : null;
            !empty($request->type) ? $lawsProjects->where('law_type_id', $request->type) : null;
            !empty($request->number) ? $lawsProjects->where('project_number', $request->number) : null;
            !empty($request->year) ? $lawsProjects->where('law_date', 'like', $request->year . "%") : null;
            !empty($request->owner) ? $lawsProjects->where('assemblyman_id', $request->owner) : null;

            if (Auth::user()->sector->slug != "gabinete") {

                $lawsProjects = $lawsProjects->paginate(20);

            } else {

                $gabs         = UserAssemblyman::where('users_id', Auth::user()->id)->get();
                $gabIds       = $this->getAssembbyIds($gabs);
                $lawsProjects = $lawsProjects->whereIN('assemblyman_id', $gabIds)->paginate(20);

            }

        } else {

            if (Auth::user()->sector->slug != "gabinete") {

                $lawsProjects = LawsProject::byDateDesc()->paginate(20);

            } else {

                $gabs         = UserAssemblyman::where('users_id', Auth::user()->id)->get();
                $gabIds       = $this->getAssembbyIds($gabs);
                $lawsProjects = LawsProject::whereIN('assemblyman_id', $gabIds)->byDateDesc()->paginate(20);

            }

        }

        $law_places       = LawsPlace::lists('name', 'id')->prepend('Selecione...', '');
        $assemblymensList = $this->getAssemblymenList();

        $references         = LawsProject::all();
        $references_project = [0 => 'Selecione'];
        foreach ($references as $reference) {
            $references_project[$reference->id] = $reference->project_number . '/' . $reference->getYearLaw($reference->law_date . ' - ' . $reference->law_type->name);
        }

        $lawsProjects->parecer = $request->parecer;

        return view('lawsProjects.index', compact('externo'))
            ->with('assemblymensList', $assemblymensList[1])
            ->with('form', $request)
            ->with('lawsProjects', $lawsProjects)
            ->with('references_project', $references_project)
            ->with('law_places', $law_places)
            ->with('voting');
    }

    /**
     * Show the form for creating a new LawsProject.
     *
     * @return Response
     */
    public function create()
    {
        if (!Defender::hasPermission('lawsProjects.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $assemblymensList = $this->getAssemblymenList();

        $law_types              = LawsType::where('is_active', true)->lists('name', 'id')->prepend('Selecione...', '');
        $situation              = LawSituation::lists('name', 'id')->prepend('Selecione...', '');
        $advice_situation_law   = AdviceSituationLaw::lists('name', 'id')->prepend('Selecione...', '');
        $advice_publication_law = AdvicePublicationLaw::lists('name', 'id')->prepend('Selecione...', '');
        $status_processing_law  = StatusProcessingLaw::lists('name', 'id')->prepend('Selecione...', '');

        $comission = Commission::lists('name', 'id')->prepend('Selecione', 0);

        $references         = LawsProject::all();
        $references_project = [0 => 'Selecione'];
        foreach ($references as $reference) {
            $references_project[$reference->id] = $reference->project_number . '/' . $reference->getYearLaw($reference->law_date . ' - ' . $reference->law_type->name);
        }

        $lawsProject = new LawsProject();
        return view('lawsProjects.create')->with(compact('status_processing_law', 'comission', 'lawsProject', 'law_types', 'situation', 'law_places', 'law_structure', 'advice_situation_law', 'advice_publication_law'))
            ->with('assemblymen', $assemblymensList[0])
            ->with('references_project', $references_project)
            ->with('assemblymensList', $assemblymensList[1]);
    }

    /**
     * Store a newly created LawsProject in storage.
     *
     * @param CreateLawsProjectRequest $request
     *
     * @return Response
     */
    public function store(CreateLawsProjectRequest $request)
    {
        if (!Defender::hasPermission('lawsProjects.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $input = $request->all();

        $input['town_hall'] = isset($input['town_hall']) ? 1 : 0;

        $lawsProject = $this->lawsProjectRepository->create($input);

        if (!empty($input['assemblymen'])) {
            foreach ($input['assemblymen'] as $assemblyman) {
                $lawsProjectAssemblyman                 = new LawsProjectAssemblyman();
                $lawsProjectAssemblyman->law_project_id = $lawsProject->id;
                $lawsProjectAssemblyman->assemblyman_id = $assemblyman;
                $lawsProjectAssemblyman->save();
            }
        }

        if ($request->file('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName  = 'law_' . $lawsProject->id . '.' . $extension;
            if ($request->file('file')->move('laws', $fileName)) {
                $lawsProject->file = $fileName;
                $lawsProject->save();
            }
        }

        if ($request->file('law_file')) {
            $extension = $request->file('law_file')->getClientOriginalExtension();
            $fileName  = 'law_file_' . $lawsProject->id . '.' . $extension;
            if ($request->file('law_file')->move('laws', $fileName)) {
                $lawsProject->law_file = $fileName;
                $lawsProject->save();
            }
        }

        $law_number                  = new LawProjectsNumber();
        $law_number->laws_project_id = $lawsProject->id;
        $law_number->date            = $lawsProject->updated_at;
        $law_number->save();

        flash('LawsProject saved successfully.')->success();

        return redirect(route('lawsProjects.index'));

    }

    public function advices($lawProjectId)
    {
        setlocale(LC_ALL, 'pt_BR');
        $lawsProject = $this->lawsProjectRepository->findWithoutFail($lawProjectId);

        if (empty($lawsProject)) {
            flash('LawsProject not found')->error();

            return redirect(route('lawsProjects.index'));
        }

        $comission  = Commission::active()->lists('name', 'id');
        $tramitacao = Parameters::where('slug', 'realiza-tramite-em-projetos')->first()->value;

        $advice_situation_law   = AdviceSituationLaw::lists('name', 'id')->prepend('Selecione...', '');
        $advice_publication_law = AdvicePublicationLaw::lists('name', 'id')->prepend('Selecione...', '');
        $status_processing_law  = StatusProcessingLaw::lists('name', 'id')->prepend('Selecione...', '');

        return view('lawsProjects.advices', compact('comission', 'tramitacao', 'advice_situation_law', 'advice_publication_law', 'status_processing_law'))->with(compact('lawsProject'));

    }

    public function getResponsability($assemblyman, $date)
    {
        $achou = 0;
        foreach ($assemblyman->assemblyman->responsibility_assemblyman()->orderBy('date', 'desc')->get() as $item) {
            $date1 = explode('/', $item->date);
            $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            if (strtotime($date1) <= strtotime($date) && $achou == 0) {
                $achou = 1;
                $resp  = $item->responsibility->name . "(a) ";
            } else {
                $resp = 'Vereador(a)';
            }
        }

        return $resp;

    }

    /**
     * Display the specified LawsProject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

//        if (!Defender::hasPermission('lawsProjects.show')) {
        //            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning(;
        //            return redirect("/");
        //        }

        $lawsProject = LawsProject::find($id);

        if (empty($lawsProject)) {
            flash('LawsProject not found')->error();

            return redirect(route('lawsProjects.index'));
        }

        // load Parameters
        $showAdvices    = Parameters::where('slug', 'mostra-historico-de-tramites-no-front')->first()->value;
        $showHeader     = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader   = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;
        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;
        $tramitacao     = Parameters::where('slug', 'exibe-detalhe-de-tramitacao')->first()->value;
        $votacao        = Parameters::where('slug', 'mostra-votacao-em-projeto-de-lei')->first()->value;

        require_once public_path() . '/tcpdf/mypdf.php';

        $pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setFooterData($lawsProject->getNumberLaw(), array(0, 64, 0), array(0, 64, 128));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda, $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(true, $margemInferior + 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 11, '', true);
        $pdf->SetTitle($lawsProject->name);

        $pdf->AddPage();

        $pdf->setListIndentWidth(5);

        $assemblymen = LawsProjectAssemblyman::where('law_project_id', $lawsProject->id)->orderBy('id')->get();
        $date        = explode('/', $lawsProject->law_date);
        $date        = $date[2] . '-' . $date[1] . '-' . $date[0];

        $list       = [];
        $list[0][0] = $lawsProject->owner->short_name;
        $list[0][1] = count($lawsProject->owner->responsibility_assemblyman) > 1 ? $lawsProject->owner->responsibility_assemblyman()->where('date', '<=', $date)->get()->last()->responsibility->name . "(a) " : $lawsProject->owner->responsibility_assemblyman()->first()->responsibility->name . "(a) ";

        if (!empty($assemblymen)) {
            foreach ($assemblymen as $key => $assemblyman) {
                $list[$key + 1][0] = $assemblyman->assemblyman->short_name;
                if (count($assemblyman->assemblyman->responsibility_assemblyman) > 1) {
                    $list[$key + 1][1] = $this->getResponsability($assemblyman, $date);
                } else {
                    $list[$key + 1][1] = count($assemblyman->assemblyman->responsibility_assemblyman) == 0 ? '-' : $assemblyman->assemblyman->responsibility_assemblyman()->first()->responsibility->name . "(a) ";
                }
            }
        }

        $html  = "";
        $count = 0;

        if (count($list) == 1) {
            $html .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
            $html .= "<tr style=\"height: 300px\">";
            $html .= "<td style=\"width:25%;\"></td>";
            $html .= "<td style=\"width:50%; text-align: center; border-top: 1px solid #000000; vertical-align: text-top\">" . $list[0][0] . "<br>" . $list[0][1] . "<br><br><br></td>";
            $html .= "<td style=\"width:25%;\"></td>";
            $html .= "</tr>";
            $html .= "</tbody></table>";
        } else {
            $html .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\"position:absolute; width: 100%; margin-top: 300px\"><tbody>";
            foreach ($list as $vereador) {
                if ($count == 0) {
                    $html .= "<tr style=\"height: 300px\">";
                }

                $html .= "<td style=\"text-align: center; border-top: 1px solid #000000; vertical-align: text-top\">" . $vereador[0] . "<br>" . $vereador[1] . "<br><br><br></td>";

                if ($count == 2 || $vereador === end($list)) {
                    $html .= "</tr>";
                    $count = 0;
                } else {
                    $count++;
                }

            }
            $html .= "</tbody></table>";
        }

        $structure = StructureLaws::where('law_id', $lawsProject->id)->isRoot()->get();
        $content   = "<h3 style=\"text-align: center\">" . mb_strtoupper($lawsProject->law_type->name, 'UTF-8') . " " . $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) . "</h3>";
//        $content .= "<span><strong>DATA DO PROJETO:</strong> " . strftime('%d/%m/%Y', strtotime(Carbon::createFromFormat('d/m/Y', $lawsProject->law_date))) . "</span><br>";

        $content .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
        $content .= "<tr style=\"height: 300px\">";
        $content .= "<td style=\"width:25%;\"></td>";
        $content .= "<td style=\"width:15%;\"></td>";
        $content .= "<td style=\"width:65%; text-align: justify; text-justify: inter-word \">" . $lawsProject->title . "</td>";
        $content .= "</tr>";
        $content .= "</tbody></table>";

        $content .= "<br>";

        $content .= "<p>" . ($lawsProject->sub_title) . "</p>";

        $content .= "<p><ul style='list-style-type:none; list-style: none;counter-reset: num; margin-bottom: 300px'>";

        //dd($structure);

        foreach ($structure as $reg) {
            $content .= $this->renderNode($reg, 0, 0);
        }

        $content .= "</ul></p>";

        $content .= "<br><br>";
        $content .= "<p>" . ($lawsProject->sufix) . "</p>";

        $lawsProject->situation_id1          = $lawsProject->advice_situation_id > 0 ? $lawsProject->adviceSituationLaw->name : '-';
        $lawsProject->advice_publication_id1 = $lawsProject->advice_publication_id > 0 ? $lawsProject->advicePublicationLaw->name : '-';
        $lawsProject->observation            = $lawsProject->observation == null ? '-' : $lawsProject->observation;

        $data_USA = explode(' ', ucfirst(iconv('ISO-8859-1', 'UTF-8', strftime('%d de %B de %Y', strtotime(Carbon::createFromFormat('d/m/Y', $lawsProject->law_date))))));

        $mes['January']   = 'Janeiro';
        $mes['February']  = 'Fevereiro';
        $mes['March']     = 'Março';
        $mes['April']     = 'Abril';
        $mes['May']       = 'Maio';
        $mes['June']      = 'Junho';
        $mes['July']      = 'Julho';
        $mes['August']    = 'Agosto';
        $mes['September'] = 'Setembro';
        $mes['October']   = 'Outubro';
        $mes['November']  = 'Novembro';
        $mes['December']  = 'Dezembro';

        $mes_pt    = isset($mes[$data_USA[2]]) ? $mes[$data_USA[2]] : $data_USA[2];
        $data_ptbr = $data_USA[0] . ' ' . $data_USA[1] . ' ' . $mes_pt . ' ' . $data_USA[3] . ' ' . $data_USA[4];

        $dataProject = $data_ptbr;

        $cidade = Company::first()->getCity->name . "/" . Company::first()->getState->uf;

        $content .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
        $content .= "<tr style=\"height: 300px\">";
        $content .= "<td style=\"width:25%;\"></td>";
        $content .= "<td style=\"width:75%; text-align: right\">" . $cidade . ", " . $dataProject . "</td>";
        $content .= "</tr>";
        $content .= "</tbody></table>";

        if ($lawsProject->comission) {
            $content .= "<span style=\"width:75%; text-align: center\"> " . $lawsProject->comission->name . "</span>";
        }
        $content .= "<br><br><br><br>" . $html;

        $pdf->writeHTML($content);

        if ($tramitacao && $lawsProject->processing()->orderBy('processing_date', 'desc')->count() > 0) {

            $pdf->AddPage();
            $pdf->setListIndentWidth(5);

            $html1 = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css\" rel=\"stylesheet\" >";

            $html1 .= "<h3 style=\"width:100%; text-align: center;\"> Tramitação </h3>";
            $html1 .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \">";

            $html1 .= "<tbody>";
            foreach ($lawsProject->processing()->orderBy('processing_date', 'desc')->get() as $processing) {
                $html1 .= "<hr>";
                $html1 .= "<tr style=\" text-align: left;\">";
                $html1 .= "<td width=\"100\" style=\" text-align: left;\"><b>Data: </b> <br>" . $processing->processing_date . "</td>";
                if ($processing->advicePublicationLaw) {
                    $html1 .= "<td width=\"120\" style=\" text-align: left;\"><b>Publicado no: </b> <br>" . $processing->advicePublicationLaw->name . " </td>";
                }
                $html1 .= "<td width=\"150\" style=\" text-align: left;\"><b>Situação do projeto: </b> <br>" . $processing->adviceSituationLaw->name . "</td>";
                if ($processing->statusProcessingLaw) {
                    $html1 .= "<td width=\"150\" style=\" text-align: left;\"><b>Status do tramite: </b> <br>" . $processing->statusProcessingLaw->name . "</td>";
                }
                $html1 .= "</tr>";
                if (strlen($processing->obsevation) > 0) {
                    $html1 .= "<tr>";
                    $html1 .= "<td width=\"650\" style=\" text-align: justify; \"><b>Observação: </b> <br>" . $processing->obsevation . "</td>";
                    $html1 .= "</tr>";
                }
            }
            $html1 .= "</tbody></table>";

            $pdf->writeHTML($html1);
        }

//        if ($tramitacao) {
        //            $pdf->AddPage();
        //            $pdf->setListIndentWidth(5);
        //            $html2 = "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
        //            $html2 .= "<tr style=\"height: 300px\">";
        //            $html2 .= "<td style=\"width:100%; text-align: center;\"><h3> Detalhes da tramitação </h3></td>";
        //            $html2 .= "</tr>";
        //            $html2 .= "</tbody></table>";
        //            $html2 .= "<table style=\" text-align: left;\">";
        //            $html2 .= "<tr style=\" text-align: left;\">";
        //            $html2 .= "<td style=\" text-align: left;\">Publicado: " . $lawsProject->advice_publication_id1 . "</td>";
        //            $html2 .= "<td style=\" text-align: left;\">Situação do projeto: ". $lawsProject->situation_id1 ."</td>";
        //            $html2 .= "<td style=\" text-align: left;\">Data ao plenário: ". $lawsProject->date_presentation ."</td>";
        //            $html2 .= "</tr>";
        //            $html2 .= "<br>";
        //            $html2 .= "<tr style=\" text-align: left; \">";
        //            $html2 .= "<td style=\" text-align: left;\">Parecer: ". $lawsProject->advice_date ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\">Primeira discussão: ". $lawsProject->first_discussion ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\">Segunda discussão: ". $lawsProject->second_discussion ." </td>";
        //            $html2 .= "</tr>";
        //            $html2 .= "<br>";
        //            $html2 .= "<tr style=\" text-align: left; \">";
        //            $html2 .= "<td style=\" text-align: left;\">Terceira discussão: ". $lawsProject->third_discussion ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\">Única discussão: ". $lawsProject->single_discussion ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\"> Urgência especial: ". $lawsProject->special_urgency ." </td>";
        //            $html2 .= "</tr>";
        //            $html2 .= "<br>";
        //            $html2 .= "<tr style=\" text-align: left; \">";
        //            $html2 .= "<td style=\" text-align: left;\">Aprovado: ". $lawsProject->approved ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\">Sancionado: ". $lawsProject->sanctioned ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\">Promulgado: ". $lawsProject->Promulgated ." </td>";
        //            $html2 .= "</tr>";
        //            $html2 .= "<br>";
        //            $html2 .= "<tr style=\" text-align: left; \">";
        //            $html2 .= "<td style=\" text-align: left;\">Rejeitado: ". $lawsProject->Rejected ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\">Vetado: ". $lawsProject->Vetoed ." </td>";
        //            $html2 .= "<td style=\" text-align: left;\">Arquivado: ". $lawsProject->Filed ." </td>";
        //            $html2 .= "</tr>";
        //            $html2 .= "<br>";
        //            $html2 .= "<tr style=\" text-align: left; \">";
        //            $html2 .= "<td style=\" text-align: left;\">Mantido: ". $lawsProject->sustained ." </td>";
        //            $html2 .= "</tr>";
        //            $html2 .= "<br>";
        //            $html2 .= "<tr style=\" text-align: left; width: 100%;\">";
        //            $html2 .= "<td style=\" text-align: left; width: 100%;\">Observação: " . $lawsProject->observation . " </td>";
        //
        //            $html2 .= "</tr>";
        //
        //            $html2 .= "</table>";
        //            $html2 .= "<br>";
        //            $pdf->writeHTML($html2);
        //        }

        if ($votacao && $lawsProject->voting()->get()->count() > 0) {
            $pdf->AddPage();
            $pdf->setListIndentWidth(5);
            $html2 = "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
            $html2 .= "<tr style=\"height: 300px\">";
            $html2 .= "<td style=\"width:100%; text-align: center;\"><h3> Votação </h3></td>";
            $html2 .= "</tr>";
            $html2 .= "</tbody></table>";
            $html2 .= "<table style=\" text-align: left;\">";
            foreach ($lawsProject->voting()->get() as $item) {
                $html2 .= "<tr style=\" text-align: left;\">";
                $html2 .= "<td style=\" text-align: left;\">Data da votação: " . date("d/m/Y", strtotime($item->open_at)) . "</td>";
                $html2 .= "<td style=\" text-align: left;\">Situação: ";
                if ($item->situation($item)) {
                    $html2 .= 'Votação Aprovada';
                } else {
                    $html2 .= 'Votação Reprovada';
                }
                $html2 .= "</td>";
                $html2 .= '<br>';
                $html2 .= "</tr>";
            }

            $html2 .= "</table>";
            $html2 .= "<br>";
            $pdf->writeHTML($html2);
        }

        if ($lawsProject->justify) {
            $pdf->AddPage();
            $pdf->setListIndentWidth(5);
            $content = "<p>" . $lawsProject->justify . "</p>";

            $html = "<table cellspacing=\"10\" cellpadding=\"10\" style=\"width:100%;  \"><tbody>";
            $html .= "<tr style=\"height: 300px\">";
            $html .= "<td style=\"width:25%;\"></td>";
            $html .= "<td style=\"width:50%; text-align: center; border-top: 1px solid #000000; vertical-align: text-top\">" . $list[0][0] . "<br>" . $list[0][1] . "<br><br><br></td>";
            $html .= "<td style=\"width:25%;\"></td>";
            $html .= "</tr>";
            $html .= "</tbody></table>";

            $content .= "<div>" . $html . "</div>";

            $pdf->writeHTML($content);
        }

        if ($showAdvices) {
            $advices = $this->loadAdvices($pdf, $id);

        }

        //return $content;

        $pdf->Output('Projeto de lei.pdf', 'I');

        die();
        return view('lawsProjects.show')->with('lawsProject', $lawsProject);
    }

    public function loadAdvices($pdf, $lawsProjectId)
    {

        $advices = \App\Models\Advice::where('laws_projects_id', $lawsProjectId)->get();

        if (!$advices) {
            $pdf->AddPage();
            $pdf->setListIndentWidth(5);
            $content = "<h4 style=\"text-align: center\">nenhum trâmite para este documento</h4>";
            $pdf->writeHTML($content);
        } else {
            $this->printAdvices($advices, $pdf);
        }

    }

    protected function printAdvices($advices, $pdf)
    {
        $return = "";

        foreach ($advices as $advice) {

            $pdf->AddPage();
            $pdf->setListIndentWidth(5);

            $return = "<h3 style=\"text-align: center\">" . mb_strtoupper($advice->destination->name, 'UTF-8') . "</h3>";
            $return .= "<p><strong>Solicitação: </strong>" . $advice->date . "<br><strong>Descrição: </strong>" . $advice->description . "</p>";

            foreach ($advice->awnser as $resp) {
                $resp->commission_situation = $resp->commission_situation ? $resp->commission_situation->name : '';

                $return .= "<div style=\"border: 1px solid #000000; padding-left: 10px \">";
                $return .= "<strong>Data: </strong> " . $resp->date . "<br>";
                $return .= "<strong>Situação: </strong> " . $resp->commission_situation . "<br>";
                $return .= trim($resp->description);
                $return .= "</div>";
            }
            $pdf->writeHTML($return);
        }

    }

    private function renderNode($node, $index = 0, $level = 0)
    {
        $html = "";

        if ($node->isLeaf()) {
            if ($node->depth > 0) {
                $html = '<li style="list-style-type:none; list-style: none; line-height: 2"><strong>' .
                (isset($node->type) ? $node->type->showName() : '')
                . ' '
                . ($node->number ? $node->number : '')
                . "</strong> - "
                . $node->content;

                $html .= '</li>';
            }
            return $html;
        } else {
            $html = "";
            //if($node->depth>0){
            if (!$node->isRoot()) {
                $html .= '<li style="list-style-type:none; list-style: none; line-height: 2"><strong>' . (isset($node->type) ? $node->type->showName() : '') . ' ' . ($node->number ? $node->number : '') . "</strong> - " . $node->content;
            }
            //}

            $html .= '<ul style="list-style-type:none; list-style: none;display:block">';

            foreach ($node->children as $child) {
                $html .= $this->renderNode($child, $index, $level);
            }

            $html .= '</ul>';
            $html .= '</li>';
        }

        return $html;
    }
    /**
     * Show the form for editing the specified LawsProject.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!Defender::hasPermission('lawsProjects.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $lawsProject = $this->lawsProjectRepository->findWithoutFail($id);

        if (empty($lawsProject)) {
            flash('LawsProject not found')->error();

            return redirect(route('lawsProjects.index'));
        }

        $assemblymensList = $this->getAssemblymenList();

        $lawsAssemblyman = LawsProjectAssemblyman::where('law_project_id', $id)->lists('assemblyman_id');

        $law_types              = LawsType::where('is_active', true)->lists('name', 'id')->prepend('Selecione...', '');
        $law_places             = LawsPlace::lists('name', 'id')->prepend('Selecione...', '');
        $law_structure          = LawsStructure::lists('name', 'id')->prepend('Selecione...', '');
        $situation              = LawSituation::lists('name', 'id')->prepend('Selecione...', '');
        $advice_situation_law   = AdviceSituationLaw::lists('name', 'id')->prepend('Selecione...', '');
        $advice_publication_law = AdvicePublicationLaw::lists('name', 'id')->prepend('Selecione...', '');
        $status_processing_law  = StatusProcessingLaw::lists('name', 'id')->prepend('Selecione...', '');
        $comission              = Commission::lists('name', 'id')->prepend('Selecione', 0);

        $references         = LawsProject::all();
        $references_project = [0 => 'Selecione'];
        foreach ($references as $reference) {
            $references_project[$reference->id] = $reference->project_number . '/' . $reference->getYearLaw($reference->law_date . ' - ' . $reference->law_type->name);
        }
        $tramitacao = Parameters::where('slug', 'realiza-tramite-em-projetos')->first()->value;
        $logs       = Log::where('owner_id', $lawsProject->id)->where('owner_type', LawsProject::class)->orderBy('created_at', 'desc')->get();
        return view('lawsProjects.edit')->with(compact('logs', 'status_processing_law', 'tramitacao', 'comission', 'situation', 'lawsProject', 'law_types', 'law_places', 'law_structure', 'lawsAssemblyman', 'references_project', 'advice_situation_law', 'advice_publication_law'))
            ->with('assemblymen', $assemblymensList[0])
            ->with('assemblymensList', $assemblymensList[1]);
    }

    /**
     * Update the specified LawsProject in storage.
     *
     * @param  int              $id
     * @param UpdateLawsProjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLawsProjectRequest $request)
    {
        if (!Defender::hasPermission('lawsProjects.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsProject = $this->lawsProjectRepository->findWithoutFail($id);

        if (empty($lawsProject)) {
            flash('LawsProject not found')->error();

            return redirect(route('lawsProjects.index'));
        }

        $input = $request->all();

        $input['town_hall'] = isset($input['town_hall']) ? 1 : 0;

        $lawsProject = $this->lawsProjectRepository->update($input, $id);
        $lawsProject = $this->lawsProjectRepository->findWithoutFail($id);

        LawsProjectAssemblyman::where('law_project_id', $id)->delete();

        if (!empty($request['assemblymen'])) {
            foreach ($request['assemblymen'] as $assemblyman) {
                $lawsProjectAssemblyman                 = new LawsProjectAssemblyman();
                $lawsProjectAssemblyman->law_project_id = $lawsProject->id;
                $lawsProjectAssemblyman->assemblyman_id = $assemblyman;
                $lawsProjectAssemblyman->save();
            }
        }

        if ($request->file('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName  = 'law_' . $id . '.' . $extension;
            if ($request->file('file')->move('laws', $fileName)) {
                $lawsProject->file = $fileName;
                $lawsProject->save();
            }
        }

        if ($request->file('law_file')) {
            $extension = $request->file('law_file')->getClientOriginalExtension();
            $fileName  = 'law_file_' . $lawsProject->id . '.' . $extension;
            if ($request->file('law_file')->move('laws', $fileName)) {
                $lawsProject->law_file = $fileName;
                $lawsProject->save();
            }
        }

        $law_number                  = new LawProjectsNumber();
        $law_number->laws_project_id = $lawsProject->id;
        $law_number->date            = $lawsProject->updated_at;
        $law_number->save();

        flash('LawsProject updated successfully.')->success();

        return redirect(route('lawsProjects.index'));
    }

    /**
     * Remove the specified LawsProject from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!Defender::hasPermission('lawsProjects.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsProject = $this->lawsProjectRepository->findWithoutFail($id);

        if (empty($lawsProject)) {
            flash('LawsProject not found')->error();

            return redirect(route('lawsProjects.index'));
        }

        if (MeetingPauta::where('law_id', $lawsProject->id)->get()->count() > 0) {
            flash('Registro em uso, não pode ser removido!')->error();

            return redirect(route('lawsProjects.index'));
        }

        $this->lawsProjectRepository->delete($id);

        flash('LawsProject deleted successfully.')->success();

        return redirect(route('lawsProjects.index'));
    }

    /**
     * Update status of specified LawsProject from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (!Defender::hasPermission('lawsProjects.edit')) {
            return json_encode(false);
        }
        $register         = $this->lawsProjectRepository->findWithoutFail($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }

    /**
     * @param $id
     * @return string
     */
    public function toggleRead($id)
    {
        if (!Defender::hasPermission('lawsProject.read')) {
            return json_encode(false);
        }
        $register          = $this->lawsProjectRepository->findWithoutFail($id);
        $register->is_read = $register->is_read == 0 ? 1 : 0;
        $register->save();
        return json_encode(true);
    }

    /**
     * @param $id
     * @return string
     */
    public function toggleApproved($id)
    {
        if (!Defender::hasPermission('lawsProject.approved')) {
            return json_encode(false);
        }
        $register = $this->lawsProjectRepository->findWithoutFail($id);

        $register->is_ready = $register->is_ready == 0 ? 1 : 0;
        $register->save();
        dd($register);
        return json_encode(true);
    }

    public function lawProjectNextNumber($law_type)
    {
        $next_number = LawsProject::where('law_type_id', $law_type)->orderBy('project_number', 'DESC')->first();

        if ($next_number) {
            $next_number = $next_number->project_number + 1;
        } else {
            $next_number = 1;
        }

        return $next_number;
    }

    public function lawProjectApproved($id)
    {
        $lawProject = LawsProject::find($id);

        $year = explode('/', $lawProject->law_date);
        $year = $year[2];

        $last_document = LawsProject::where('law_type_id', $lawProject->law_type_id)
            ->whereYear('law_date_publish', '=', $year)
            ->where('law_number', '!=', '')
            ->orderBy('law_number', 'DESC')
            ->first();

        if ($last_document) {
            $next_number = $last_document->law_number + 1;
            $data        = ['law_project_id' => $id, 'next_number' => $next_number, 'year' => $year];
            return ['success' => 'true', 'data' => $data];
        } else {
            $next_number = 1;
            $data        = ['law_project_id' => $id, 'next_number' => $next_number, 'year' => $year];
            return ['success' => 'false', 'data' => $data];
        }
    }

    public function lawsProjectApprovedSave()
    {
        $input = Input::all();

        $lawProject = LawsProject::find($input['law_project_id']);

        $year = explode('/', $lawProject->law_date);
        $year = $year[2];

        $parameter = Parameters::where('slug', 'permitir-criar-numero-de-lei-fora-da-sequencia')->first();

        if ($parameter->value == 0) {
            $lawProject_verify = LawsProject::where('law_type_id', $lawProject->law_type_id)
                ->whereYear('law_date_publish', '=', $year)
                ->where('law_number', '>=', $input['law_number'])
                ->orderBy('law_number', 'DESC')
                ->first();
        } else {
            $lawProject_verify = LawsProject::where('law_type_id', $lawProject->law_type_id)
                ->whereYear('law_date_publish', '=', $year)
                ->where('law_number', '=', $input['law_number'])
                ->orderBy('law_number', 'DESC')
                ->first();
        }

        if ($lawProject_verify) {
            $next_number = $lawProject_verify->law_number + 1;
            return ['success' => false, 'message' => 'Número já utilizado ou inferior ao último, a sua sugestão foi atualizada!', 'next_number' => $next_number];
        } else {
            $lawProject->law_number       = $input['law_number'];
            $lawProject->law_date_publish = $input['date_publish'];
            $lawProject->law_place_id     = $input['law_place_id'];
            $lawProject->is_ready         = 1;
            $lawProject->save();

            return ['success'         => true,
                'message'                 => 'Projeto de lei aprovado com sucesso!',
                'lawProject_id'           => $lawProject->id,
                'lawProject_place'        => $lawProject->law_place->name,
                'lawProject_date_publish' => $lawProject->law_date_publish,
                'law_number'              => $lawProject->law_number,
                'year'                    => $year,
            ];

        }
    }

    public function lawProjectProtocol($id)
    {
        $protocol_number = substr(md5(uniqid(mt_rand(), true)), 0, 8);

        $law_project = LawsProject::find($id);

        $year = explode('/', $law_project->law_date);
        $year = $year[2];

        $law_projects = LawsProject::where('law_type_id', $law_project->law_type_id)
            ->whereYear('law_date', '=', $year)
            ->orderBy('project_number', 'DESC')
            ->first();

        if ($law_projects) {
            $project_number = $law_projects->project_number + 1;
        } else {
            $project_number = 1;
        }

        return ['success' => true,
            'lawProject_id'   => $id,
            'project_number'  => $project_number,
            'protocol'        => $protocol_number,
        ];
    }

    public function lawsProjectProtocolSave()
    {
        $params = Input::all();

        $law_project = LawsProject::find($params['law_project_id']);

        $year = explode('/', $law_project->law_date);
        $year = $year[2];

        $parameter            = Parameters::where('slug', 'permitir-criar-numero-de-projetos-de-lei-fora-da-sequencia')->first();
        $parameterAssemblyman = Parameters::where('slug', 'permitir-criar-numero-de-projetos-e-documentos-para-mesmo-vereadores')->first();

        if ($parameter->value == 0) {
            $verify = LawsProject::where('law_type_id', $law_project->law_type_id)
                ->whereYear('law_date', '=', $year);

            if ($parameterAssemblyman->value == 1) {
                $verify = $verify->where('assemblyman_id', $law_project->assemblyman_id);
            }

            $verify = $verify->where('project_number', '>=', $params['project_number'])
                ->orderBy('project_number', 'DESC')
                ->first();
        } else {
            $verify = LawsProject::where('law_type_id', $law_project->law_type_id)
                ->whereYear('law_date', '=', $year);

            if ($parameterAssemblyman->value == 1) {
                $verify = $verify->where('assemblyman_id', $law_project->assemblyman_id);
            }

            $verify = $verify->where('project_number', '=', $params['project_number'])
                ->orderBy('project_number', 'DESC')
                ->first();
        }

        if ($verify) {
            $next_number = $verify->project_number + 1;
            return ['success' => false, 'message' => 'Número já utilizado ou inferior ao último, a sua sugestão foi atualizada!', 'next_number' => $next_number];
        } else {

            $law_project->project_number = $params['project_number'];
            $law_project->protocol       = $params['protocol'];
            $law_project->protocoldate   = $params['protocoldate'];
            $law_project->save();
            return [
                'success'        => true,
                'lawProject_id'  => $law_project->id,
                'project_number' => $law_project->project_number,
                'year'           => $year,
            ];
        }

    }

    public function addStructure($id)
    {

    }

    public function lawsProjectStructure($id)
    {
        $law_project          = LawsProject::find($id);
        $laws_structure_types = LawsStructure::lists('name', 'id');
        $structure_laws       = StructureLaws::where('law_id', $id)->isRoot()->get();

        if (count($structure_laws) == 0) {
            $data = [
                'law_id'           => $id,
                'law_structure_id' => 0,
                'parent_id'        => null,
                'order'            => 0,
                'number'           => 0,
                'content'          => "Estrutura do projeto de lei",
            ];
            $create = StructureLaws::firstOrCreate($data);
            $create->makeRoot();
            $structure_laws = StructureLaws::where('law_id', $id)->isRoot()->get();
        }

        return view('lawsProjects.structure', compact(
            'law_project',
            'laws_structure_types',
            'structure_laws'
        )
        );
    }

    public function deleteBash(Request $request)
    {
        $input = $request->all();

        LawsProject::destroy($input['ids']);

        return json_encode($input['ids']);
    }

    public function getNumProt(Request $request)
    {

        $input = $request->all();
        $obj   = LawsProject::find($input['id']);
        if ($obj) {
            return json_encode($obj);
        }

        return json_encode(false);
    }

    public function saveProtocolNumber(Request $request)
    {

        $input = $request->all();
        $flag  = 0;

        $date = $input['protocoldate'];

        $ano = explode('/', $date);

        $law_project = LawsProject::find($input['id']);

        $validaProtocolo = LawsProject::where('protocol', $input['protocol'])->whereYear('protocoldate', '=', $ano[2])->get();
        $validaNumero    = LawsProject::where('project_number', $input['number'])->whereYear('law_date', '=', $ano[2])->where('law_type_id', $law_project->law_type_id)->get();

        if (count($validaProtocolo) == 0) {

            $obj                 = LawsProject::find($input['id']);
            $obj->project_number = $input['number'];
            $obj->protocol       = $input['protocol'];
            $obj->protocoldate   = $input['protocoldate'];

            if ($obj->save()) {
                $flag = 1;
            }
        }

        if (count($validaNumero) == 0) {

            $obj                 = LawsProject::find($input['id']);
            $obj->project_number = $input['number'];
            $obj->protocol       = $input['protocol'];
            $obj->protocoldate   = $input['protocoldate'];

            if ($obj->save()) {
                $flag = 1;
            }
        }

        if ($flag) {
            return json_encode($obj);
        }

        return json_encode(false);
    }

    public function numberGetApproved(Request $request)
    {

        $lawproject = LawsProject::find($request->id);

        if ($lawproject) {
            return json_encode($lawproject);
        }

        return json_encode(false);

    }

    public function numberEditApproved(Request $request)
    {

        $input = $request->all();

        $lawProject = LawsProject::find($input['law_project_id']);

        $year = explode('/', $lawProject->law_date);
        $year = $year[2];

        $parameter = Parameters::where('slug', 'permitir-criar-numero-de-lei-fora-da-sequencia')->first();

        if ($parameter->value == 0) {
            $lawProject_verify = LawsProject::where('law_type_id', $lawProject->law_type_id)
                ->whereYear('law_date_publish', '=', $year)
                ->where('law_number', '>=', $input['law_number'])
                ->orderBy('law_number', 'DESC')
                ->first();
        } else {
            $lawProject_verify = LawsProject::where('law_type_id', $lawProject->law_type_id)
                ->whereYear('law_date_publish', '=', $year)
                ->where('law_number', '=', $input['law_number'])
                ->orderBy('law_number', 'DESC')
                ->first();
        }

        if ($lawProject_verify) {
            $next_number = $lawProject_verify->law_number + 1;
            return ['success' => false, 'message' => 'Número já utilizado ou inferior ao último, a sua sugestão foi atualizada!', 'next_number' => $next_number];
        } else {
            $lawProject->law_number       = $input['law_number'];
            $lawProject->law_date_publish = $input['law_date_publish'];
            $lawProject->save();

            return ['success'         => true,
                'message'                 => 'Projeto de lei aprovado com sucesso!',
                'lawProject_id'           => $lawProject->id,
                'lawProject_place'        => $lawProject->law_place->name,
                'lawProject_date_publish' => $lawProject->law_date_publish,
                'law_number'              => $lawProject->law_number,
                'year'                    => $year,
            ];

        }
    }

    public function importNumberLaw()
    {

        $laws = LawsProject::all();

        if (empty($laws)) {
            flash('Law Project not found')->error();

            return redirect(route('lawsProjects.index'));
        }

        $data = [];

        foreach ($laws as $law) {
            $data[] = [
                'laws_project_id' => $law->id,
                'date'            => $law->updated_at,
            ];
        }

        LawProjectsNumber::insert($data);

        flash('Leis migradas com sucesso!')->success();
        return redirect(route('lawsProjects.index'));
    }

    public function toogleApproved($id, Request $request)
    {
        $law                = LawsProject::find($id);
        $input              = $request->all();
        $input['town_hall'] = ($input['town_hall'] == "true") ? 1 : 0;
        if ($law) {
            $law->town_hall = $input['town_hall'];
            $law->save();
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function attachamentUpload($id, Request $request)
    {
        if (!Defender::hasPermission('documents.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/documents");
        }

        $law = LawsProject::find($id);

        if ($request->file) {
            foreach ($request->file as $key => $file) {
                $new_file = new LawFile();
                $fileName = $law->id . $key . time() . '.' . $file->getClientOriginalExtension();
                $file->move(
                    base_path() . '/public/uploads/law_projects/' . $law->id . '/files', $fileName
                );
                $new_file->law_project_id = $law->id;
                $new_file->filename       = $fileName;
                $new_file->save();
            }
        }

        return Redirect(route('lawsProjects.addFiles', $law->id));
    }

    public function attachamentDelete($id)
    {
        $file = LawFile::find($id);
        $file->delete();
        return 'true';
    }

    public function addFiles($id)
    {
        $lawsProject = LawsProject::find($id);
        $law_files   = LawFile::where('law_project_id', $lawsProject->id)->get();
        return view('lawsProjects.files', compact('lawsProject', 'law_files'));
    }

    public function addFilesSave($id, Request $request)
    {
        $input       = $request->all();
        $lawsProject = LawsProject::find($id);

        if ($request->file('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName  = 'law_' . $id . '.' . $extension;

            if ($request->file('file')->move('laws', $fileName)) {
                $lawsProject->file = $fileName;
                $lawsProject->save();
            }
        }

        if ($request->file('law_file')) {
            $extension = $request->file('law_file')->getClientOriginalExtension();
            $fileName  = 'law_file_' . $lawsProject->id . '.' . $extension;
            if ($request->file('law_file')->move('laws', $fileName)) {
                $lawsProject->law_file = $fileName;
                $lawsProject->save();
            }
        }
        flash('Arquivos salvos com sucesso!')->success();
        return redirect(route('lawsProjects.index'));
    }
}
