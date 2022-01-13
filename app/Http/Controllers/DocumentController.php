<?php

namespace App\Http\Controllers;

use App\Adapters\TCPDFAdapter;
use App\Enums\DocumentStatuses;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\AdvicePublicationDocuments;
use App\Models\AdviceSituationDocuments;
use App\Models\Assemblyman;
use App\Models\Commission;
use App\Models\Destination;
use App\Models\Document;
use App\Models\DocumentAssemblyman;
use App\Models\DocumentFiles;
use App\Models\DocumentModels;
use App\Models\DocumentNumber;
use App\Models\DocumentProtocol;
use App\Models\DocumentSituation;
use App\Models\DocumentType;
use App\Models\Log;
use App\Models\MeetingPauta;
use App\Models\Parameters;
use App\Models\PartiesAssemblyman;
use App\Models\ProcessingDocument;
use App\Models\ProtocolType;
use App\Models\Sector;
use App\Models\StatusProcessingDocument;
use App\Models\UserAssemblyman;
use App\Repositories\DocumentRepository;
use App\Services\DocumentService;
use App\Services\PDFService;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Jurosh\PDFMerge\PDFMerger;
use TCPDF;
use Throwable;

class DocumentController extends AppBaseController
{
    /**
     * @var StorageService
     */
    private static StorageService $storageService;

    /**
     * @var DocumentService
     */
    private DocumentService $documentService;

    /**
     * @var DocumentRepository
     */
    private DocumentRepository $documentRepository;

    /**
     * @param  DocumentRepository  $documentRepo
     * @throws Throwable
     */
    public function __construct(DocumentRepository $documentRepo)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        date_default_timezone_set('America/Cuiaba');

        $this->documentRepository = $documentRepo;

        static::$storageService = new StorageService();

        $this->documentService = new DocumentService();
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

        $assemblymen = [];
        $assemblymensList = [null => 'Selecione...'];
        foreach ($assemblymens as $assemblyman) {
            $parties = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('date', 'DESC')->first();
            $assemblymensList[$assemblyman->id] = $assemblyman->short_name.' - '.$parties->party->prefix;
        }

        $assemblymens1 = Assemblyman::where('assemblymen.active', '=', 1)->get();
        foreach ($assemblymens1 as $assemblyman) {
            $parties = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('date', 'DESC')->first();
            $assemblymen[$assemblyman->id] = $assemblyman->short_name.' - '.$parties->party->prefix;
        }

