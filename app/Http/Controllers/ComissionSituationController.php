<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComissionSituationRequest;
use App\Http\Requests\UpdateComissionSituationRequest;
use App\Repositories\ComissionSituationRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ComissionSituationController extends AppBaseController
{
    /** @var ComissionSituationRepository */
    private $comissionSituationRepository;

    public function __construct(ComissionSituationRepository $comissionSituationRepo)
    {
        $this->comissionSituationRepository = $comissionSituationRepo;
    }

    /**
     * Display a listing of the ComissionSituation.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('comissionSituations.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $comissionSituations = $this->comissionSituationRepository->getAll(0);

        return view('comissionSituations.index')
            ->with('comissionSituations', $comissionSituations);
    }

    /**
     * Show the form for creating a new ComissionSituation.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('comissionSituations.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('comissionSituations.create');
    }

    /**
     * Store a newly created ComissionSituation in storage.
     *
     * @param CreateComissionSituationRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateComissionSituationRequest $request)
    {
        if (! Defender::hasPermission('comissionSituations.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $this->comissionSituationRepository->create($input);

        flash('Situação da Comissão salva com sucesso.')->success();

        return redirect(route('comissionSituations.index'));
    }

    /**
     * Display the specified ComissionSituation.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('comissionSituations.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $comissionSituation = $this->comissionSituationRepository->findByID($id);

        if (empty($comissionSituation)) {
            flash('Situação da Comissão não encontrada')->error();

            return redirect(route('comissionSituations.index'));
        }

        return view('comissionSituations.show')->with('comissionSituation', $comissionSituation);
    }

    /**
     * Show the form for editing the specified ComissionSituation.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('comissionSituations.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $comissionSituation = $this->comissionSituationRepository->findByID($id);

        if (empty($comissionSituation)) {
            flash('Situação da Comissão não encontrada')->error();

            return redirect(route('comissionSituations.index'));
        }

        return view('comissionSituations.edit')->with('comissionSituation', $comissionSituation);
    }

    /**
     * Update the specified ComissionSituation in storage.
     *
     * @param int $id
     * @param UpdateComissionSituationRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateComissionSituationRequest $request)
    {
        if (! Defender::hasPermission('comissionSituations.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $comissionSituation = $this->comissionSituationRepository->findByID($id);

        if (empty($comissionSituation)) {
            flash('Situação da Comissão não encontrada')->error();

            return redirect(route('comissionSituations.index'));
        }

        $this->comissionSituationRepository->update(
            $comissionSituation,
            $request->all()
        );

        flash('Situação da Comissão atualizado com sucesso.')->success();

        return redirect(route('comissionSituations.index'));
    }

    /**
     * Remove the specified ComissionSituation from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('comissionSituations.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $comissionSituation = $this->comissionSituationRepository->findByID($id);

        if (empty($comissionSituation)) {
            flash('Situação da Comissão não encontrada')->error();

            return redirect(route('comissionSituations.index'));
        }

        $this->comissionSituationRepository->delete($comissionSituation);

        flash('Situação da Comissão removida com sucesso.')->success();

        return redirect(route('comissionSituations.index'));
    }

    /**
     * Update status of specified ComissionSituation from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('comissionSituations.edit')) {
            return json_encode(false);
        }
        $register = $this->comissionSituationRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
