<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLawSituationRequest;
use App\Http\Requests\UpdateLawSituationRequest;
use App\Repositories\LawSituationRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class LawSituationController extends AppBaseController
{
    /** @var  LawSituationRepository */
    private $lawSituationRepository;

    public function __construct(LawSituationRepository $lawSituationRepo)
    {
        $this->lawSituationRepository = $lawSituationRepo;
    }

    /**
     * Display a listing of the LawSituation.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('lawSituations.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawSituations = $this->lawSituationRepository->getAll(0);

        return view('lawSituations.index')
            ->with('lawSituations', $lawSituations);
    }

    /**
     * Show the form for creating a new LawSituation.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if(!Defender::hasPermission('lawSituations.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('lawSituations.create');
    }

    /**
     * Store a newly created LawSituation in storage.
     *
     * @param CreateLawSituationRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateLawSituationRequest $request)
    {
       if(!Defender::hasPermission('lawSituations.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $this->lawSituationRepository->create($input);

        flash('Situação Jurídica salva com sucesso.')->success();

        return redirect(route('lawSituations.index'));
    }

    /**
     * Display the specified LawSituation.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if(!Defender::hasPermission('lawSituations.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawSituation = $this->lawSituationRepository->findByID($id);

        if (empty($lawSituation)) {
            flash('Situação Jurídica não encontrada')->error();

            return redirect(route('lawSituations.index'));
        }

        return view('lawSituations.show')->with('lawSituation', $lawSituation);
    }

    /**
     * Show the form for editing the specified LawSituation.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('lawSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $lawSituation = $this->lawSituationRepository->findByID($id);

        if (empty($lawSituation)) {
            flash('Situação Jurídica não encontrada')->error();

            return redirect(route('lawSituations.index'));
        }

        return view('lawSituations.edit')->with('lawSituation', $lawSituation);
    }

    /**
     * Update the specified LawSituation in storage.
     *
     * @param int $id
     * @param UpdateLawSituationRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateLawSituationRequest $request)
    {
        if(!Defender::hasPermission('lawSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawSituation = $this->lawSituationRepository->findByID($id);

        if (empty($lawSituation)) {
            flash('Situação Jurídica não encontrada')->error();

            return redirect(route('lawSituations.index'));
        }

        $this->lawSituationRepository->update($lawSituation, $request->all());

        flash('Situação Jurídica atualizada com sucesso.')->success();

        return redirect(route('lawSituations.index'));
    }

    /**
     * Remove the specified LawSituation from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('lawSituations.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawSituation = $this->lawSituationRepository->findByID($id);

        if (empty($lawSituation)) {
            flash('Situação Jurídica não encontrada')->error();

            return redirect(route('lawSituations.index'));
        }

        $this->lawSituationRepository->delete($lawSituation);

        flash('Situação Jurídica removido com sucesso.')->success();

        return redirect(route('lawSituations.index'));
    }

    /**
     * Update status of specified LawSituation from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id){
        if(!Defender::hasPermission('lawSituations.edit'))
        {
            return json_encode(false);
        }
        $register = $this->lawSituationRepository->findByID($id);
        $register->active = $register->active>0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }
}
