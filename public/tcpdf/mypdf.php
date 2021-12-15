<?php

use App\Models\Company;
use App\Services\StorageService;

require_once public_path().'/tcpdf/tcpdf.php';


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        $image_file = (new StorageService())->inCompanyFolder()
            ->getPath(Company::first()->image);
        $this->Image($image_file, $this->lMargin, $this->header_margin, 25, 0, '', '', 'T', true, 300, '', false, false, 0, false, false, false);

        $this->SetXY($this->lMargin + 34, $this->header_margin);
        $this->SetFont('helvetica', 'B', 15);
        $title = mb_strtoupper(Company::first()->shortName, 'UTF-8');

        $this->Cell(100, 0, $title, 0, 0, 'L');
        $this->SetFont('helvetica', '', 10);
        $this->SetXY($this->lMargin + 34, $this->header_margin + 6);
        $this->Cell(100, 0, 'ESTADO DE '.mb_strtoupper(Company::first()->getState->name, 'UTF-8'), 0, 0, 'L');
        $this->SetFont('helvetica', '', 9);
        $this->SetXY($this->lMargin + 34, $this->header_margin + 13);
        $this->Cell(100, 0, mb_strtoupper(Company::first()->address, 'UTF-8'), 0, 0, 'L');
        $this->SetXY($this->lMargin + 34, $this->header_margin + 18);
        $this->Cell(100, 0, 'CNPJ: '.mb_strtoupper(Company::first()->cnpjCpf, 'UTF-8'), 0, 0, 'L');
        $this->SetXY($this->lMargin + 34, $this->header_margin + 23);
        $this->Cell(100, 0, 'FONE: '.mb_strtoupper(Company::first()->phone1, 'UTF-8'), 0, 0, 'L');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom

        $menorvalor = $this->getFooterMargin();

        $this->SetY(-$menorvalor);
        // Set font
        $this->SetFont(PDF_FONT_NAME_DATA, '', 9);
        $this->Cell(0, $this->rMargin, 'PÁGINA '.$this->getAliasNumPage().' DE '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'T');

        $this->SetX($this->lMargin);
        $this->SetY(-($menorvalor + 7));
        $this->Write(10, 'DOC: '.($this->docNumber ?? ''));
        $this->SetY(-$menorvalor);
        $this->write1DBarcode(($this->docNumber ?? ''), 'C128', $this->lMargin, '', '', '8');
    }

    public function Output($name = 'doc.pdf', $dest = 'I')
    {
        $this->tcpdflink = false;

        return parent::Output($name, $dest);
    }
}
