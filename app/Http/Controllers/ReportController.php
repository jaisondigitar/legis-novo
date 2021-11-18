<?php
/**
 * Created by PhpStorm.
 * User: blit
 * Date: 31/07/17
 * Time: 15:45
 */

namespace App\Http\Controllers;


use App\Models\Assemblyman;
use App\Models\Company;
use App\Models\Document;
use App\Models\DocumentAssemblyman;
use App\Models\DocumentFiles;
use App\Models\DocumentModels;
use App\Models\DocumentProtocol;
use App\Models\LawsPlace;
use App\Models\LawsProject;
use App\Models\Meeting;
use App\Models\MeetingFiles;
use App\Models\Parameters;
use App\Models\PartiesAssemblyman;
use App\Models\ProtocolType;
use App\Models\UserAssemblyman;
use Artesaos\Defender\Contracts\Defender;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
//use Reportico\Reportico\reportico;



class ReportController extends AppBaseController {



    public function getAssemblymenList()
    {
        if(Auth::user()->sector_id == 2){
            $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)
                ->leftJoin('assemblymen', function($join) {
                    $join->on('assemblymen.id', '=', 'user_assemblyman.assemblyman_id');
                })
                ->where('assemblymen.active', '=', 1)
                ->get();
        }else {
            $assemblymens = Assemblyman::where('assemblymen.active', '=', 1)->get();
        }

        $assemblymen = [];
        $assemblymensList = [null => 'Selecione...'];
        foreach ($assemblymens as $assemblyman) {
            $parties = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('date', 'DESC')->first();
            $assemblymensList[$assemblyman->id] = $assemblyman->short_name .' - ' . $parties->party->prefix;
        }

        $assemblymens1 = Assemblyman::where('assemblymen.active', '=', 1)->get();
        foreach ($assemblymens1 as $assemblyman) {
            $parties = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('date', 'DESC')->first();
            $assemblymen[$assemblyman->id] = $assemblyman->short_name .' - ' . $parties->party->prefix;
        }

