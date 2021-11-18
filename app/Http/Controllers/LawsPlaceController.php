<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLawsPlaceRequest;
use App\Http\Requests\UpdateLawsPlaceRequest;
use App\Repositories\LawsPlaceRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class LawsPlaceController extends AppBaseController
{
    /** @var  LawsPlaceRepository */
    private $lawsPlaceRepository;

    public function __construct(LawsPlaceRepository $lawsPlaceRepo)
    {
        $this->lawsPlaceRepository = $lawsPlaceRepo;
    }

    /**
     * Display a listing of the LawsPlace.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('lawsPlaces.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsPlaces = $this->lawsPlaceRepository->getAll(0);

        return view('lawsPlaces.index')
            ->with('lawsPlaces', $lawsPlaces);
    }

    /**
     * Show the form for creating a new LawsPlace.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if(!Defender::hasPermission('lawsPlaces.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('lawsPlaces.create');
    }

    /**
     * Store a newly created LawsPlace in storage.
     *
     * @param CreateLawsPlaceRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateLawsPlaceRequest $request)
    {
       if(!Defender::hasPermission('lawsPlaces.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $this->lawsPlaceRepository->create($input);

        flash('Lugar da Lei salvo com sucesso.')->success();

        return redirect(route('lawsPlaces.index'));
    }

    /**
     * Display the specified LawsPlace.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if(!Defender::hasPermission('lawsPlaces.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsPlace = $this->lawsPlaceRepository->findByID($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        return view('lawsPlaces.show')->with('lawsPlace', $lawsPlace);
    }

    /**
     * Show the form for editing the specified LawsPlace.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('lawsPlaces.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $lawsPlace = $this->lawsPlaceRepository->findByID($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        return view('lawsPlaces.edit')->with('lawsPlace', $lawsPlace);
    }

    /**
     * Update the specified LawsPlace in storage.
     *
     * @param int $id
     * @param UpdateLawsPlaceRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateLawsPlaceRequest $request)
    {
        if(!Defender::hasPermission('lawsPlaces.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsPlace = $this->lawsPlaceRepository->findByID($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        $this->lawsPlaceRepository->update($lawsPlace, $request->all());

        flash('Lugar da Lei atualizado com sucesso.')->success();

        return redirect(route('lawsPlaces.index'));
    }

    /**
     * Remove the specified LawsPlace from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('lawsPlaces.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsPlace = $this->lawsPlaceRepository->findByID($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        $this->lawsPlaceRepository->delete($lawsPlace);

        flash('Lugar da Lei removido com sucesso.')->success();

        return redirect(route('lawsPlaces.index'));
    }


    /**
     * Update status of specified LawsPlace from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id){
        if(!Defender::hasPermission('lawsPlaces.edit'))
        {
            return json_encode(false);
        }
        $register = $this->lawsPlaceRepository->findByID($id);
        $register->active = $register->active>0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }
}
