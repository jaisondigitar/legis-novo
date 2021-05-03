<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Company;
use App\Models\DocumentAssemblyman;
use App\Models\DocumentModels;
use App\Models\Parameters;
use App\Models\PartiesAssemblyman;
use App\Models\ResponsibilityAssemblyman;
use Carbon\Carbon;
use App\Models\Document;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentExportPDF extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;

    protected $doc;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $doc)
    {
        $this->doc = $doc;
    }

    public function getResponsability($assemblyman, $date){
        $achou = 0;
        foreach ($assemblyman->assemblyman->responsibility_assemblyman()->orderBy('date', 'desc')->get() as $item){

            $date1 = explode('/', $item->date);
            $date1 = $date1[2] .'-'. $date1[1] .'-'. $date1[0];
            if(strtotime($date1) <= strtotime($date) && $achou == 0){
                $achou  = 1;
                $resp = $item->responsibility->name ."(a) ";
            }else{
                $resp = 'Vereador(a)';
            }
        }
        return $resp;
    }


    public function handle()
    {
        $document = $this->doc;

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $company        = Company::first();

        $type           = $document->document_type->parent_id ? $document->document_type->parent : $document->document_type;
        $document_model = DocumentModels::where('document_type_id', $type->id)->first();
        $assemblymen    = DocumentAssemblyman::where('document_id', $document->id)->get();

        $showHeader = Parameters::where('slug', 'mostra-cabecalho-em-pdf-de-documentos-e-projetos')->first()->value;
        $marginHeader = Parameters::where('slug', 'espaco-entre-texto-e-cabecalho')->first()->value;

        $margemSuperior = Parameters::where('slug', 'margem-superior-de-documentos')->first()->value;
        $margemInferior = Parameters::where('slug', 'margem-inferior-de-documentos')->first()->value;
        $margemEsquerda = Parameters::where('slug', 'margem-esquerda-de-documentos')->first()->value;
        $margemDireita  = Parameters::where('slug', 'margem-direita-de-documentos')->first()->value;
        $tramitacao     = Parameters::where('slug', 'realiza-tramite-em-documentos')->first()->value;
        $votacao        = Parameters::where('slug', 'mostra-votacao-em-documento')->first()->value;


        if(!$document_model)
        {
            $document_model = DocumentModels::where('document_type_id', $type->parent_id)->first();
        }

        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);

        $subHeader = $company->phone1 . " - " .$company->email . "\n";

        $pdf->setFooterData($document->getNumber(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+5);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$font_ubuntu = \TCPDF_FONTS::addTTFfont(public_path() . ‘/front/ubuntu/Ubuntu-regular.ttf’, 'TrueTypeUnicode', '', 32);
        $pdf->SetFont('times', '', 12   , '', true);
        $pdf->SetTitle($type->name);

        $pdf->AddPage();

        $date = explode('/', $document->date);
        $date = $date[2] .'/'. $date[1] .'/'. $date[0];

        $list = [];
        $list[0][0] = $document->owner->short_name;
        if(count($document->owner->responsibility_assemblyman()->where('date', '<=', $date)->get()) > 1){
            $list[0][1] = $document->owner->responsibility_assemblyman()->where('date', '<=', $date)->orderBy('date')->get()->last()->responsibility->name ."(a) ";
        }else{
            if(count($document->owner->responsibility_assemblyman) > 0){
                $list[0][1] = $document->owner->responsibility_assemblyman()->first()->responsibility->name ."(a) ";
            }else{
                $list[0][1] = "Vereador(a) ";
            }
        }
//            $list[0][1] = count($document->owner->responsibility_assemblyman) > 1 ? $document->owner->responsibility_assemblyman()->where('date', '>=', $date)->first()->responsibility->name ."(a) " : $document->owner->responsibility_assemblyman()->first()->responsibility->name ."(a) " ;
        $list[0][2] = "Vereador(a) ";
        $list[0][3] = PartiesAssemblyman::where('assemblyman_id', $document->owner->id)->orderBy('date', 'DESC')->first()->party->prefix;


        if(!empty($assemblymen)){
            foreach ($assemblymen as $key => $assemblyman){
                $list[$key+1][0] = $assemblyman->assemblyman->short_name;
                if(count($assemblyman->assemblyman->responsibility_assemblyman) > 1){
                    $list[$key+1][1] = $this->getResponsability($assemblyman, $date);
                }else{
                    $list[$key+1][1] = count($assemblyman->assemblyman->responsibility_assemblyman) == 0 ? '-' :$assemblyman->assemblyman->responsibility_assemblyman()->first()->responsibility->name ."(a) ";
                }
            }
//                foreach ($assemblymen as $key => $assemblyman){
//                    $list[$key+1][0] = $assemblyman->assemblyman->short_name;
//                    $list[$key+1][1] = ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman->assemblyman->id)->orderBy('date', 'DESC')->first()->responsibility->name ."(a) ";
//                    $list[$key+1][2] = "Vereador(a) ";
//                    $list[$key+1][3] = PartiesAssemblyman::where('assemblyman_id', $assemblyman->assemblyman->id)->orderBy('date', 'DESC')->first()->party->prefix;
//                }
        }

        if (empty($document)) {
            Flash::error('Document not found');

            return redirect(route('export.files'));
        }

        $html = "";
        $count = 0;

        if(count($list) == 1) {
            $html .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
            $html .= "<tr style=\"height: 300px\">";
            $html .= "<td style=\"width:25%;\"></td>";
            $html .= "<td style=\"width:50%; text-align: center;  vertical-align: text-top\">" . $list[0][0] . "<br>" . $list[0][1] . " - " . $list[0][3] . "<br><br><br></td>";
            $html .= "<td style=\"width:25%;\"></td>";
            $html .= "</tr>";
            $html .= "</tbody></table>";
        } else {
            $html .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\"position:absolute; width: 100%; margin-top: 300px\"><tbody>";

            foreach ($list as $vereador) {
                if ($count == 0) {
                    $html .= "<tr style=\"height: 300px\">";
                }

                $html .= "<td style=\"text-align: center; vertical-align: text-top\">" . $vereador[0] . "<br>" . $vereador[1] . "<br><br><br></td>";

                if ($count == 2 || $vereador === end($list)) {
                    $html .= "</tr>";
                    $count = 0;
                } else {
                    $count++;
                }

            }
            $html .= "</tbody></table>";
        }


        $html2 = "";
        $count = 0;

        if(count($list) == 1) {
            $html2 .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
            $html2 .= "<tr style=\"height: 300px\">";
            $html2 .= "<td style=\"width:25%;\"></td>";
            $html2 .= "<td style=\"width:50%; text-align: center;  vertical-align: text-top\">" . $list[0][0] . "<br>" . $list[0][2] . " - " . $list[0][3] . "<br><br><br></td>";
            $html2 .= "<td style=\"width:25%;\"></td>";
            $html2 .= "</tr>";
            $html2 .= "</tbody></table>";
        } else {
            $html2 .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\"position:absolute; width: 100%; margin-top: 300px\"><tbody>";
            foreach ($list as $vereador) {
                if ($count == 0) {
                    $html2 .= "<tr style=\"height: 300px\">";
                }

                $html2 .= "<td style=\"text-align: center; vertical-align: text-top\">" . $vereador[0] . "<br>" . $vereador[1] . "<br><br><br></td>";

                if ($count == 2 || $vereador === end($list)) {
                    $html2 .= "</tr>";
                    $count = 0;
                } else {
                    $count++;
                }

            }
            $html2 .= "</tbody></table>";
        }

        $html3 = "";
        $count = 0;

        if(count($list) == 1) {
            $html3 .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
            $html3 .= "<tr style=\"height: 300px\">";
            $html3 .= "<td style=\"width:25%;\"></td>";
            $html3 .= "<td style=\"width:50%; text-align: center;  vertical-align: text-top\">" . $list[0][0] . "<br>" . "<br><br><br></td>";
            $html3 .= "<td style=\"width:25%;\"></td>";
            $html3 .= "</tr>";
            $html3 .= "</tbody></table>";
        } else {
            $html3 .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\"position:absolute; width: 100%; margin-top: 300px\"><tbody>";
            foreach ($list as $vereador) {
                if ($count == 0) {
                    $html3 .= "<tr style=\"height: 300px\">";
                }

                $html3 .= "<td style=\"text-align: center; vertical-align: text-top\">" . $vereador[0] . "<br>" . "<br><br><br></td>";

                if ($count == 2 || $vereador === end($list)) {
                    $html3 .= "</tr>";
                    $count = 0;
                } else {
                    $count++;
                }

            }
            $html3 .= "</tbody></table>";
        }

        $tipo = "";
        $tipo .= $document->document_type->parent_id ? $document->document_type->parent->name . " :: " : "";
        $tipo .= $document->document_type->name;
        $docNum = $document->number == 0 ? '_______ ' : $document->number;

        $document_internal_number   = $document->getNumber();
        $document_protocol_number   = $document->document_protocol ? $document->document_protocol->number : "";
        $document_protocol_date     = $document->document_protocol ? date('d/m/Y', strtotime($document->document_protocol->created_at)) : "";
        $document_protocol_hours    = $document->document_protocol ? date('H:i', strtotime($document->document_protocol->created_at)) : "";

        $data_USA = explode(' ',ucfirst(iconv('ISO-8859-1', 'UTF-8',strftime('%d de %B de %Y', strtotime(Carbon::createFromFormat('d/m/Y', $document->date))))));

        $mes['January'] = 'Janeiro';
        $mes['February'] = 'Fevereiro';
        $mes['March'] = 'Março';
        $mes['April'] = 'Abril';
        $mes['May'] = 'Maio';
        $mes['June'] = 'Junho';
        $mes['July'] = 'Julho';
        $mes['August'] = 'Agosto';
        $mes['September'] = 'Setembro';
        $mes['October'] = 'Outubro';
        $mes['November'] = 'Novembro';
        $mes['December'] = 'Dezembro';


        $mes_pt = isset($mes[$data_USA[2]]) ? $mes[$data_USA[2]] : $data_USA[2];

        $data_ptbr = $data_USA [0] .' '. $data_USA[1] .' '. $mes_pt .' '. $data_USA[3] .' '. $data_USA[4];

//        dd($html);

        $content = str_replace(
            array('[numero]', '[data_curta]','[data_longa]', '[autores]','[autores_vereador]', '[nome_vereadores]','[responsavel]', '[assunto]', '[conteudo]',
                '[protocolo_numero]',
                '[protocolo_data]',
                '[protocolo_hora]',
                '[numero_interno]',
                '[numero_documento]', '[ano_documento]', '[tipo_documento]'),
            array(
                "<b>" . $tipo . "</b>: " . $docNum . ' / ' . $document->getYear($document->date),
                ucfirst(strftime('%d/%m/%Y', strtotime(Carbon::createFromFormat('d/m/Y', $document->date)))),
                $data_ptbr,
//                ucfirst(iconv('ISO-8859-1', 'UTF-8',strftime('%d de %B de %Y', strtotime(Carbon::createFromFormat('d/m/Y', $document->date))))),
                $html,
                $html2,
                $html3,
                $document->owner->short_name,
                $document->content,
                $document->content,
                $document_protocol_number,
                $document_protocol_date,
                $document_protocol_hours,
                $document_internal_number,
                $docNum,
                $document->getYear($document->date),
                $tipo),
            $document_model->content);



        //return $content;

        //$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);



        $pdf->writeHTML($content);

        if($tramitacao){

            $pdf->AddPage();
            $html1 = "<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css\" rel=\"stylesheet\" >";

            $html1 .= "<h3 style=\"width:100%; text-align: center;\"> Tramitação </h3>";
            $html1 .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \">";

            $html1 .= "<tbody>";
            foreach($document->processingDocument()->orderBy('processing_document_date', 'desc')->get() as $processing){
                $html1 .= "<hr>";
                $html1 .= "<tr style=\" text-align: left;\">";
                $html1 .=   "<td width=\"100\" style=\" text-align: left;\"><b>Data: </b> <br>". $processing->processing_document_date ."</td>";
                $html1 .=   "<td width=\"150\" style=\" text-align: left;\"><b>Situação do documento: </b> <br>". $processing->documentSituation->name ."</td>";
                if($processing->statusProcessingDocument) {
                    $html1 .= "<td width=\"150\" style=\" text-align: left;\"><b>Status do tramite: </b> <br>" . $processing->statusProcessingDocument->name . "</td>";
                }
                $html1 .= "</tr>";
                if(strlen($processing->observation) > 0) {
                    $html1 .= "<tr>";
                    $html1 .= "<td width=\"650\" style=\" text-align: justify; \"><b>Observação: </b> <br>" . $processing->observation . "</td>";
                    $html1 .= "</tr>";
                }
            }

            $html1 .= "</tbody></table>";

            $pdf->writeHTML($html1);

        }

        if ($votacao) {
            $pdf->AddPage();
            $pdf->setListIndentWidth(5);
            $html2 = "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
            $html2 .= "<tr style=\"height: 300px\">";
            $html2 .= "<td style=\"width:100%; text-align: center;\"><h3> Votação </h3></td>";
            $html2 .= "</tr>";
            $html2 .= "</tbody></table>";
            $html2 .= "<table style=\" text-align: left;\">";
            foreach($document->voting()->get() as $item) {
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

        $path =  public_path('exportacao/documentos/'. str_slug($this->doc->document_type->name));

        if(!file_exists($path)){
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }

        $name = str_slug($this->doc->document_type->name) . '-' . $document->number .'_' .  $document->getYear($document->date) . '.pdf';

        $pdf->Output($path . DIRECTORY_SEPARATOR . $name, 'F');

    }
}
