<?php

namespace App\Services;

use App\Adapters\TCPDFAdapter;
use App\Models\Document;
use App\Models\DocumentAssemblyman;
use App\Models\DocumentModels;
use App\Models\Parameters;
use App\Models\PartiesAssemblyman;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Throwable;

class DocumentService
{
    /**
     * @var PDFService
     */
    private PDFService $pdfService;

    /**
     * @var StorageService
     */
    private StorageService $storageService;

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->pdfService = new PDFService(new TCPDFAdapter());

        $this->storageService = new StorageService();
    }

    /**
     * @param  Document  $document
     * @return string
     * @throws Throwable
     */
    public function saveFile(Document $document): string
    {
        $this->buildDocument($document);

        return $this->storageService
            ->inDocumentsFolder()
            ->sendContent($this->pdfService->fileToString())
            ->send(false, Str::random(32).'.pdf');
    }

    /**
     * @param  Document  $document
     * @return string
     * @throws Throwable
     */
    public function openFileInBrowser(Document $document): string
    {
        throw_if(! $document->file, new Exception('Documento sem arquivo armazenado'));

        return $this->storageService->inDocumentsFolder()->getPath($document->file);
    }

    /**
     * @param  Document  $document
     * @return void
     */
    private function buildDocument(Document $document)
    {
        $assemblymen_list = $this->getAssemblymanList($document);

        $document_data = [
            'additional_info' => $this->generateAdditionalInformation($document),
            'document' => $document,
            'default_content' => $this->generateDefaultPage($assemblymen_list),
            'document_model' => DocumentModels::documentModel(
                $document->type->id ?? $document->type->parent_id
            )->first(),
            'advices_content' => $this->generateAdvicesPage($assemblymen_list),
            'votes_content' => $this->generateVotesPage($assemblymen_list),
        ];

        $this->pdfService
            ->pagesConfigs($document)
            ->newPage()->writeContent(
                $document_data['document_model'] ?
                    $this->bindData($document_data) :
                    $document->content
            );

        if ($this->showAdvicesPage()) {
            $this->pdfService->newPage()->writeContent(
                $this->performAdvices($document)
            );
        }

        if ($this->showAdvicesPage()) {
            $this->pdfService->lib_pdf->setListIndentWidth(5);

            $this->pdfService->newPage()->writeContent(
                $this->performVotes($document)
            );
        }
    }

    /**
     * @param  Document  $document
     * @return array
     */
    private function getAssemblymanList(Document $document): array
    {
        $date = Carbon::parse(str_replace('/', '-', $document->date))
            ->format('Y-m-d');

        $list[0][0] = $document->owner->short_name;

        if (
            count($document->owner
                ->responsibility_assemblyman()
                ->where('date', '<=', $date)
                ->get()) > 1
        ) {
            $list[0][1] = $document->owner->responsibility_assemblyman()
                    ->orderBy('date')
                    ->where('date', '<=', $date)
                    ->get()
                    ->last()
                    ->responsibility
                    ->name.'(a) ';
        } else {
            if (count($document->owner->responsibility_assemblyman) > 0) {
                $list[0][1] = $document->owner->responsibility_assemblyman()
                        ->first()
                        ->responsibility
                        ->name.'(a) ';
            } else {
                $list[0][1] = 'Vereador(a) ';
            }
        }

        $list[0][4] = 0;
        $list[0][2] = 'Vereador(a) ';
        $list[0][3] = PartiesAssemblyman::where('assemblyman_id', $document->owner->id)
            ->orderBy('date', 'DESC')
            ->first()
            ->party
            ->prefix;

        $assemblymen = DocumentAssemblyman::getAssemblyman($document->id)->get();

        if ($assemblymen->isNotEmpty()) {
            foreach ($assemblymen as $key => $assemblyman) {
                $list[$key + 1][0] = $assemblyman->assemblyman->short_name;
                if (count($assemblyman->assemblyman->responsibility_assemblyman()->get()) > 1) {
                    $list[$key + 1][1] = $this->getResponsibility($assemblyman, $date);
                } else {
                    $list[$key + 1][1] = count(
                        $assemblyman->assemblyman->responsibility_assemblyman
                    ) === 0 ?
                        '-' :
                        $assemblyman->assemblyman->responsibility_assemblyman()
                            ->first()->responsibility->name.'(a) ';
                }
            }
        }

        if ($assemblymen->isNotEmpty()) {
            foreach ($assemblymen as $key => $assemblyman) {
                $list[$key + 1][0] = $assemblyman->assemblyman->short_name;
                $list[$key + 1][1] = $this->getResponsibility($assemblyman, $date);
                $list[$key + 1][4] = $this->getOrder($assemblyman, $date);
                $list[$key + 1][2] = 'Vereador(a) ';
                $list[$key + 1][3] = PartiesAssemblyman::where(
                    'assemblyman_id',
                    $assemblyman->assemblyman->id
                )
                    ->orderBy('date', 'DESC')
                    ->first()
                    ->party
                    ->prefix;
            }
        }

        return $list;
    }

    /**
     * @param $assemblyman
     * @param $date
     * @return string
     */
    public function getResponsibility($assemblyman, $date): string
    {
        if (
            count($assemblyman->assemblyman
                ->responsibility_assemblyman()
                ->where('date', '<=', $date)
                ->get()) > 1
        ) {
            return $assemblyman->assemblyman
                    ->responsibility_assemblyman()
                    ->orderBy('date')
                    ->where('date', '<=', $date)
                    ->get()
                    ->last()
                    ->responsibility->name.'(a) ';
        }

        if (count($assemblyman->assemblyman->responsibility_assemblyman) === 1) {
            return $assemblyman->assemblyman->responsibility_assemblyman()->first()
                    ->responsibility->name.'(a) ';
        }

        return 'Vereador(a) ';
    }

    /**
     * @param $assemblyman
     * @param  string  $date
     * @return int|mixed
     */
    public function getOrder($assemblyman, string $date)
    {
        if (
            count($assemblyman->assemblyman
                ->responsibility_assemblyman()
                ->where('date', '<=', $date)
                ->get()) > 1
        ) {
            return $assemblyman->assemblyman
                ->responsibility_assemblyman()
                ->orderBy('date')
                ->where('date', '<=', $date)
                ->get()
                ->last()
                ->responsibility
                ->order;
        }

        if (count($assemblyman->assemblyman->responsibility_assemblyman) === 1) {
            return $assemblyman->assemblyman
                ->responsibility_assemblyman()
                ->first()
                ->responsibility->order;
        }

        return 15;
    }

    /**
     * @param  Document  $document
     * @return array
     */
    private function generateAdditionalInformation(Document $document): array
    {
        $has_document_protocol = collect($document->document_protocol)->isNotEmpty();

        return [
            'type' => $document->document_type->parent_id ?
                "{$document->document_type->parent->name} :: {$document->document_type->name}" :
                $document->document_type->name,
            'number' => $document->number === 0 ? '_______ ' : $document->number,
            'internal_number' => $document->getNumber(),
            'protocol_number' => $has_document_protocol ?
                $document->document_protocol->number : '',
            'protocol_date' => $has_document_protocol ?
                date('d/m/Y', strtotime($document->document_protocol->created_at)) : '',
            'protocol_hours' => $has_document_protocol ?
                date('H:i', strtotime($document->document_protocol->created_at)) : '',
            'date_in_text' => Carbon::createFromFormat(
                'd/m/Y',
                $document->date
            )->locale('pt_BR')->isoFormat('LL'),
        ];
    }

    /**
     * @return bool
     */
    public function showAdvicesPage(): bool
    {
        $parameters = new Parameters();

        return (bool) $parameters->perform_docs_advices;
    }

    /**
     * @return bool
     */
    public function showVotesPage(): bool
    {
        $parameters = new Parameters();

        return (bool) $parameters->show_docs_votes;
    }

    /**
     * @param  Document  $document
     * @return string
     */
    public function performAdvices(Document $document): string
    {
        $content = '<link
                        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css"
                        rel="stylesheet"
                    >
                    <h3 style="width:100%; text-align: center;"> Tramitação </h3>
                    <table
                        cellspacing="10"
                        cellpadding="10"
                        style=" margin-top: 300px; width:100%;"
                    >
                    <tbody>';

        foreach (
            $document->processingDocument()
                ->orderByDesc('processing_document_date')
                ->get() as $processing
        ) {
            $content .= "<hr>
                        <tr style='text-align: left;'>
                        <td
                            width='100'
                            style='text-align: left;'
                        >
                                <b>Data: </b>
                                <br>
                                {$processing->processing_document_date}
                        </td>
                        <td
                            width='150'
                            style='text-align: left;'
                        >
                                <b>Situação do documento: </b>
                                <br>
                                {$processing->documentSituation->name}
                        </td>";

            if ($processing->statusProcessingDocument) {
                $content .= "<td
                                width='150'
                                style='text-align: left;'
                            >
                                <b>Status do tramite: </b>
                                <br>
                                {$processing->statusProcessingDocument->name}
                            </td>";
            }

            $content .= '</tr>';

            if (strlen($processing->observation) > 0) {
                $content .= "<tr>
                            <td
                                width='650'
                                style='text-align: justify;'
                            >
                                <b>Observação: </b>
                                <br>
                                {$processing->observation}
                            </td>
                            </tr>";
            }
        }

        $content .= '</tbody></table>';

        return $content;
    }

    /**
     * @param  Document  $document
     * @return string
     */
    public function performVotes(Document $document): string
    {
        $content = '<table
                        cellspacing="10"
                        cellpadding="10"
                        style="margin-top: 300px; width:100%;"
                    ><tbody>
                    <tr style="height: 300px">
                    <td style="width:100%; text-align: center;"><h3> Votação </h3></td>
                    </tr>
                    </tbody></table>
                    <table style=" text-align: left;">';

        foreach ($document->voting()->get() as $item) {
            $content .= '<tr style="text-align: left;">
                        <td style="text-align: left;">
                            Data da votação: '.date('d/m/Y', strtotime($item->open_at)).'
                        </td>
                        <td style="text-align: left;">Situação: </td>';

            if ($item->situation($item)) {
                $content .= 'Votação Aprovada';
            } else {
                $content .= 'Votação Reprovada';
            }

            $content .= '</td>
                        <br>
                        </tr>';
        }

        $content .= '</table>
                    <br>';

        return $content;
    }

    /**
     * @param  array  $document_data
     * @return array|string|string[]
     */
    public function bindData(array $document_data)
    {
        [
            'additional_info' => $additional_info,
            'document' => $document,
            'default_content' => $default_content,
            'advices_content' => $advices_content,
            'votes_content' => $votes_content,
            'document_model' => $document_model
        ] = $document_data;

        return str_replace(
            [
                '[numero]',
                '[data_curta]',
                '[data_longa]',
                '[autores]',
                '[autores_vereador]',
                '[nome_vereadores]',
                '[responsavel]',
                '[assunto]',
                '[conteudo]',
                '[protocolo_numero]',
                '[protocolo_data]',
                '[protocolo_hora]',
                '[numero_interno]',
                '[numero_documento]', '[ano_documento]', '[tipo_documento]',
            ],
            [
                "<b>
                    {$additional_info['type']}
                </b>: {$additional_info['number']} / {$document->getYear($document->date)}",
                Carbon::parse(str_replace('/', '-', $document->date))
                    ->format('d/m/Y'),
                $additional_info['date_in_text'],
                $default_content,
                $advices_content,
                $votes_content,
                $document->owner->short_name,
                $document->content,
                $document->content,
                $additional_info['protocol_number'],
                $additional_info['protocol_date'],
                $additional_info['protocol_hours'],
                $additional_info['internal_number'],
                $additional_info['number'],
                $document->getYear($document->date),
                $additional_info['type'],
            ],
            $document_model->content
        );
    }

    /**
     * @param $assemblyman_list
     * @return string
     */
    private function generateVotesPage($assemblyman_list): string
    {
        if (count($assemblyman_list) === 1) {
            return '<table
                        cellspacing="10"
                        cellpadding="10"
                        style="margin-top: 300px; width:100%;"
                    ><tbody>
                    <tr style="height: 300px">
                    <td style="width:25%;"></td>
                    <td
                        style="width:50%; text-align: center; vertical-align: text-top"
                    >
                        '.$assemblyman_list[0][0].'<br>'.'<br><br><br>
                    </td>
                    <td style="width:25%;"></td>
                    </tr>
                    </tbody></table>';
        } else {
            $count = 0;

            $content = '<table
                            cellspacing="10"
                            cellpadding="10"
                            style="position:absolute; width: 100%; margin-top: 300px"
                        ><tbody>';

            foreach ($assemblyman_list as $vereador) {
                if ($count === 0) {
                    $content .= '<tr style="height: 300px">';
                }

                $content .= '<td
                                style="text-align: center; vertical-align: text-top"
                            >
                                '.$vereador[0].'<br>'.'<br><br><br>
                            </td>';

                if ($count === 2 || $vereador === end($assemblyman_list)) {
                    $content .= '</tr>';

                    $count = 0;
                } else {
                    $count++;
                }
            }

            $content .= '</tbody></table>';

            return $content;
        }
    }

    /**
     * @param $assemblyman_list
     * @return string
     */
    private function generateAdvicesPage($assemblyman_list): string
    {
        if (count($assemblyman_list) === 1) {
            return '<table
                        cellspacing="10"
                        cellpadding="10"
                        style=" margin-top: 300px; width:100%;"
                    ><tbody>
                    <tr style="height: 300px">
                    <td style="width:25%;"></td>
                    <td
                        style="width:50%; text-align: center; vertical-align: text-top"
                    >
                        '.$assemblyman_list[0][0].'<br>
                        '.$assemblyman_list[0][2].' - 
                        '.$assemblyman_list[0][3].'<br><br><br>
                    </td>
                    <td style="width:25%;"></td>
                    </tr>
                    </tbody></table>';
        } else {
            $count = 0;

            $content = '<table
                            cellspacing="10"
                            cellpadding="10"
                            style="position:absolute; width: 100%; margin-top: 300px"
                        ><tbody>';

            foreach ($assemblyman_list as $vereador) {
                if ($count === 0) {
                    $content .= '<tr style="height: 300px">';
                }

                $content .= '<td
                                style="text-align: center; vertical-align: text-top"
                            >
                                '.$vereador[0].'<br>
                                '.$vereador[1].' - 
                                '.$vereador[3].'<br><br><br>
                            </td>';

                if ($count === 2 || $vereador === end($assemblyman_list)) {
                    $content .= '</tr>';

                    $count = 0;
                } else {
                    $count++;
                }
            }

            $content .= '</tbody></table>';

            return $content;
        }
    }

    /**
     * @param $assemblyman_list
     * @return string
     */
    private function generateDefaultPage($assemblyman_list): string
    {
        $assemblyman_list = collect($assemblyman_list)->sortBy('4')->toArray();

        if (count($assemblyman_list) === 1) {
            return '<table
                        cellspacing="10"
                        cellpadding="10"
                        style="margin-top: 300px; width:100%;"
                    ><tbody>
                    <tr style="height: 300px">
                    <td style="width:25%;"></td>
                    <td
                        style="width:50%; text-align: center; vertical-align: text-top"
                    >
                        '.$assemblyman_list[0][0].'<br>
                        '.$assemblyman_list[0][1].' - 
                        '.$assemblyman_list[0][3].'<br><br><br>
                    </td>
                    <td style="width:25%;"></td>
                    </tr>
                    </tbody></table>';
        } else {
            $count = 0;

            $content = '<table
                            cellspacing="10"
                            cellpadding="10"
                            style="position:absolute; width: 100%; margin-top: 300px"
                        ><tbody>';

            foreach ($assemblyman_list as $vereador) {
                $content .= $count === 0 ?: '<tr style="height: 300px">';
                $content .= '<td
                                style="text-align: center; vertical-align: text-top"
                            >
                                '.$vereador[0].'<br>
                                '.$vereador[1].' - 
                                '.$vereador[3].'<br><br><br>
                            </td>';

                if ($count === 2 || $vereador === end($assemblyman_list)) {
                    $content .= '</tr>';

                    $count = 0;
                } else {
                    $count++;
                }
            }

            $content .= '</tbody></table>';

            return $content;
        }
    }
}
