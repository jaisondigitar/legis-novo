<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateLawsPlaceRequest;
use App\Http\Requests\UpdateLawsPlaceRequest;
use App\Repositories\LawsPlaceRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

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
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('lawsPlaces.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->lawsPlaceRepository->pushCriteria(new RequestCriteria($request));
        $lawsPlaces = $this->lawsPlaceRepository->all();

        return view('lawsPlaces.index')
            ->with('lawsPlaces', $lawsPlaces);
    }

    /**
     * Show the form for creating a new LawsPlace.
     *
     * @return Response
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
     * @return Response
     */
    public function store(CreateLawsPlaceRequest $request)
    {
       if(!Defender::hasPermission('lawsPlaces.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $lawsPlace = $this->lawsPlaceRepository->create($input);

        flash('Lugar da Lei salvo com sucesso.')->success();

        return redirect(route('lawsPlaces.index'));
    }

    /**
     * Display the specified LawsPlace.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('lawsPlaces.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsPlace = $this->lawsPlaceRepository->findWithoutFail($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        return view('lawsPlaces.show')->with('lawsPlace', $lawsPlace);
    }

    /**
     * Show the form for editing the specified LawsPlace.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('lawsPlaces.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $lawsPlace = $this->lawsPlaceRepository->findWithoutFail($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        return view('lawsPlaces.edit')->with('lawsPlace', $lawsPlace);
    }

    /**
     * Update the specified LawsPlace in storage.
     *
     * @param  int              $id
     * @param UpdateLawsPlaceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLawsPlaceRequest $request)
    {
        if(!Defender::hasPermission('lawsPlaces.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsPlace = $this->lawsPlaceRepository->findWithoutFail($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        $lawsPlace = $this->lawsPlaceRepository->update($request->all(), $id);

        flash('Lugar da Lei atualizado com sucesso.')->success();

        return redirect(route('lawsPlaces.index'));
    }

    /**
     * Remove the specified LawsPlace from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('lawsPlaces.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsPlace = $this->lawsPlaceRepository->findWithoutFail($id);

        if (empty($lawsPlace)) {
            flash('Lugar da Lei não encontrado')->error();

            return redirect(route('lawsPlaces.index'));
        }

        $this->lawsPlaceRepository->delete($id);

        flash('Lugar da Lei removido com sucesso.')->success();

        return redirect(route('lawsPlaces.index'));
    }

    /**
    	 * Update status of specified LawsPlace from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('lawsPlaces.edit'))
            {
                return json_encode(false);
            }
            $register = $this->lawsPlaceRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
