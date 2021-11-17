<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdviceSituationDocumentsRequest;
use App\Http\Requests\UpdateAdviceSituationDocumentsRequest;
use App\Repositories\AdviceSituationDocumentsRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AdviceSituationDocumentsController extends AppBaseController
{
    /** @var  AdviceSituationDocumentsRepository */
    private $adviceSituationDocumentsRepository;

    public function __construct(AdviceSituationDocumentsRepository $adviceSituationDocumentsRepo)
    {
        $this->adviceSituationDocumentsRepository = $adviceSituationDocumentsRepo;
    }

    /**
     * Display a listing of the AdviceSituationDocuments.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->getAll(0);

        return view('adviceSituationDocuments.index')
            ->with('adviceSituationDocuments', $adviceSituationDocuments);
    }

    /**
     * Show the form for creating a new AdviceSituationDocuments.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if(!Defender::hasPermission('adviceSituationDocuments.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('adviceSituationDocuments.create');
    }

    /**
     * Store a newly created AdviceSituationDocuments in storage.
     *
     * @param CreateAdviceSituationDocumentsRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateAdviceSituationDocumentsRequest $request)
    {
       if(!Defender::hasPermission('adviceSituationDocuments.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $this->adviceSituationDocumentsRepository->create($input);

        flash('Situação de Aconselhamento de Documentos salvo com sucesso.')->success();

        return redirect(route('adviceSituationDocuments.index'));
    }

    /**
     * Display the specified AdviceSituationDocuments.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findByID($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        return view('adviceSituationDocuments.show')->with('adviceSituationDocuments', $adviceSituationDocuments);
    }

    /**
     * Show the form for editing the specified AdviceSituationDocuments.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findByID($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        return view('adviceSituationDocuments.edit')->with('adviceSituationDocuments', $adviceSituationDocuments);
    }

    /**
     * Update the specified AdviceSituationDocuments in storage.
     *
     * @param int $id
     * @param UpdateAdviceSituationDocumentsRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateAdviceSituationDocumentsRequest $request)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findByID($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        $this->adviceSituationDocumentsRepository->update($adviceSituationDocuments,
            $request->all());

        flash('Situação de Aconselhamento de Documentos atualizado com sucesso.')->success();

        return redirect(route('adviceSituationDocuments.index'));
    }

    /**
     * Remove the specified AdviceSituationDocuments from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findByID($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        $this->adviceSituationDocumentsRepository->delete($adviceSituationDocuments);

        flash('Situação de Aconselhamento de Documentos removido com sucesso.')->success();

        return redirect(route('adviceSituationDocuments.index'));
    }

    /**
     * Update status of specified AdviceSituationDocuments from storage.
     *
     * @param int $id
     * @return false|string
     * @throws BindingResolutionException
     */
    public function toggle(int $id){
        if(!Defender::hasPermission('adviceSituationDocuments.edit'))
        {
            return json_encode(false);
        }
        $register = $this->adviceSituationDocumentsRepository->findByID($id);
        $register->active = $register->active>0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }
}
