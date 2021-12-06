<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdvicePublicationDocumentsRequest;
use App\Http\Requests\UpdateAdvicePublicationDocumentsRequest;
use App\Repositories\AdvicePublicationDocumentsRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AdvicePublicationDocumentsController extends AppBaseController
{
    /** @var AdvicePublicationDocumentsRepository */
    private $advicePublicationDocumentsRepository;

    public function __construct(AdvicePublicationDocumentsRepository $advicePublicationDocumentsRepo)
    {
        $this->advicePublicationDocumentsRepository = $advicePublicationDocumentsRepo;
    }

    /**
     * Display a listing of the AdvicePublicationDocuments.
     *
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index()
    {
        if (! Defender::hasPermission('advicePublicationDocuments.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->getAll(0);

        return view('advicePublicationDocuments.index')
            ->with('advicePublicationDocuments', $advicePublicationDocuments);
    }

    /**
     * Show the form for creating a new AdvicePublicationDocuments.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('advicePublicationDocuments.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('advicePublicationDocuments.create');
    }

    /**
     * Store a newly created AdvicePublicationDocuments in storage.
     *
     * @param CreateAdvicePublicationDocumentsRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateAdvicePublicationDocumentsRequest $request)
    {
        if (! Defender::hasPermission('advicePublicationDocuments.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $this->advicePublicationDocumentsRepository->create($request->all());

        flash('Aconselhamento de Documentos de Publicação salvos com sucesso.')->success();

        return redirect(route('advicePublicationDocuments.index'));
    }

    /**
     * Display the specified AdvicePublicationDocuments.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
        if (! Defender::hasPermission('advicePublicationDocuments.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findByID($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        return view('advicePublicationDocuments.show')->with('advicePublicationDocuments', $advicePublicationDocuments);
    }

    /**
     * Show the form for editing the specified AdvicePublicationDocuments.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        if (! Defender::hasPermission('advicePublicationDocuments.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findByID($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        return view('advicePublicationDocuments.edit')->with('advicePublicationDocuments', $advicePublicationDocuments);
    }

    /**
     * Update the specified AdvicePublicationDocuments in storage.
     *
     * @param int $id
     * @param UpdateAdvicePublicationDocumentsRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateAdvicePublicationDocumentsRequest $request)
    {
        if (! Defender::hasPermission('advicePublicationDocuments.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findByID($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        $this->advicePublicationDocumentsRepository->update($advicePublicationDocuments, $request->all());

        flash('Aconselhamento de Documentos de Publicação atualizado com sucesso.')->success();

        return redirect(route('advicePublicationDocuments.index'));
    }

    /**
     * Remove the specified AdvicePublicationDocuments from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if (! Defender::hasPermission('advicePublicationDocuments.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findByID($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        $this->advicePublicationDocumentsRepository->delete($advicePublicationDocuments);

        flash('Aconselhamento de Documentos de Publicação removido com sucesso.')->success();

        return redirect(route('advicePublicationDocuments.index'));
    }

    /**
     * Update status of specified AdvicePublicationDocuments from storage.
     *
     * @param int $id
     * @return false|string
     * @throws BindingResolutionException
     */
    public function toggle(int $id)
    {
        if (! Defender::hasPermission('advicePublicationDocuments.edit')) {
            return json_encode(false);
        }
        $register = $this->advicePublicationDocumentsRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
