<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Company;
use App\Models\LawsProject;
use App\Models\LawsProjectAssemblyman;
use App\Models\Parameters;
use App\Models\StructureLaws;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LawProjectExportPDFJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $law;

    public function __construct(LawsProject $law)
    {
        $this->law = $law;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

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

    private function renderNode($node,$index=0,$level=0) {
        $html = "";

        if ($node->isLeaf()) {
            if($node->depth>0){
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
            if(!$node->isRoot()) {
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

    public function loadAdvices($pdf, $lawsProjectId)
    {

        $advices = \App\Models\Advice::where('laws_projects_id',$lawsProjectId)->get();

        if(!$advices){
            $pdf->AddPage();
            $pdf->setListIndentWidth(5);
            $content = "<h4 style=\"text-align: center\">nenhum trâmite para este documento</h4>";
            $pdf->writeHTML($content);
        }else{
            $this->printAdvices($advices,$pdf);
        }

    }

    protected function printAdvices($advices,$pdf)
    {
        $return = "";

        foreach ($advices as $advice) {

            $pdf->AddPage();
            $pdf->setListIndentWidth(5);

            $return = "<h3 style=\"text-align: center\">  @if($advice->destination)   mb_strtoupper($advice->destination->name, 'UTF-8') @endif  </h3>";
            $return .= "<p><strong>Solicitação: </strong>" . $advice->date . "<br><strong>Descrição: </strong>" . $advice->description . "</p>";

            foreach ($advice->awnser as $resp) {
                $resp->commission_situation = $resp->commission_situation ? $resp->commission_situation->name : '';

                $return .= "<div style=\"border: 1px solid #000000; padding-left: 10px \">";
                $return .= "<strong>Data: </strong> ". date('d/m/Y',strtotime($resp->date)) ."<br>";
                $return .= "<strong>Situação: </strong> ". $resp->commission_situation ."<br>";
                $return .= trim($resp->description );
                $return .= "</div>";
            }
            $pdf->writeHTML($return);
        }

    }

    public function handle()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $lawsProject = $this->law;
        $id = $this->law->id;

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

        require_once(public_path() . '/tcpdf/mypdf.php');

        $pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('MakerLegis');

        $pdf->SetPrintHeader($showHeader);
        $pdf->setFooterData($lawsProject->getNumberLaw(),array(0,64,0), array(0,64,128));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins($margemEsquerda,  $marginHeader, $margemDireita);
        $pdf->SetHeaderMargin($margemSuperior);
        $pdf->SetFooterMargin($margemInferior);
        $pdf->SetAutoPageBreak(TRUE, $margemInferior+10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 11   , '', true);
        $pdf->SetTitle($lawsProject->name);

        $pdf->AddPage();

        $pdf->setListIndentWidth(5);

        $assemblymen    = LawsProjectAssemblyman::where('law_project_id', $lawsProject->id)->orderBy('id')->get();
        $date = explode('/', $lawsProject->law_date);
        $date = $date[2] .'-'. $date[1] .'-'. $date[0];

        $list = [];
        $list[0][0] = $lawsProject->owner->short_name;
        if(count($lawsProject->owner->responsibility_assemblyman()->where('date', '<=', $date)->get()) > 1){
            $list[0][1] = $lawsProject->owner->responsibility_assemblyman()->where('date', '<=', $date)->get()->last()->responsibility->name ."(a) ";
        }else{
            if(count($lawsProject->owner->responsibility_assemblyman) > 0){
                $list[0][1] = $lawsProject->owner->responsibility_assemblyman()->first()->responsibility->name ."(a) ";
            }else{
                $list[0][1] = "Vereador(a) ";
            }
        }


        if(!empty($assemblymen)){

            foreach ($assemblymen as $key => $assemblyman){
                $list[$key+1][0] = $assemblyman->assemblyman->short_name;
                if(count($assemblyman->assemblyman->responsibility_assemblyman) > 1){
                    $list[$key+1][1] = $this->getResponsability($assemblyman, $date);
                }else{
                    $list[$key+1][1] = count($assemblyman->assemblyman->responsibility_assemblyman) == 0 ? '-' :$assemblyman->assemblyman->responsibility_assemblyman()->first()->responsibility->name ."(a) ";
                }
            }
        }

        $html = "";
        $count = 0;

        if(count($list) == 1) {
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
        $content = "<h3 style=\"text-align: center\">". mb_strtoupper($lawsProject->law_type->name, 'UTF-8') ." " . $lawsProject->project_number . '/' . $lawsProject->getYearLawPublish($lawsProject->law_date) . "</h3>";

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

        foreach ($structure as $reg) {
            $content .= $this->renderNode($reg, 0, 0);
        }

        $content .= "</ul></p>";

        $content .= "<br><br>";
        $content .= "<p>" . ($lawsProject->sufix) . "</p>";

        $lawsProject->situation_id1 = $lawsProject->advice_situation_id > 0 ? $lawsProject->adviceSituationLaw->name : '-';
        $lawsProject->advice_publication_id1 = $lawsProject->advice_publication_id > 0 ? $lawsProject->advicePublicationLaw->name : '-';
        $lawsProject->observation = $lawsProject->observation == null ?  '-' : $lawsProject->observation;

        $data_USA = explode(' ',ucfirst(iconv('ISO-8859-1', 'UTF-8',strftime('%d de %B de %Y', strtotime(Carbon::createFromFormat('d/m/Y', $lawsProject->law_date))))));

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

        $dataProject = $data_ptbr;

        $cidade = Company::first()->getCity->name."/".Company::first()->getState->uf;

        $content .= "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
        $content .= "<tr style=\"height: 300px\">";
        $content .= "<td style=\"width:25%;\"></td>";
        $content .= "<td style=\"width:75%; text-align: right\">" . $cidade .", " . $dataProject . "</td>";
        $content .= "</tr>";
        $content .= "</tbody></table>";

        if($lawsProject->comission) {
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
            foreach($lawsProject->processing()->orderBy('processing_date', 'desc')->get() as $processing){
                $html1 .= "<hr>";
                $html1 .= "<tr style=\" text-align: left;\">";
                $html1 .=   "<td width=\"100\" style=\" text-align: left;\"><b>Data: </b> <br>". $processing->processing_date ."</td>";
                if($processing->advicePublicationLaw) {
                    $html1 .= "<td width=\"120\" style=\" text-align: left;\"><b>Publicado no: </b> <br>" . $processing->advicePublicationLaw->name . " </td>";
                }
                $html1 .=   "<td width=\"150\" style=\" text-align: left;\"><b>Situação do projeto: </b> <br>". $processing->adviceSituationLaw->name ."</td>";
                if($processing->statusProcessingLaw) {
                    $html1 .= "<td width=\"150\" style=\" text-align: left;\"><b>Status do tramite: </b> <br>" . $processing->statusProcessingLaw->name . "</td>";
                }
                $html1 .= "</tr>";
                if(strlen($processing->obsevation) > 0) {
                    $html1 .= "<tr>";
                    $html1 .= "<td width=\"650\" style=\" text-align: justify; \"><b>Observação: </b> <br>" . $processing->obsevation . "</td>";
                    $html1 .= "</tr>";
                }
            }
            $html1 .= "</tbody></table>";

            $pdf->writeHTML($html1);
        }

        if ($votacao && $lawsProject->voting()->get()->count() > 0) {
            $pdf->AddPage();
            $pdf->setListIndentWidth(5);
            $html2 = "<table cellspacing=\"10\" cellpadding=\"10\" style=\" margin-top: 300px; width:100%;  \"><tbody>";
            $html2 .= "<tr style=\"height: 300px\">";
            $html2 .= "<td style=\"width:100%; text-align: center;\"><h3> Votação </h3></td>";
            $html2 .= "</tr>";
            $html2 .= "</tbody></table>";
            $html2 .= "<table style=\" text-align: left;\">";
            foreach($lawsProject->voting()->get() as $item) {
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


        if($lawsProject->justify)
        {
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

        if($showAdvices)
        {
            $advices =  $this->loadAdvices($pdf,$id);

        }

        $path =  public_path('exportacao/projetoLei/'. str_slug($this->law->law_type->name));

        if(!file_exists($path)){
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }

        $name = str_slug($this->law->law_type->name) . '-' . $lawsProject->getNumberLaw() .'_' .  $lawsProject->getYearLawPublish($lawsProject->law_date) . '.pdf';

        $pdf->Output($path . DIRECTORY_SEPARATOR . $name, 'F');


    }
}
