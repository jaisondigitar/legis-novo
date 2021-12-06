<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateSessionPlaceRequest;
use App\Http\Requests\UpdateSessionPlaceRequest;
use App\Repositories\SessionPlaceRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SessionPlaceController extends AppBaseController
{
    /** @var SessionPlaceRepository */
    private $sessionPlaceRepository;

    public function __construct(SessionPlaceRepository $sessionPlaceRepo)
    {
        $this->sessionPlaceRepository = $sessionPlaceRepo;
    }

    /**
     * Display a listing of the SessionPlace.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('sessionPlaces.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $this->sessionPlaceRepository->pushCriteria(new RequestCriteria($request));
        $sessionPlaces = $this->sessionPlaceRepository->all();

        return view('sessionPlaces.index')
            ->with('sessionPlaces', $sessionPlaces);
    }

    /**
     * Show the form for creating a new SessionPlace.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('sessionPlaces.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('sessionPlaces.create');
    }

    /**
     * Store a newly created Local da sessão in storage.
     *
     * @param CreateSessionPlaceRequest $request
     *
     * @return Response
     */
    public function store(CreateSessionPlaceRequest $request)
    {
        if (! Defender::hasPermission('sessionPlaces.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $input['slug'] = str_slug($input['name']);

        $sessionPlace = $this->sessionPlaceRepository->create($input);

        flash('Local da sessão salvo com sucesso.')->success();

        return redirect(route('sessionPlaces.index'));
    }

    /**
     * Display the specified SessionPlace.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('sessionPlaces.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $sessionPlace = $this->sessionPlaceRepository->findWithoutFail($id);

        if (empty($sessionPlace)) {
            flash('Local da sessão não encontrado')->error();

            return redirect(route('sessionPlaces.index'));
        }

        return view('sessionPlaces.show')->with('sessionPlace', $sessionPlace);
    }

    /**
     * Show the form for editing the specified SessionPlace.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('sessionPlaces.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $sessionPlace = $this->sessionPlaceRepository->findWithoutFail($id);

        if (empty($sessionPlace)) {
            flash('Local da sessão não encontrado')->error();

            return redirect(route('sessionPlaces.index'));
        }

        return view('sessionPlaces.edit')->with('sessionPlace', $sessionPlace);
    }

    /**
     * Update the specified Local da sessão in storage.
     *
     * @param  int              $id
     * @param UpdateSessionPlaceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSessionPlaceRequest $request)
    {
        if (! Defender::hasPermission('sessionPlaces.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $sessionPlace = $this->sessionPlaceRepository->findWithoutFail($id);

        if (empty($sessionPlace)) {
            flash('Local da sessão não encontrado')->error();

            return redirect(route('sessionPlaces.index'));
        }

        $request['slug'] = str_slug($request['name']);

        $sessionPlace = $this->sessionPlaceRepository->update($request->all(), $id);

        flash('Local da sessão atualizado com sucesso.')->success();

        return redirect(route('sessionPlaces.index'));
    }

    /**
     * Remove the specified Local da sessão from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('sessionPlaces.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $sessionPlace = $this->sessionPlaceRepository->findWithoutFail($id);

        if (empty($sessionPlace)) {
            flash('Local da sessão não encontrado')->error();

            return redirect(route('sessionPlaces.index'));
        }

        $this->sessionPlaceRepository->delete($id);

        flash('Local da sessão removido com sucesso.')->success();

        return redirect(route('sessionPlaces.index'));
    }

    /**
     * Update status of specified Local da sessão from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('sessionPlaces.edit')) {
            return json_encode(false);
        }
        $register = $this->sessionPlaceRepository->findWithoutFail($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
