<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentModelsRequest;
use App\Http\Requests\UpdateDocumentModelsRequest;
use App\Models\DocumentType;
use App\Repositories\DocumentModelsRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DocumentModelsController extends AppBaseController
{
    /** @var  DocumentModelsRepository */
    private $documentModelsRepository;

    public function __construct(DocumentModelsRepository $documentModelsRepo)
    {
        $this->documentModelsRepository = $documentModelsRepo;
    }

    /**
     * Display a listing of the DocumentModels.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('documentModels.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $documentModels = $this->documentModelsRepository->getAll(0);

        return view('documentModels.index')
            ->with('documentModels', $documentModels);

    }

    /**
     * Show the form for creating a new DocumentModels.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if(!Defender::hasPermission('documentModels.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $document_type = DocumentType::pluck('name', 'id')->prepend('Selecione...', '');;

        return view('documentModels.create')->with('document_type', $document_type);
    }

    /**
     * Store a newly created DocumentModels in storage.
     *
     * @param CreateDocumentModelsRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateDocumentModelsRequest $request)
    {
       if(!Defender::hasPermission('documentModels.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $this->documentModelsRepository->create($input);

        flash('Modelo de documento salvo com sucesso.')->success();

        return redirect(route('documentModels.index'));
    }

    /**
     * Display the specified DocumentModels.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
//        if(!Defender::hasPermission('documentModels.show'))
//        {
//            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
//            return redirect("/");
//        }

        $documentModels = $this->documentModelsRepository->findByID($id);

        if (empty($documentModels)) {
            flash('Modelo de documento não encontrado')->error();

            return redirect(route('documentModels.index'));
        }

        return view('documentModels.show')->with('documentModels', $documentModels);
    }

    /**
     * Show the form for editing the specified DocumentModels.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('documentModels.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $documentModels = $this->documentModelsRepository->findByID($id);

        if (empty($documentModels)) {
            flash('DocumentModels not found')->error();

            return redirect(route('documentModels.index'));
        }

        $document_type = DocumentType::pluck('name', 'id')->prepend('Selecione...', '');

        return view('documentModels.edit')->with('documentModels', $documentModels)->with('document_type', $document_type);
    }

    /**
     * Update the specified DocumentModels in storage.
     *
     * @param int $id
     * @param UpdateDocumentModelsRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateDocumentModelsRequest $request)
    {
        if(!Defender::hasPermission('documentModels.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $documentModels = $this->documentModelsRepository->findByID($id);

        if (empty($documentModels)) {
            flash('DocumentModels not found')->error();

            return redirect(route('documentModels.index'));
        }

        $this->documentModelsRepository->update($documentModels, $request->all());

        flash('Modelo de documento atualizado com sucesso.')->success();

        return redirect(route('documentModels.index'));
    }

    /**
     * Remove the specified DocumentModels from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if(!Defender::hasPermission('documentModels.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $documentModels = $this->documentModelsRepository->findByID($id);

        if (empty($documentModels)) {
            flash('DocumentModels not found')->error();

            return redirect(route('documentModels.index'));
        }

        $this->documentModelsRepository->delete($documentModels);

        flash('DocumentModels deleted successfully.')->success();

        return redirect(route('documentModels.index'));
    }

    /**
     * Update status of specified DocumentModels from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id){
        if(!Defender::hasPermission('documentModels.edit'))
        {
            return json_encode(false);
        }
        $register = $this->documentModelsRepository->findByID($id);
        $register->active = $register->active>0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }
}
