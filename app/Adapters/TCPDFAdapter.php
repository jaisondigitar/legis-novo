<?php

namespace App\Adapters;

use App\Models\Company;
use App\Models\Document;
use App\Models\Parameters;
use App\Services\StorageService;
use Exception;
use Illuminate\Support\Str;
use TCPDF;
use Throwable;

class TCPDFAdapter extends TCPDF
{
    /**
     * @return void
     */
    public function Header()
    {
        $this->Image(
            (new StorageService())->inCompanyFolder()->getPath(Company::first()->image),
            $this->getMargins()['left'],
            $this->getMargins()['header'],
            25,
            0,
            '',
            '',
            'T',
            true,
            300,
            '',
            false,
            false,
            0,
            false,
            false,
            false
        );
        $this->SetXY(
            $this->getMargins()['left'] + 34,
            $this->getMargins()['header']
        );
        $this->SetFont('helvetica', 'B', 15);
        $this->Cell(100, 0, Str::upper(Company::first()->shortName), 0, 0, 'L');
        $this->SetFont('helvetica', '', 10);
        $this->SetXY(
            $this->getMargins()['left'] + 34,
            $this->getMargins()['header'] + 6
        );
        $this->Cell(
            100,
            0,
            'ESTADO DE '.Str::upper(Company::first()->getState->name),
            0,
            0,
            'L'
        );
        $this->SetFont('helvetica', '', 9);
        $this->SetXY(
            $this->getMargins()['left'] + 34,
            $this->getMargins()['header'] + 13
        );
        $this->Cell(100, 0, Str::upper(Company::first()->address), 0, 0, 'L');
        $this->SetXY(
            $this->getMargins()['left'] + 34,
            $this->getMargins()['header'] + 18
        );
        $this->Cell(100, 0, 'CNPJ: '.Str::upper(Company::first()->cnpjCpf), 0, 0, 'L');
        $this->SetXY(
            $this->getMargins()['left'] + 34,
            $this->getMargins()['header'] + 23
        );
        $this->Cell(100, 0, 'FONE: '.Str::upper(Company::first()->phone1), 0, 0, 'L');
    }

    /**
     * @return void
     */
    public function Footer()
    {
        $footer_margin = $this->getFooterMargin();

        $this->SetY($footer_margin * -1);
        $this->SetFont(PDF_FONT_NAME_DATA, '', 9);
        $this->Cell(
            0,
            $this->getMargins()['right'],
            "PÁGINA {$this->getAliasNumPage()} DE {$this->getAliasNbPages()}",
            0,
            false,
            'R',
            0,
            '',
            0,
            false,
            'T',
            'T'
        );
        $this->SetX($this->getMargins()['left']);
        $this->SetY(($footer_margin + 7) * -1);
        $this->Write(10, 'DOC: '.($this->docNumber ?? ''));
        $this->SetY($footer_margin * -1);
        $this->write1DBarcode(
            ($this->docNumber ?? ''),
            'C128',
            $this->getMargins()['left'],
            '',
            '',
            '8'
        );
    }

    /**
     * @param  array  $document_data
     * @return void
     * @throws Throwable
     */
    public function pagesConfigs(array $document_data)
    {
        ['document_name' => $name, 'document_number' => $number] = $document_data;

        throw_if(
            (! $number && $number !== '0') || ! $name,
            new Exception('Número ou nome do documento não encontrado')
        );

        $parameters = new Parameters();

        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('MakerLegis');

        $this->SetPrintHeader($parameters->show_header);

        $this->setFooterData($document_data['document_number'], [0, 64, 0]);
        $this->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $this->SetMargins(
            $parameters->margin_left_docs,
            $parameters->space_between_text_and_header,
            $parameters->margin_right_docs
        );
        $this->SetHeaderMargin($parameters->margin_top_docs);
        $this->SetFooterMargin($parameters->margin_bottom_docs);
        $this->SetAutoPageBreak(true, $parameters->margin_bottom_docs + 5);
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->setFontSubsetting(true);
        $this->SetFont('times', '', 12, '', true);
        $this->SetTitle($document_data['document_name']);
    }
}
