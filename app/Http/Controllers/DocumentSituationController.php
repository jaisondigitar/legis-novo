<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentSituationRequest;
use App\Http\Requests\UpdateDocumentSituationRequest;
use App\Repositories\DocumentSituationRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DocumentSituationController extends AppBaseController
{
    /** @var DocumentSituationRepository */
    private $documentSituationRepository;

    public function __construct(DocumentSituationRepository $documentSituationRepo)
    {
        $this->documentSituationRepository = $documentSituationRepo;
    }

    /**
     * Display a listing of the DocumentSituation.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('documentSituations.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentSituations = $this->documentSituationRepository->getAll(0);

        return view('documentSituations.index')
            ->with('documentSituations', $documentSituations);
    }

    /**
     * Show the form for creating a new DocumentSituation.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('documentSituations.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('documentSituations.create');
    }

    /**
     * Store a newly created DocumentSituation in storage.
     *
     * @param CreateDocumentSituationRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateDocumentSituationRequest $request)
    {
        if (! Defender::hasPermission('documentSituations.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $this->documentSituationRepository->create($input);

        flash('Situção de Documento salva com secesso.')->success();

        return redirect(route('documentSituations.index'));
    }

    /**
     * Display the specified DocumentSituation.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('documentSituations.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentSituation = $this->documentSituationRepository->findByID($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        return view('documentSituations.show')->with('documentSituation', $documentSituation);
    }

    /**
     * Show the form for editing the specified DocumentSituation.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('documentSituations.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $documentSituation = $this->documentSituationRepository->findByID($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        return view('documentSituations.edit')->with('documentSituation', $documentSituation);
    }

    /**
     * Update the specified DocumentSituation in storage.
     *
     * @param int $id
     * @param UpdateDocumentSituationRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateDocumentSituationRequest $request)
    {
        if (! Defender::hasPermission('documentSituations.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentSituation = $this->documentSituationRepository->findByID($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        $input = $request->all();

        $input['active'] = isset($input['active']) ? 1 : 0;

        $this->documentSituationRepository->update($documentSituation, $input);

        flash('Situção de Documento atualizado com sucesso.')->success();

        return redirect(route('documentSituations.index'));
    }

    /**
     * Remove the specified DocumentSituation from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('documentSituations.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentSituation = $this->documentSituationRepository->findByID($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        $this->documentSituationRepository->delete($documentSituation);

        flash('Situção de Documento removido com sucesso.')->success();

        return redirect(route('documentSituations.index'));
    }

    /**
     * Update status of specified DocumentSituation from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('documentSituations.edit')) {
            return json_encode(false);
        }
        $register = $this->documentSituationRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
