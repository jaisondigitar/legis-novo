<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatusProcessingDocumentRequest;
use App\Http\Requests\UpdateStatusProcessingDocumentRequest;
use App\Repositories\StatusProcessingDocumentRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class StatusProcessingDocumentController extends AppBaseController
{
    /** @var StatusProcessingDocumentRepository */
    private $statusProcessingDocumentRepository;

    public function __construct(StatusProcessingDocumentRepository $statusProcessingDocumentRepo)
    {
        $this->statusProcessingDocumentRepository = $statusProcessingDocumentRepo;
    }

    /**
     * Display a listing of the StatusProcessingDocument.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('statusProcessingDocuments.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $statusProcessingDocuments = $this->statusProcessingDocumentRepository->getAll(0);

        return view('statusProcessingDocuments.index')
            ->with('statusProcessingDocuments', $statusProcessingDocuments);
    }

    /**
     * Show the form for creating a new StatusProcessingDocument.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('statusProcessingDocuments.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('statusProcessingDocuments.create');
    }

    /**
     * Store a newly created Documento de Processamento de Estado in storage.
     *
     * @param CreateStatusProcessingDocumentRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateStatusProcessingDocumentRequest $request)
    {
        if (! Defender::hasPermission('statusProcessingDocuments.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $this->statusProcessingDocumentRepository->create($input);

        flash('Documento de Processamento de Estado salvo com sucesso.')->success();

        return redirect(route('statusProcessingDocuments.index'));
    }

    /**
     * Display the specified StatusProcessingDocument.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
        if (! Defender::hasPermission('statusProcessingDocuments.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findByID($id);

        if (empty($statusProcessingDocument)) {
            flash('Documento de Processamento de Estado não encontrado')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        return view('statusProcessingDocuments.show')->with('statusProcessingDocument', $statusProcessingDocument);
    }

    /**
     * Show the form for editing the specified StatusProcessingDocument.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        if (! Defender::hasPermission('statusProcessingDocuments.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findByID($id);

        if (empty($statusProcessingDocument)) {
            flash('Documento de Processamento de Estado não encontrado')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        return view('statusProcessingDocuments.edit')->with('statusProcessingDocument', $statusProcessingDocument);
    }

    /**
     * Update the specified Documento de Processamento de Estado in storage.
     *
     * @param int $id
     * @param UpdateStatusProcessingDocumentRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateStatusProcessingDocumentRequest $request)
    {
        if (! Defender::hasPermission('statusProcessingDocuments.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findByID($id);

        if (empty($statusProcessingDocument)) {
            flash('Documento de Processamento de Estado não encontrado')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        $this->statusProcessingDocumentRepository->update($statusProcessingDocument, $request->all());

        flash('Documento de Processamento de Estado atualizado com sucesso.')->success();

        return redirect(route('statusProcessingDocuments.index'));
    }

    /**
     * Remove the specified Documento de Processamento de Estado from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if (! Defender::hasPermission('statusProcessingDocuments.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findByID($id);

        if (empty($statusProcessingDocument)) {
            flash('Documento de Processamento de Estado não encontrado')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        $this->statusProcessingDocumentRepository->delete($statusProcessingDocument);

        flash('Documento de Processamento de Estado removido com sucesso.')->success();

        return redirect(route('statusProcessingDocuments.index'));
    }

    /**
     * Update status of specified Documento de Processamento de Estado from storage.
     *
     * @param int $id
     * @return false|string
     * @throws BindingResolutionException
     */
    public function toggle(int $id)
    {
        if (! Defender::hasPermission('statusProcessingDocuments.edit')) {
            return json_encode(false);
        }
        $register = $this->statusProcessingDocumentRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