        return [$assemblymen,$assemblymensList];
    }

    public function document(Request $request){

        $input = $request->all();

        if (count($request->all())) {

            $documents = Document::byDateDesc();

            if($request->proto){
                $doc_id = DocumentProtocol::where('number', 'like', $request->proto )->first();
                if($doc_id){
                    $doc_id = $doc_id->document;
                }

            }

            if($request->date_start){
                if($input['date_start']) {
                    $d1 = explode('/', $input['date_start']);
                    $request->date_start = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
                }
            }

            if($request->date_end) {
                if ($input['date_end']) {
                    $d1 = explode('/', $input['date_end']);
                    $request->date_end = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
                }
            }


            !empty($request->reg) ? $documents->where('updated_at', date('Y-m-d H:i:s', $request->reg)) : null;
            !empty($request->type) ? $documents->where('document_type_id', $request->type) : null;
            !empty($request->number) ? $documents->where('number', $request->number) : null;
            !empty($request->year) ? $documents->where('date', 'like', $request->year . "%") : null;
            !empty($request->owner) ? $documents->where('owner_id', $request->owner) : null;
            !empty($request->text) ? $documents->where('content', 'like', '%' . $request->text . '%') : null;
            !empty($request->date_start) ? $documents->where('date', '>=', $request->date_start ) : null;
            !empty($request->date_end) ? $documents->where('date', '<=', $request->date_end ) : null;
            !empty($request->proto) ? $documents->find($doc_id->id)->first()->document : null;

            if(Auth::user()->sector->slug!="gabinete") {

                $documents = $documents->paginate(20);

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $documents  = $documents->whereIN('owner_id',$gabIds)->paginate(20);

            }

        } else {

            if(Auth::user()->sector->slug!="gabinete") {

                $documents = Document::byDateDesc()->paginate(20);

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $documents  = Document::whereIN('owner_id',$gabIds)->byDateDesc()->paginate(20);

            }

        }

        $assemblymensList = $this->getAssemblymenList();
        $protocol_types = ProtocolType::pluck('name', 'id');

        $doc = $documents;

        if($request->pdf){
            ReportController::pdf($request);
        }

        return view('report.document')
            ->with('assemblymensList',$assemblymensList[1])
            ->with('documents', $documents)
            ->with('protocol_types', $protocol_types)
            ->with('form', $request);
    }

    public function noFiles()
    {
        $docs = DocumentFiles::all();
        $doc_ids = [];

        foreach ($docs as $doc){
            $file = public_path('uploads/documents/files') . '/' . $doc->filename;
            if(file_exists($file) == false){
                array_push($doc_ids, $doc->document_id);
            }
        }

        $documents = Document::whereIn('id', $doc_ids)->get();

        return view('report.documentNoFile', compact('documents'));
    }

    public function noFilesLaw()
    {
        $laws = LawsProject::all();
        $law_ids = [];

        foreach ($laws as $law){
            $file = public_path('laws') . '/' . $law->file;
            $file1 = public_path('laws') . '/' . $law->law_file;
            if(file_exists($file) == false || file_exists($file1) == false){
                array_push($law_ids, $law->id);
            }
        }

        $lawsProjects = LawsProject::whereIn('id', $law_ids)->get();

        return view('report.lawNoFile', compact('lawsProjects'));
    }

    public function pdfNoFiles()
    {
        $docs = DocumentFiles::all();
        $doc_ids = [];

        foreach ($docs as $doc){
            $file = public_path('uploads/documents/files') . '/' . $doc->filename;
            if(!file_exists($file)){
                array_push($doc_ids, $doc->document_id);
            }
        }

        $documents = Document::whereIn('id', $doc_ids)->get();

        return self::documentsVerify($documents, '/report/documents/noFiles');

        setlocale(LC_ALL, 'pt_BR');
        $company        = Company::first();
        $doc       = Document::find($documents[0]->id);

        $type           = $doc->document_type->parent_id ? $doc->document_type->parent : $doc->document_type;
        $document_model = DocumentModels::where('document_type_id', $type->id)->first();
        $assemblymen    = DocumentAssemblyman::where('document_id', $doc->id)->get();

        if(!$document_model)
        {
            $document_model = DocumentModels::where('document_type_id', $type->parent_id)->first();
        }


        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior  = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;

        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setPrintFooter(false);

        $subHeader = $company->phone1 . " - " .$company->email . "\n";

        $pdf->setFooterData($doc->getNumber(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$font_ubuntu = \TCPDF_FONTS::addTTFfont(public_path() . ‘/front/ubuntu/Ubuntu-regular.ttf’, 'TrueTypeUnicode', '', 32);
        $pdf->SetFont('freemono', '', 11   , '', true);
        $pdf->SetTitle($type->name);

        $pdf->AddPage();
//        <th>Número interno</th>
//                    <th style="text-align: center">Número</th>
//                    <th>Data</th>
//                    <th>Tipo documento</th>
//                    <th>Responsável</th>

        $content   = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">";
        $content  .= "<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>";
        $content  .= "<div class=\"table-responsive\">";
        $content  .= "<h3> Relatório de documento com anexos corrompidos </h3>";
        $content  .=    "<table class=\"table table-striped\">";
        $content  .=        "<thead  >";
        $content  .=        "<tr style=\" background-color: #000; color: #fff;\" >";
        $content  .=            "<th style=\" font-size: 12px;\"> Nº INTERNO</th>";
        $content  .=            "<th style=\" font-size: 12px;\">NÚMERO</th>";
        $content  .=            "<th style=\" font-size: 12px;\">DATA</th>";
        $content  .=            "<th style=\" font-size: 12px;\">TIPO DOC</th>";
        $content  .=            "<th style=\" font-size: 12px;\">RESPONSÁVEL</th>";
        $content  .=        "</tr>";
        $content  .=        "</thead>";

        $content  .=        "<tbody>";

        foreach($documents as $key => $document) {

            $type = $document->document_type->parent_id ? $document->document_type->parent : $document->document_type;
            $document_model = DocumentModels::where('document_type_id', $type->id)->first();
            $assemblymen = DocumentAssemblyman::where('document_id', $document->id)->get();
            if (!$document_model) {
                $document_model = DocumentModels::where('document_type_id', $type->parent_id)->first();
            }

            if($key % 2 == 0) {
                $content .= "<tr>";
            }else{
                $content .= "<tr style=\"background-color: #ccc;\">";
            }
//            $content .= "<hr>";
            $content .= "<td style=\" font-size: 12px;\">";
            $content .= date_timestamp_get($document->updated_at);
            $content .= "</td>";

            $content .= "<td style=\" font-size: 12px;  \">";
            if ($document->document_protocol) {
                $content .= $document->number . '/' . $document->getYear($document->date);
            } else {
                $content .= "-";
            }
            $content .= "</td>";

            $content .= "<td style=\" font-size: 12px;\">" . $document->date . "</td>";
            $content .= "<td style=\" font-size: 12px;\">";
//            if ($document->document_type->parent_id) {
//                $content .= $document->document_type->parent->name . "::";
//            }
            $content .= $document->document_type->name;
            $content .= "</td>";

            $content .= "<td style=\" font-size: 12px;\">";
            if ($document->owner) {
                $content .= $document->owner->short_name;
            } else {
                $content .= "-";
            }
            $content .= "</td>";

            $content .= "</tr>";
        }

        $content  .= "</tbody>";
        $content  .="</table>";



//      return $content;

        //$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);

        $pdf->writeHTML($content);

        $pdf->Output($type->name . '.pdf', 'I');
    }



    /**
     * Display a listing of the LawsProject.
     *
     * @param Request $request
     * @return Response
     */
    public function lawsProject(Request $request)
    {

        $input = $request->all();

        if(count($request->all())){

            $lawsProjects = LawsProject::byDateDesc();

            if($request->date_start) {
                if ($input['date_start']) {
                    $d1 = explode('/', $input['date_start']);
                    $request->date_start = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
                }
            }

            if($request->date_end) {
                if ($input['date_end']) {
                    $d1 = explode('/', $input['date_end']);
                    $request->date_end = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
                }
            }

            !empty($request->reg) ?     $lawsProjects->where('updated_at',date('Y-m-d H:i:s', $request->reg)) : null;
            !empty($request->type) ?    $lawsProjects->where('law_type_id',$request->type) : null;
            !empty($request->number) ?  $lawsProjects->where('project_number',$request->number) : null;
            !empty($request->proto) ?  $lawsProjects->where('protocol',$request->proto) : null;
            !empty($request->year) ?    $lawsProjects->where('law_date','like',$request->year."%") : null;
            !empty($request->owner) ?   $lawsProjects->where('assemblyman_id',$request->owner) : null;
            !empty($request->date_start) ? $lawsProjects->where('law_date', '>=', $request->date_start ) : null;
            !empty($request->date_end) ? $lawsProjects->where('law_date', '<=', $request->date_end ) : null;

            if(Auth::user()->sector->slug!="gabinete") {

                $lawsProjects = $lawsProjects->paginate(20);

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $lawsProjects  = $lawsProjects->whereIN('assemblyman_id',$gabIds)->paginate(20);

            }

        }else {

            if(Auth::user()->sector->slug!="gabinete") {

                $lawsProjects = LawsProject::byDateDesc()->paginate(20);

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $lawsProjects  = LawsProject::whereIN('assemblyman_id',$gabIds)->byDateDesc()->paginate(20);

            }

        }

        $law_places = LawsPlace::pluck('name', 'id')->prepend('Selecione...', '');
        $assemblymensList = $this->getAssemblymenList();

        $references = LawsProject::all();
        $references_project = [0 => 'Selecione'];
        foreach($references as $reference){
            $references_project[$reference->id] = $reference->project_number .'/' . $reference->getYearLaw($reference->law_date .' - '. $reference->law_type->name);
        }

        if($request->pdf)
        {
            ReportController::pdfLawsProject($request);
        }

        return view('report.lawsProject')
            ->with('assemblymensList',$assemblymensList[1])
            ->with('form', $request)
            ->with('lawsProjects', $lawsProjects)
            ->with('references_project', $references_project)
            ->with('law_places', $law_places);
    }


    public function getDoc($request){

        $input = $request->all();

        if (count($request->all())) {

            $documents = Document::byDateDesc();
            $doc_id = DocumentProtocol::where('number', 'like', $request->proto )->first();

            if($doc_id){
                $doc_id = $doc_id->document;
            }

            if($input['date_start']) {
                $d1 = explode('/', $input['date_start']);
                $request->date_start = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
            }

            if($input['date_end']) {
                $d1 = explode('/', $input['date_end']);
                $request->date_end = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
            }

            !empty($input['reg']) ? $documents->where('updated_at', date('Y-m-d H:i:s', $input['reg'])) : null;
            !empty($input['type']) ? $documents->where('document_type_id', $input['type']) : null;
            !empty($input['number']) ? $documents->where('number', $input['number']) : null;
            !empty($input['year']) ? $documents->where('date', 'like', $input['year'] . "%") : null;
            !empty($input['owner']) ? $documents->where('owner_id', $input['owner']) : null;
            !empty($input['text']) ? $documents->where('content', 'like', '%' . $input['text'] . '%') : null;
            !empty($request->date_start) ? $documents->where('date', '>=', $request->date_start ) : null;
            !empty($request->date_end) ? $documents->where('date', '<=', $request->date_end ) : null;
            if($doc_id) {
                !empty($input['proto']) ? $documents->find($doc_id->id)->first()->document : null;
            }


            if(Auth::user()->sector->slug!="gabinete") {

                $documents = $documents->get();

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $documents  = $documents->whereIN('owner_id',$gabIds)->get();

            }

        } else {

            if(Auth::user()->sector->slug!="gabinete") {

                $documents = Document::byDateDesc()->get();

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $documents  = Document::whereIN('owner_id',$gabIds)->byDateDesc()->get();

            }

        }

        $assemblymensList = $this->getAssemblymenList();
        $protocol_types = ProtocolType::pluck('name', 'id');

        return $documents;

    }


    public function pdf(Request $request){

        $documents = ReportController::getDoc($request);

        setlocale(LC_ALL, 'pt_BR');
        $company        = Company::first();
        $doc       = Document::find($documents[0]->id);

        $type           = $doc->document_type->parent_id ? $doc->document_type->parent : $doc->document_type;
        $document_model = DocumentModels::where('document_type_id', $type->id)->first();
        $assemblymen    = DocumentAssemblyman::where('document_id', $doc->id)->get();

        if(!$document_model)
        {
            $document_model = DocumentModels::where('document_type_id', $type->parent_id)->first();
        }


        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior  = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;



        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setPrintFooter(false);

        $subHeader = $company->phone1 . " - " .$company->email . "\n";

        $pdf->setFooterData($doc->getNumber(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$font_ubuntu = \TCPDF_FONTS::addTTFfont(public_path() . ‘/front/ubuntu/Ubuntu-regular.ttf’, 'TrueTypeUnicode', '', 32);
        $pdf->SetFont('freemono', '', 11   , '', true);
        $pdf->SetTitle($type->name);

        $pdf->AddPage();

        $content   = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">";
        $content  .= "<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>";
        $content  .= "<span style=\" font-weight: bold;\">Total de documentos:</span>" . $documents->count();
        $content  .= "<div class=\"table-responsive\">";
        $content  .=    "<table class=\"table table-striped\">";
        $content  .=        "<thead  >";
        $content  .=        "<tr style=\" background-color: #000; font-weight: bold; color: #fff;\" >";
        $content  .=            "<th style=\" font-size: 12px;\"> Nº INTERNO</th>";
        $content  .=            "<th style=\" font-size: 12px;\">DATA</th>";
        $content  .=            "<th style=\" font-size: 12px;\">TIPO DOC</th>";
        $content  .=            "<th style=\" font-size: 12px;\">RESPONSÁVEL</th>";
        $content  .=            "<th style=\"text-align: center; font-size: 12px;\">NÚMERO</th>";
        $content  .=            "<th style=\" font-size: 12px; width: 50px;\">LIDO</th>";
        $content  .=            "<th style=\" font-size: 12px; width: 60px;\">APROVADO</th>";
        $content  .=            "<th style=\" font-size: 12px; width: 100px; text-align: center;\">PROTOCOLO</th>";
        $content  .=            "<th style=\" font-size: 12px; width: 150px;\">DATA PROTOCOLO</th>";
//        $content  .=            "<th style=\" font-size: 12px; width: 150px;\">DESCRIÇÃO</th>";
        $content  .=        "</tr>";
        $content  .=        "</thead>";

        $content  .=        "<tbody>";

        foreach($documents as $key => $document) {



            $type = $document->document_type->parent_id ? $document->document_type->parent : $document->document_type;
            $document_model = DocumentModels::where('document_type_id', $type->id)->first();
            $assemblymen = DocumentAssemblyman::where('document_id', $document->id)->get();
            if (!$document_model) {
                $document_model = DocumentModels::where('document_type_id', $type->parent_id)->first();
            }

            if($key % 2 == 0) {
                $content .= "<tr>";
            }else{
                $content .= "<tr style=\"background-color: #ccc;\">";
            }
//            $content .= "<hr>";
            $content .= "<td style=\" font-size: 12px;\">";
            $content .= date_timestamp_get($document->updated_at);
            $content .= "</td>";
            $content .= "<td style=\" font-size: 12px;\">" . $document->date . "</td>";
            $content .= "<td style=\" font-size: 12px;\">";
            if ($document->document_type->parent_id) {
                $content .= $document->document_type->parent->name . "::";
            }
            $content .= $document->document_type->name;
            $content .= "</td>";

            $content .= "<td style=\" font-size: 12px;\">";
            if ($document->owner) {
                $content .= $document->owner->short_name;
//                if($document->assemblyman()->count() > 0) {
//                    foreach ($document->assemblyman()->get() as $assemblyman) {
//                        $content .= "-" . $assemblyman->short_name;
//                    }
//                }
            } else {
                $content .= "-";
            }
            $content .= "</td>";
            $content .= "<td style=\"text-align: center; font-size: 12px;\">";

            if ($document->number == 0) {
                $content .= "-";
            } else {
                $content .= $document->number . '/' . $document->getYear($document->date);
            }
            $content .= "</td>";


            if ($document->read == 1) {
                $content .= "<td style=\" font-size: 12px; width: 50px;\"> Sim </td >";
            } else {
                $content .= "<td style=\" font-size: 12px; width: 50px;\"> Não </td >";
            }

            if ($document->approved == 1) {
                $content .= "<td style=\" font-size: 12px; width: 60px;\"> Sim </td >";
            } else {
                $content .= "<td style=\" font-size: 12px; width: 60px;\"> Não </td >";
            }


            $content .= "<td style=\" font-size: 12px; width: 100px; text-align: center; \">";
            if ($document->document_protocol) {
                $content .= $document->document_protocol->number;
            } else {
                $content .= "-";
            }
            $content .= "</td>";


            $content .= "<td style=\" font-size: 12px;  width: 150px; text-align: center;\" >";
            if ($document->document_protocol) {
                $content .= date('d/m/Y H:i:s', strtotime($document->document_protocol->created_at));
            } else {
                $content .= "-";
            }
            $content .= "</td>";

            $content .= "</tr>";


            if($key % 2 == 0) {
                $content .= "<tr>";
            }else{
                $content .= "<tr style=\"background-color: #ccc;\">";
            }
            $content .= "<td colspan=\"10\" style=\" font-size: 12px;\" >";
            if($document->content) {
                $content .= "DESCRIÇÃO:" . str_limit(strip_tags($document->content), 800, '...');
            }
            $content .= "</td>";
            $content .= "</tr>";

        }

    $content  .= "</tbody>";
$content  .="</table>";



//      return $content;

        //$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);

       $pdf->writeHTML($content);

       $pdf->Output($type->name . '.pdf', 'I');


    }

    public function getLawsProject(Request $request){

        $input = $request->all();

        if(count($request->all())){

            $lawsProjects = LawsProject::byDateDesc();

            if($input['date_start']) {
                $d1 = explode('/', $input['date_start']);
                $request->date_start = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
            }

            if($input['date_end']) {
                $d1 = explode('/', $input['date_end']);
                $request->date_end = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
            }

            !empty($request->reg) ?     $lawsProjects->where('updated_at',date('Y-m-d H:i:s', $request->reg)) : null;
            !empty($request->type) ?    $lawsProjects->where('law_type_id',$request->type) : null;
            !empty($request->number) ?  $lawsProjects->where('project_number',$request->number) : null;
            !empty($request->proto) ?  $lawsProjects->where('protocol',$request->proto) : null;
            !empty($request->year) ?    $lawsProjects->where('law_date','like',$request->year."%") : null;
            !empty($request->owner) ?   $lawsProjects->where('assemblyman_id',$request->owner) : null;
            !empty($request->date_start) ? $lawsProjects->where('law_date', '>=', $request->date_start ) : null;
            !empty($request->date_end) ? $lawsProjects->where('law_date', '<=', $request->date_end ) : null;

            if(Auth::user()->sector->slug!="gabinete") {

                $lawsProjects = $lawsProjects->get();

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $lawsProjects  = $lawsProjects->whereIN('assemblyman_id',$gabIds)->get();

            }

        }else {

            if(Auth::user()->sector->slug!="gabinete") {

                $lawsProjects = LawsProject::byDateDesc()->get();

            }else{

                $gabs       = UserAssemblyman::where('users_id',Auth::user()->id)->get();
                $gabIds     = $this->getAssembbyIds($gabs);
                $lawsProjects  = LawsProject::whereIN('assemblyman_id',$gabIds)->byDateDesc()->get();

            }

        }

        $law_places = LawsPlace::pluck('name', 'id')->prepend('Selecione...', '');
        $assemblymensList = $this->getAssemblymenList();

        $references = LawsProject::all();
        $references_project = [0 => 'Selecione'];
        foreach($references as $reference){
            $references_project[$reference->id] = $reference->project_number .'/' . $reference->getYearLaw($reference->law_date .' - '. $reference->law_type->name);
        }

        return $lawsProjects;
    }






    public function pdfLawsProject(Request $request){

        $documents = ReportController::getLawsProject($request);

        setlocale(LC_ALL, 'pt_BR');
        $company        = Company::first();
        $doc       = LawsProject::find($documents[0]->id);
//        $type           = $doc->document_type->parent_id ? $doc->document_type->parent : $doc->document_type;
//        $document_model = DocumentModels::where('document_type_id', $type->id)->first();
//        $assemblymen    = DocumentAssemblyman::where('document_id', $doc->id)->get();

//        if(!$document_model)
//        {
//            $document_model = DocumentModels::where('document_type_id', $type->parent_id)->first();
//        }


        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior  = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;



        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setPrintFooter(false);

        $subHeader = $company->phone1 . " - " .$company->email . "\n";

        $pdf->setFooterData($doc->getNumberLaw(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$font_ubuntu = \TCPDF_FONTS::addTTFfont(public_path() . ‘/front/ubuntu/Ubuntu-regular.ttf’, 'TrueTypeUnicode', '', 32);
        $pdf->SetFont('freemono', '', 11   , '', true);
        $pdf->SetTitle("Relatório Projeto de Lei");

        $pdf->AddPage();

        $content   = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">";
        $content  .= "<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>";
        $content  .= "<div class=\"table-responsive\">";
        $content  .=    "<table class=\"table table-striped\">";
        $content  .=        "<thead  >";
        $content  .=        "<tr style=\" background-color: #000; color: #fff;\" >";
        $content  .=            "<th style=\" font-size: 12px;\"> #COD</th>";
        $content  .=            "<th style=\" font-size: 12px; width: 200px;\">DESCRIÇÃO</th>";
        $content  .=            "<th style=\" font-size: 12px;\">DATA</th>";
        $content  .=            "<th style=\" font-size: 12px;\">PROTOCOLO</th>";
        $content  .=            "<th style=\"text-align: center; font-size: 12px;\">APROVADO</th>";
        $content  .=            "<th style=\" font-size: 12px; text-align: center; \">LIDO</th>";
        $content  .=        "</tr>";
        $content  .=        "</thead>";

        $content  .=        "<tbody>";

        foreach($documents as $key => $lawsProject) {

            if($key % 2 == 0) {
                $content .= "<tr>";
            }else{
                $content .= "<tr style=\"background-color: #ccc;\">";
            }

                $content .= "<td>" . date_timestamp_get($lawsProject->updated_at) .   "</td> ";
                $content .= "<td style=\" font-size: 12px; width: 200px;\">";
                    if(!$lawsProject->law_type){
                        $content .= $lawsProject->law_type_id;
                    }else{
                        $content .= mb_strtoupper($lawsProject->law_type->name, 'UTF-8');
                    }

                $content .= $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) .   "</td> ";


                $content .= "<td>" . $lawsProject->law_date .   "</td> ";

                $content .= "<td>";
                if($lawsProject->project_number > 0) {
                    $content .= $lawsProject->protocol;
                }else {
                     $content .= "Não";
                }
                $content .= "</td>";

                $content .= "<td style=\"text-align: center;\">";
                if($lawsProject->is_ready == 1) {
                    $content .= "SANCIONADA";
                }else {

                    $content .=  "Não";
                }
                $content .= "</td>";

                $content .= "<td style=\"text-align: center;\">";
                if($lawsProject->is_read == 1) {
                    $content .= "Sim";
                }else {
                    $content .= "Não";
                }
                $content .= "</td>";

            $content .= "</tr>";
        }

        $content  .= "</tbody>";
        $content  .="</table>";



//            $type = $document->document_type->parent_id ? $document->document_type->parent : $document->document_type;
//            $document_model = DocumentModels::where('document_type_id', $type->id)->first();
//            $assemblymen = DocumentAssemblyman::where('document_id', $document->id)->get();
//            if (!$document_model) {
//                $document_model = DocumentModels::where('document_type_id', $type->parent_id)->first();
//            }

//            if($key % 2 == 0) {
//                $content .= "<tr>";
//            }else{
//                $content .= "<tr style=\"background-color: #ccc;\">";
//            }
////          $content .= "<hr>";
//            $content .= "<td style=\" font-size: 12px;\">";
//            $content .= date_timestamp_get($document->updated_at);
//            $content .= "</td>";
//            $content .= "<td style=\" font-size: 12px;\">" . $document->date . "</td>";
//            $content .= "<td style=\" font-size: 12px;\">";
//            if ($document->document_type->parent_id) {
//                $content .= $document->document_type->parent->name . "::";
//            }
//            $content .= $document->document_type->name;
//            $content .= "</td>";
//
//            $content .= "<td style=\" font-size: 12px;\">";
//            if ($document->owner) {
//                $content .= $document->owner->short_name;
//            } else {
//                $content .= "-";
//            }
//            $content .= "</td>";
//            $content .= "<td style=\"text-align: center; font-size: 12px;\">";
//
//            if ($document->number == 0) {
//                $content .= "-";
//            } else {
//                $content .= $document->number . '/' . $document->getYear($document->date);
//            }
//            $content .= "</td>";
//
//
//            if ($document->read == 1) {
//                $content .= "<td style=\" font-size: 12px; width: 50px;\"> Sim </td >";
//            } else {
//                $content .= "<td style=\" font-size: 12px; width: 50px;\"> Não </td >";
//            }
//
//            if ($document->approved == 1) {
//                $content .= "<td style=\" font-size: 12px; width: 60px;\"> Sim </td >";
//            } else {
//                $content .= "<td style=\" font-size: 12px; width: 60px;\"> Não </td >";
//            }
//
//
//            $content .= "<td style=\" font-size: 12px; width: 100px; text-align: center; \">";
//            if ($document->document_protocol) {
//                $content .= $document->document_protocol->number;
//            } else {
//                $content .= "-";
//            }
//            $content .= "</td>";
//
//
//            $content .= "<td style=\" font-size: 12px;  width: 150px; text-align: center;\" >";
//            if ($document->document_protocol) {
//                $content .= date('d/m/Y H:i:s', strtotime($document->document_protocol->created_at));
//            } else {
//                $content .= "-";
//            }
//            $content .= "</td>";
//
//
//            $content .= "</tr>";
//        }

//        $content  .= "</tbody>";
//        $content  .="</table>";
//


//      return $content;

        //$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);

        $pdf->writeHTML($content);

        $pdf->Output($doc->protocol . '.pdf', 'I');


    }

    public function pdfNoFilesLaw()
    {
        $laws = LawsProject::all();
        $law_ids = [];

        foreach ($laws as $law){
            $file = public_path('laws') . '/' . $law->file;
            $file1 = public_path('laws') . '/' . $law->law_file;
            if(file_exists($file) == false || file_exists($file1) == false){
                array_push($law_ids, $law->id);
            }
        }


        $documents = LawsProject::whereIn('id', $law_ids)->get();

        return self::documentsVerify($documents, '/report/lawsProject/noFiles');

        setlocale(LC_ALL, 'pt_BR');
        $company        = Company::first();
        $doc       = LawsProject::find($documents[0]->id);

        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior  = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;



        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setPrintFooter(false);

        $subHeader = $company->phone1 . " - " .$company->email . "\n";

        $pdf->setFooterData($doc->getNumberLaw(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$font_ubuntu = \TCPDF_FONTS::addTTFfont(public_path() . ‘/front/ubuntu/Ubuntu-regular.ttf’, 'TrueTypeUnicode', '', 32);
        $pdf->SetFont('freemono', '', 11   , '', true);
        $pdf->SetTitle("Relatório Projeto de Lei");

        $pdf->AddPage();

        $content   = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">";
        $content  .= "<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>";
        $content  .= "<div class=\"table-responsive\">";
        $content  .= "<h3> Lista dos projetos de lei com anexos corrompidos</h3>";
        $content  .=    "<table class=\"table table-striped\">";
        $content  .=        "<thead  >";
        $content  .=        "<tr style=\" background-color: #000; color: #fff;\" >";
        $content  .=            "<th style=\" font-size: 12px; width: 100px;\"> #COD</th>";
        $content  .=            "<th style=\" font-size: 12px;  width: 600px;\">DESCRIÇÃO</th>";
        $content  .=            "<th style=\" font-size: 12px;  width: 100px;\">DATA</th>";
        $content  .=        "</tr>";
        $content  .=        "</thead>";

        $content  .=        "<tbody>";

        foreach($documents as $key => $lawsProject) {

            if($key % 2 == 0) {
                $content .= "<tr>";
            }else{
                $content .= "<tr style=\"background-color: #ccc;\">";
            }

            $content .= "<td style=\"width: 100px;\">" . date_timestamp_get($lawsProject->updated_at) .   "</td> ";
            $content .= "<td style=\" font-size: 12px; width: 600px; \">";
            if(!$lawsProject->law_type){
                $content .= $lawsProject->law_type_id;
            }else{
                $content .= mb_strtoupper($lawsProject->law_type->name, 'UTF-8');
            }

            $content .= $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) .   "</td> ";

            $content .= "<td style=\" width: 100px; \">" . $lawsProject->law_date .   "</td> ";

            $content .= "</tr>";
        }

        $content  .= "</tbody>";
        $content  .="</table>";

        $pdf->writeHTML($content);

        $pdf->Output($doc->protocol . '.pdf', 'I');


    }

    public function noFilesMeeting()
    {
        $meetingFiles = MeetingFiles::all();
        $meeting_ids = [];

        foreach ($meetingFiles as $meetingFile){
            $files = public_path('uploads/meetings/files') . '/' . $meetingFile->filename;
            if(file_exists($files) == false){
                array_push($meeting_ids, $meetingFile->id);
            }
        }

        $meetingFiles = MeetingFiles::whereIn('id', $meeting_ids)->get();

        return view('report.meetingNoFile', compact('meetingFiles'));
    }

    public function pdfNoFilesMeeting()
    {
        $meetingFiles = MeetingFiles::all();
        $meeting_ids = [];

        foreach ($meetingFiles as $meetingFile){
            $files = public_path('uploads/meetings/files') . '/' . $meetingFile->filename;
            if(file_exists($files) == false){
                array_push($meeting_ids, $meetingFile->id);
            }
        }

        $documents = MeetingFiles::whereIn('id', $meeting_ids)->get();

        return self::documentsVerify($documents, '/report/meeting/noFiles');

        setlocale(LC_ALL, 'pt_BR');
        $company        = Company::first();
        $doc       = LawsProject::find($documents[0]->id);

        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior  = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;



        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setPrintFooter(false);

        $subHeader = $company->phone1 . " - " .$company->email . "\n";

        $pdf->setFooterData($doc->getNumberLaw(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$font_ubuntu = \TCPDF_FONTS::addTTFfont(public_path() . ‘/front/ubuntu/Ubuntu-regular.ttf’, 'TrueTypeUnicode', '', 32);
        $pdf->SetFont('freemono', '', 11   , '', true);
        $pdf->SetTitle("Relatório Projeto de Lei");

        $pdf->AddPage();

        $content   = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">";
        $content  .= "<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>";
        $content  .= "<div class=\"table-responsive\">";
        $content  .= "<h3> Lista ATA / PAUTA com anexos corrompidos</h3>";
        $content  .=    "<table class=\"table table-striped\">";
        $content  .=        "<thead  >";
        $content  .=        "<tr style=\" background-color: #000; color: #fff;\" >";
        $content  .=            "<th style=\" font-size: 12px; \"> Nº SESSÃO</th>";
        $content  .=            "<th style=\" font-size: 12px;  \">TIPO SESSÃO</th>";
        $content  .=            "<th style=\" font-size: 12px;  \">LOCAL SESSÃO</th>";
        $content  .=        "</tr>";
        $content  .=        "</thead>";

        $content  .=        "<tbody>";

        foreach($documents as $key => $lawsProject) {

            if($key % 2 == 0) {
                $content .= "<tr>";
            }else{
                $content .= "<tr style=\"background-color: #ccc;\">";
            }

            $content .= "<td style=\"\">" . $lawsProject->meeting->number  .   "</td> ";
            $content .= "<td style=\" font-size: 12px; \">" . $lawsProject->meeting->session_type->name. "</td> ";

            $content .= "<td style=\"  \">" . $meetingFile->meeting->session_place->name . "</td> ";

            $content .= "</tr>";
        }

        $content  .= "</tbody>";
        $content  .="</table>";

        $pdf->writeHTML($content);

        $pdf->Output($doc->protocol . '.pdf', 'I');


    }

    public function getTramitacao()
    {
        $tramitacao = LawsProject::where('advice_situation_id','>',0)
            ->orWhere('advice_date','>',0)
            ->orWhere('first_discussion','>',0)
            ->orWhere('second_discussion','>',0)
            ->orWhere('third_discussion','>',0)
            ->orWhere('single_discussion','>',0)
            ->orWhere('special_urgency','>',0)
            ->orWhere('approved','>',0)
            ->orWhere('sanctioned','>',0)
            ->orWhere('Promulgated','>',0)
            ->orWhere('Rejected','>',0)
            ->orWhere('Vetoed','>',0)
            ->orWhere('Filed','>',0)
            ->orWhereNotNull('observation')
            ->orderBy('project_number')->get();
        return view('report.tramitacao', compact('tramitacao'));
    }

    public function getTramitacaoPDF()
    {
        $tramitacao = LawsProject::where('advice_situation_id','>',0)
            ->orWhere('advice_date','>',0)
            ->orWhere('first_discussion','>',0)
            ->orWhere('second_discussion','>',0)
            ->orWhere('third_discussion','>',0)
            ->orWhere('single_discussion','>',0)
            ->orWhere('special_urgency','>',0)
            ->orWhere('approved','>',0)
            ->orWhere('sanctioned','>',0)
            ->orWhere('Promulgated','>',0)
            ->orWhere('Rejected','>',0)
            ->orWhere('Vetoed','>',0)
            ->orWhere('Filed','>',0)
            ->orWhereNotNull('observation')
            ->orderBy('project_number')->get();

        setlocale(LC_ALL, 'pt_BR');
        $company        = Company::first();

        $doc = LawsProject::first();
//        $doc       = LawsProject::find($doc_id);

        return self::documentsVerify(collect($doc), '/report/getTramitacao');

        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior  = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;



        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setPrintFooter(false);

        $subHeader = $company->phone1 . " - " .$company->email . "\n";

        $pdf->setFooterData($doc->getNumberLaw(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$font_ubuntu = \TCPDF_FONTS::addTTFfont(public_path() . ‘/front/ubuntu/Ubuntu-regular.ttf’, 'TrueTypeUnicode', '', 32);
        $pdf->SetFont('freemono', '', 11   , '', true);
        $pdf->SetTitle("Relatório Projeto de Lei com tramitação");

        $pdf->AddPage();

        $content   = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">";
        $content  .= "<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>";
        $content  .= "<div class=\"table-responsive\">";
        $content  .= "<h3> Lista Projetos de Lei com tramitação </h3>";
        $content  .=    "<table class=\"table table-striped\">";
        $content  .=        "<thead  >";
        $content  .=        "<tr style=\" background-color: #000; color: #fff;\" >";
        $content  .=            "<th style=\" font-size: 12px; \"> COD </th>";
        $content  .=            "<th style=\" font-size: 12px;  \">Numero Projeto de lei </th>";
        $content  .=            "<th style=\" font-size: 12px;  \">Numero da lei</th>";
        $content  .=            "<th style=\" font-size: 12px;  \">Tipo</th>";
        $content  .=        "</tr>";
        $content  .=        "</thead>";

        $content  .=        "<tbody>";

        foreach($tramitacao as $key => $lawsProject) {

            if ($lawsProject->getNumberLaw() != 'false') {

                if ($key % 2 == 0) {
                    $content .= "<tr>";
                } else {
                    $content .= "<tr style=\"background-color: #ccc;\">";
                }

                $content .= "<td style=\"\">" . $lawsProject->getNumberLaw() . "</td> ";
                $content .= "<td style=\" font-size: 12px; \">" . $lawsProject->project_number . "</td> ";

                $content .= "<td style=\"  \">" . $lawsProject->law_number . "</td> ";
                $content .= "<td style=\"  \">" . $lawsProject->law_type->name . "</td> ";

                $content .= "</tr>";
            }
        }

        $content  .= "</tbody>";
        $content  .="</table>";

        $pdf->writeHTML($content);

        $pdf->Output($doc->protocol . '.pdf', 'I');


    }

    /**
     * @param Collection $documents
     * @param string $path_to_return
     * @return Application|RedirectResponse|Redirector|void
     */
    static function documentsVerify(Collection $documents, string $path_to_return)
    {
        if ($documents->isEmpty()) {
            flash('Não há documentos para impressão.')->warning();
            return redirect($path_to_return);
        }
    }
}