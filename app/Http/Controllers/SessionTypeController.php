<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateSessionTypeRequest;
use App\Http\Requests\UpdateSessionTypeRequest;
use App\Repositories\SessionTypeRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class SessionTypeController extends AppBaseController
{
    /** @var  SessionTypeRepository */
    private $sessionTypeRepository;

    public function __construct(SessionTypeRepository $sessionTypeRepo)
    {
        $this->sessionTypeRepository = $sessionTypeRepo;
    }

    /**
     * Display a listing of the SessionType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('sessionTypes.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sessionTypes = $this->sessionTypeRepository->getAll(0);

        return view('sessionTypes.index')
            ->with('sessionTypes', $sessionTypes);
    }

    /**
     * Show the form for creating a new SessionType.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('sessionTypes.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('sessionTypes.create');
    }

    /**
     * Store a newly created SessionType in storage.
     *
     * @param CreateSessionTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateSessionTypeRequest $request)
    {
       if(!Defender::hasPermission('sessionTypes.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $input['slug'] = str_slug($input['name']);

        $sessionType = $this->sessionTypeRepository->create($input);

        flash('Tipo de sessão salva com sucesso.')->success();

        return redirect(route('sessionTypes.index'));
    }

    /**
     * Display the specified SessionType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('sessionTypes.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sessionType = $this->sessionTypeRepository->findWithoutFail($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        return view('sessionTypes.show')->with('sessionType', $sessionType);
    }

    /**
     * Show the form for editing the specified SessionType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('sessionTypes.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $sessionType = $this->sessionTypeRepository->findWithoutFail($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        return view('sessionTypes.edit')->with('sessionType', $sessionType);
    }

    /**
     * Update the specified SessionType in storage.
     *
     * @param  int              $id
     * @param UpdateSessionTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSessionTypeRequest $request)
    {
        if(!Defender::hasPermission('sessionTypes.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sessionType = $this->sessionTypeRepository->findWithoutFail($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        $request['slug'] = str_slug($request['name']);

        $sessionType = $this->sessionTypeRepository->update($request->all(), $id);

        flash('Tipo de sessão atualizado com sucesso.')->success();

        return redirect(route('sessionTypes.index'));
    }

    /**
     * Remove the specified SessionType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('sessionTypes.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sessionType = $this->sessionTypeRepository->findWithoutFail($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        $this->sessionTypeRepository->delete($id);

        flash('Tipo de sessão removida com sucesso.')->success();

        return redirect(route('sessionTypes.index'));
    }

    /**
    	 * Update status of specified SessionType from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('sessionTypes.edit'))
            {
                return json_encode(false);
            }
            $register = $this->sessionTypeRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