        return [$assemblymen, $assemblymensList];
    }

    /**
     * Display a listing of the Document.
     *
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('documents.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $documents_query = Document::query();

        if (data_get($request->all(), 'has-filter')) {
            $documents_query = $documents_query->filterByColumns()
                ->filterByRelation(
                    'document_number',
                    'date',
                    'date',
                    $request->get('reg')
                );

            if (isset(DocumentStatuses::$statuses[$request->get('status')])) {
                if (
                    DocumentStatuses::$statuses[$request->get('status')] ===
                    DocumentStatuses::PROTOCOLED
                ) {
                    $documents_query->hasRelation('document_protocol');
                } elseif (
                    DocumentStatuses::$statuses[$request->get('status')] ===
                    DocumentStatuses::OPENED
                ) {
                    $documents_query->whereDoesntHave('document_protocol');
                }
            }
        }

        $documents = $documents_query->with([
                'processingDocument' => function ($query) {
                    return $query->orderByDesc('created_at')->first();
                },
                'processingDocument.statusProcessingDocument',
                'processingDocument.destination',
                'externalSector',
            ])
            ->orderByDesc('created_at')
            ->paginate(20);

        if (! Auth::user()->hasRoles(['root', 'admin'])) {
            foreach ($documents->items() as $index => $document) {
                if (! $document->document_protocol && $document->users_id !== Auth::user()->id) {
                    unset($documents[$index]);
                }
            }
        }

        $protocol_types = ProtocolType::pluck('name', 'id');
        $assemblymensList = $this->getAssemblymenList();

        return view('documents.index')
            ->with('assemblymensList', $assemblymensList[1])
            ->with('form', $request)
            ->with('documents', $documents)
            ->with('protocol_types', $protocol_types);
    }

    /**
     * Show the form for creating a new Document.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('documents.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $documentType = DocumentType::where('parent_id', 0)->pluck('name', 'id')->prepend('Selecione...', 0);

        $novo = [];
        foreach ($documentType as $key => $doc) {
            $novo[$key] = $doc;
            if ($key > 0) {
                $obj = DocumentType::find($key);
                if (count($obj->childs)) {
                    foreach ($obj->childs as $ch) {
                        $novo[$ch->id] = $doc.' :: '.$ch->name;
                    }
                }
            }
        }

        $documentType = $novo;

        $sector = Sector::where('external', 1)->pluck('name', 'id')->prepend('Selecione...', 0);

        $assemblymensList = $this->getAssemblymenList();

        $document = new Document();

        $tramitacao = Parameters::where('slug', 'realiza-tramite-em-documentos')->first()->value;

        return view('documents.create', compact('document', 'tramitacao'))
            ->with('assemblymen', $assemblymensList[0])
            ->with('assemblymensList', $assemblymensList[1])
            ->with(compact('sector'))
            ->with(compact('documentType'));
    }

    /**
     * Store a newly created Document in storage.
     *
     * @param CreateDocumentRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateDocumentRequest $request)
    {
        if (! Defender::hasPermission('documents.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $request['users_id'] = Auth::user()->id;

        $input = $request->all();

        if (! $input['sector_id']) {
            $input['sector_id'] = null;
        }

        $last_document = Document::where('document_type_id', $request->document_type_id)
            ->whereYear('date', '=', Carbon::parse(str_replace('/', '-', $request->date))->year)
            ->where('number', '!=', '')
            ->orderBy('number', 'DESC')
            ->first();

        $input['number'] = $last_document->number + 1;

        $document = $this->documentRepository->create($input);

        ProcessingDocument::create([
            'document_id' => $document->id,
            'document_situation_id' => DocumentSituation::where('name', 'Encaminhado')->first()->id,
            'status_processing_document_id' => StatusProcessingDocument::where('name', 'Em Trâmitação')
                ->first()->id,
            'processing_document_date' => now()->format('d/m/Y'),
            'destination_id' => Destination::where('name', 'SECRETARIA')->first()->id,
        ]);

        if (! empty($input['assemblymen'])) {
            foreach ($input['assemblymen'] as $assemblyman) {
                $document_asseblyman = new DocumentAssemblyman();
                $document_asseblyman->document_id = $document->id;
                $document_asseblyman->assemblyman_id = $assemblyman;
                $document_asseblyman->save();
            }
        }

        $doc_number = new DocumentNumber();
        $doc_number->document_id = $document->id;
        $doc_number->date = $document->updated_at;
        $doc_number->save();

        $this->documentRepository->update($document, [
            'file' => $this->documentService->saveFile(Document::find($document->id)),
        ]);

        flash('Documento salvo com sucesso.')->success();

        return redirect(route('documents.index'));
    }

    public function show($id)
    {
        $document = Document::find($id);

        if (! $document) {
            flash('Documento não encontrado')->error();

            return redirect(route('documents.index'));
        }

        return response()->redirectTo(
            $this->documentService->openFileInBrowser($document)
        );

        /*$this->createTenantDirectoryIfNotExists();

        $this->pdfService->lib_pdf->Output(storage_path().'/app/documents/doc.pdf', 'F');

        $this->attachFilesToSavedDoc($document);

        $files_to_remove = $document->documents->pluck('filename')->toArray();

        $files_to_remove[] = 'doc.pdf';

        $this->removeUnusedLocalFiles($files_to_remove);*/
    }

    private function attachFilesToSavedDoc(Document $document)
    {
        $pdfMerger = new PDFMerger;

        $pdfMerger->addPDF(storage_path().'/app/documents/doc.pdf');

        $document->documents
            ->each(function ($doc) use ($pdfMerger) {
                $file_content = (new StorageService())->usingDisk('digitalocean')
                    ->inDocumentsFolder()
                    ->getFile($doc->filename);

                (new StorageService())->usingDisk('local')
                    ->usingDisk('local')->inDocumentsFolder()
                    ->sendContent($file_content)
                    ->send(false, $doc->filename);

                $pdfMerger->addPDF(
                    storage_path().'/app/documents/'.$doc->filename
                );
            });

        $pdfMerger->merge(
            'string',
            storage_path().'/app/documents/law-project.pdf'
        );
    }

    public function removeUnusedLocalFiles(array $filenames)
    {
        (new StorageService())->usingDisk('local')
            ->inDocumentsFolder()
            ->removeMany($filenames);
    }

    /**
     * @return void
     */
    private function createTenantDirectoryIfNotExists()
    {
        if (! Storage::exists(storage_path().'/app/documents')) {
            Storage::makeDirectory('documents');
        }
    }

    /**
     * Show the form for editing the specified Document.
     *
     * @param int $id
     *
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('documents.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $document = $this->documentRepository->findByID($id);

        if (empty($document)) {
            flash('Documento não encontrado')->error();

            return redirect(route('documents.index'));
        }

        $documentType = DocumentType::where('parent_id', 0)->pluck('name', 'id')->prepend('Selecione...', 0);

        $novo = [];
        foreach ($documentType as $key => $doc) {
            $novo[$key] = $doc;
            if ($key > 0) {
                $obj = DocumentType::find($key);
                if (count($obj->childs)) {
                    foreach ($obj->childs as $ch) {
                        $novo[$ch->id] = $doc.' :: '.$ch->name;
                    }
                }
            }
        }

        $documentType = $novo;

        $sector = Sector::where('external', 1)->pluck('name', 'id')->prepend('Selecione...', 0);

        $assemblymensList = $this->getAssemblymenList();
        $documentAssemblyman = DocumentAssemblyman::where('document_id', $id)->pluck('assemblyman_id');
        $document_situation = DocumentSituation::pluck('name', 'id')->prepend('Selecione... ', 0);
        $status_processing_document = StatusProcessingDocument::pluck('name', 'id')->prepend('Selecione... ', 0);

        $tramitacao = Parameters::where('slug', 'realiza-tramite-em-documentos')->first()->value;

        $logs = Log::where('auditable_id', $document->id)
            ->where('auditable_type', Document::class)
            ->orderBy('created_at', 'desc')
            ->get();
//

        return view('documents.edit', compact('status_processing_document', 'documentAssemblyman', 'document_situation', 'tramitacao', 'logs'))
            ->with('document', $document)
            ->with('assemblymen', $assemblymensList[0])
            ->with('assemblymensList', $assemblymensList[1])
            ->with(compact('sector'))
            ->with(compact('documentType', 'documentAssemblyman'));
    }

    /**
     * Update the specified Document in storage.
     *
     * @param int $id
     * @param UpdateDocumentRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateDocumentRequest $request)
    {
        if (! Defender::hasPermission('documents.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $document = $this->documentRepository->findByID($id);

        $document_data = $request->validated();

        if (! $document_data['sector_id']) {
            $document_data['sector_id'] = null;
        }

        if (empty($document)) {
            flash('Documento não encontrado')->error();

            return redirect(route('documents.index'));
        }

        $document_data['users_id'] = Auth::user()->id;

        $this->documentRepository->update($document, $document_data);

        DocumentAssemblyman::where('document_id', $id)->delete();

        if (! empty($document_data['assemblymen'])) {
            foreach ($document_data['assemblymen'] as $assemblyman) {
                $document_asseblyman = new DocumentAssemblyman();
                $document_asseblyman->document_id = $document->id;
                $document_asseblyman->assemblyman_id = $assemblyman;
                $document_asseblyman->save();
            }
        }

        $doc_number = new DocumentNumber();
        $doc_number->document_id = $document->id;
        $doc_number->date = $document->fresh()->updated_at;
        $doc_number->save();

        $this->documentRepository->update($document, [
            'file' => $this->documentService->saveFile($document),
        ]);

        flash('Documento editado com sucesso')->success();

        return redirect(route('documents.index'));
    }

    /**
     * Remove the specified Document from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('documents.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $document = $this->documentRepository->findByID($id);

        if (empty($document)) {
            flash('Documento não encontrado')->error();

            return redirect(route('documents.index'));
        }

        if (MeetingPauta::where('document_id', $document->id)->get()->count() > 0) {
            flash('Registro em uso, não pode ser removido!')->error();

            return redirect(route('documents.index'));
        }

        $this->documentRepository->delete($document);

        flash('Documento deletado com sucesso.')->success();

        return redirect(route('documents.index'));
    }

    /**
     * Update status of specified Document from storage.
     *
     * @param  int $id
     */
    public function toggleRead($id)
    {
        if (! Defender::hasPermission('document.read')) {
            return json_encode(false);
        }
        $register = $this->documentRepository->findByID($id);
        $register->read = $register->read > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function toggleApproved($id)
    {
        if (! Defender::hasPermission('document.approved')) {
            return json_encode(false);
        }
        $register = $this->documentRepository->findByID($id);
        $register->approved = $register->approved > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function attachament($id)
    {
        if (! Defender::hasPermission('documents.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/documents');
        }

        $document = Document::find($id);
        $document_files = DocumentFiles::where('document_id', $document->id)->get();
        $doc_ids = DocumentFiles::withTrashed()->where('document_id', $document->id)->pluck('id')
            ->toArray();

        $logs = Log::whereIn('auditable_id', $doc_ids)
            ->where('auditable_type', DocumentFiles::class)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('documents.attachament')->with(compact('document', 'document_files', 'logs'));
    }

    public function attachamentUpload($id, Request $request)
    {
        if (! Defender::hasPermission('documents.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/documents');
        }

        $document = Document::find($id);
        $files = $request->file('file');

        if ($files) {
            foreach ($files as $file) {
                $filename = static::$storageService
                    ->inDocumentsFolder()
                    ->sendFile($file)
                    ->send();

                $document_files = new DocumentFiles();
                $document_files->document_id = $document->id;
                $document_files->filename = $filename;
                $document_files->save();
            }
        }

        return Redirect::route('documents.attachament', $document->id);
    }

    public function attachamentDelete($id)
    {
        $file = DocumentFiles::find($id);
        $file->delete();

        return 'true';
    }

    public function documentProtocol($id)
    {
        $document = Document::find($id);

        $year = explode('/', $document->date);
        $year = $year[2];

        $last_document = Document::where('document_type_id', $document->document_type_id)
            ->whereYear('date', '=', $year)
            ->where('number', '!=', '')
            ->orderBy('number', 'DESC')
            ->first();

        $protocol_number = substr(md5(uniqid(mt_rand(), true)), 0, 8);

        if ($last_document) {
            $last_number = explode('/', $last_document->number);
            $next_number = $last_number[0] + 1;
            $data = ['document_id' => $id, 'protocol_number' => $protocol_number, 'next_number' => $next_number, 'year' => $year];

            return ['success' => 'true', 'data' => $data];
        } else {
            $next_number = 1;
            $data = ['document_id' => $id, 'protocol_number' => $protocol_number, 'next_number' => $next_number, 'year' => $year];

            return ['success' => 'false', 'data' => $data];
        }
    }

    public function documentProtocolSave()
    {
        $input = \Illuminate\Support\Facades\Request::all();

        $document = Document::find($input['document_id']);

        $year = explode('/', $document->date);
        $year = $year[2];

        $parameter = Parameters::where('slug', 'permitir-criar-documentos-fora-da-sequencia')->first();
        $parameterAssemblyman = Parameters::where('slug', 'permitir-criar-numero-de-projetos-e-documentos-para-mesmo-vereadores')->first();

        if ($parameter->value == 0) {
            $document_verify = Document::where('document_type_id', $document->document_type_id)
                ->whereYear('date', '=', $year);

            if ($parameterAssemblyman->value == 1) {
                $document_verify = $document_verify->where('owner_id', $document->owner_id);
            }

            $document_verify = $document_verify->where('number', '>=', $input['next_number'])
                ->orderBy('number', 'DESC')
                ->first();
        } else {
            $document_verify = Document::where('document_type_id', $document->document_type_id)
                ->whereYear('date', '=', $year);

            if ($parameterAssemblyman->value == 1) {
                $document_verify = $document_verify->where('owner_id', $document->owner_id);
            }

            $document_verify = $document_verify->where('number', '=', $input['next_number'])
                ->orderBy('number', 'DESC')
                ->first();
        }

        if ($document_verify) {
            return ['success' => false, 'message' => 'Número já utilizado ou inferior ao último, a sua sugestão foi atualizada!', 'next_number' => $input['next_number_origin']];
        } else {
            $document = Document::find($input['document_id']);
            $document->number = $input['next_number'];

            if ($document->save()) {
                $document_protocol = new DocumentProtocol();
                $document_protocol->document_id = $input['document_id'];
                $document_protocol->protocol_type_id = $input['protocol_type_id'];
                $document_protocol->number = $input['protocol_number'];
                if ($document_protocol->save()) {
                    $date = explode('/', $input['protocol_date']);
                    $time = explode(' ', $date[2]);

                    $document_protocol = $document_protocol;
                    $document_protocol->created_at = $time[0].'-'.$date[1].'-'.$date[0].$time[1];
                    $document_protocol->save();

                    $protocol_type = ProtocolType::find($input['protocol_type_id']);
                    if ($document_protocol->protocol_type->slug == 'automatico') {
                        $code = $document_protocol->number;
                    } else {
                        $code = $document_protocol->number;
                    }
                    $protocol_number = $input['next_number'].'/'.$year;

                    return ['success' => true,
                        'message' => 'Protocolado com sucesso!',
                        'document_id' => $input['document_id'],
                        'protocol_type' => $protocol_type->slug,
                        'protocol_code' => $code,
                        'protocol_date' => date('d/m/Y H:i:s', strtotime($document->document_protocol->created_at)),
                        'protocol_number' => $protocol_number, ];
                } else {
                    return ['success' => false, 'message' => 'Oops!, tente novamente!'];
                }
            }
        }
    }

    public function deleteBash(Request $request)
    {
        $input = $request->all();

        Document::destroy($input['ids']);

        return json_encode($input['ids']);
    }

    public function findTextInitial(Request $request)
    {
        $input = $request->all();

        $obj = DocumentModels::where('document_type_id', $input['id'])->first();

        return json_encode($obj);
    }

    public function alteraProtocolo(Request $request)
    {
        $input = $request->all();

        $date = $input['date_protocolo'];

        $date = explode('/', $date);
        $date1 = explode(' ', $date[2]);

        $date_res = $date1[0].'-'.$date[1].'-'.$date[0].' '.$date1[1];

//        dd($date, $date1, $date_res);

        $documentVerify = DocumentProtocol::where('number', $input['protocolo'])->whereYear('created_at', '=', $date1[0])->get();

        if (count($documentVerify) == 0) {
            $documentProtocol = DocumentProtocol::where('document_id', $input['id'])->first();

            if ($documentProtocol) {
                $documentProtocol->number = $input['protocolo'];
                $documentProtocol->created_at = $date_res;

                $documentProtocol->save();

                return json_encode($documentProtocol);
            }
        }

        return json_encode(false);
    }

    public function alteraNumero(Request $request)
    {
        $input = \Illuminate\Support\Facades\Request::all();

        $document = Document::find($input['document_id']);

        $year = explode('/', $document->date);
        $year = $year[2];

        $parameter = Parameters::where('slug', 'permitir-criar-documentos-fora-da-sequencia')->first();
        $parameterAssemblyman = Parameters::where('slug', 'permitir-criar-numero-de-projetos-e-documentos-para-mesmo-vereadores')->first();

        if ($parameter->value == 0) {
            $document_verify = Document::whereYear('date', '=', $year);

            if ($parameterAssemblyman->value == 1) {
                $document_verify = $document_verify->where('owner_id', $document->owner_id);
            }

            $document_verify = $document_verify->where('number', '>=', $input['doc_number'])
                ->orderBy('number', 'DESC')
                ->first();
        } else {
            $document_verify = Document::whereYear('date', '=', $year);

            if ($parameterAssemblyman->value == 1) {
                $document_verify = $document_verify->where('owner_id', $document->owner_id);
            }

            $document_verify = $document_verify->where('number', '=', $input['doc_number'])
                ->orderBy('number', 'DESC')
                ->first();
        }

        if ($document_verify) {
            return ['success' => false, 'message' => 'Número já utilizado ou inferior ao último, a sua sugestão foi atualizada!', 'next_number' => $input['doc_number']];
        } else {
            $document = Document::find($input['document_id']);
            $document->number = $input['doc_number'];
//            $document->version = $input['version'];

            if ($document->save()) {
                return ['success' => true, 'message' => 'Número foi atualizado!', 'next_number' => $input['doc_number'].'/'.$year, 'id' => $document->id];
            }
        }
    }

    public function advices($documentId)
    {
        setlocale(LC_ALL, 'pt_BR');
        $document = $this->documentRepository->findByID($documentId);

        if (empty($document)) {
            flash('Documento não encontrado')->error();

            return redirect(route('documents.index'));
        }

        $comission = Commission::active()->pluck('name', 'id');
        $tramitacao = Parameters::where('slug', 'realiza-tramite-em-documentos')->first()->value;

        $document_situation = DocumentSituation::pluck('name', 'id')->prepend('Selecione... ', 0);
        $advice_situation_document = AdviceSituationDocuments::pluck('name', 'id')->prepend('Selecione...', '');
        $advice_publication_document = AdvicePublicationDocuments::pluck('name', 'id')->prepend('Selecione...', '');
        $status_processing_document = StatusProcessingDocument::pluck('name', 'id')->prepend('Selecione...', '');

        $destinations = Destination::pluck('name', 'id')->prepend('Selecione...', '');

        return view(
            'documents.advices',
            compact(
                'document_situation',
                'comission',
                'tramitacao',
                'advice_situation_document',
                'advice_publication_document',
                'status_processing_document',
                'destinations'
            )
        )
            ->with(compact('document'));
    }

    public function importNumber()
    {
        $documents = Document::all();

        if (empty($documents)) {
            flash('Documento não encontrado')->error();

            return redirect(route('documents.index'));
        }

        $data = [];
        foreach ($documents as $document) {
            $data[] = [
                'document_id' => $document->id,
                'date' => $document->updated_at,
            ];
        }

        DocumentNumber::insert($data);

        flash('Documentos migrados com sucesso!')->success();

        return redirect(route('documents.index'));
    }
}
