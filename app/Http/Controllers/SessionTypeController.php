<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSessionTypeRequest;
use App\Http\Requests\UpdateSessionTypeRequest;
use App\Repositories\SessionTypeRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
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
     * @return Application|Factory|Redirector|RedirectResponse|View
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
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateSessionTypeRequest $request)
    {
       if(!Defender::hasPermission('sessionTypes.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $input['slug'] = Str::slug($input['name']);

        $this->sessionTypeRepository->create($input);

        flash('Tipo de sessão salva com sucesso.')->success();

        return redirect(route('sessionTypes.index'));
    }

    /**
     * Display the specified SessionType.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
        if(!Defender::hasPermission('sessionTypes.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sessionType = $this->sessionTypeRepository->findById($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        return view('sessionTypes.show')->with('sessionType', $sessionType);
    }

    /**
     * Show the form for editing the specified SessionType.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        if(!Defender::hasPermission('sessionTypes.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $sessionType = $this->sessionTypeRepository->findById($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        return view('sessionTypes.edit')->with('sessionType', $sessionType);
    }

    /**
     * Update the specified SessionType in storage.
     *
     * @param int $id
     * @param UpdateSessionTypeRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateSessionTypeRequest $request)
    {
        if(!Defender::hasPermission('sessionTypes.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sessionType = $this->sessionTypeRepository->findById($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        $request['slug'] = Str::slug($request['name']);

        $this->sessionTypeRepository->update($sessionType, $request->all());

        flash('Tipo de sessão atualizado com sucesso.')->success();

        return redirect(route('sessionTypes.index'));
    }

    /**
     * Remove the specified SessionType from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if(!Defender::hasPermission('sessionTypes.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sessionType = $this->sessionTypeRepository->findById($id);

        if (empty($sessionType)) {
            flash('Tipo de sessão não encontrada')->error();

            return redirect(route('sessionTypes.index'));
        }

        $this->sessionTypeRepository->delete($sessionType);

        flash('Tipo de sessão removida com sucesso.')->success();

        return redirect(route('sessionTypes.index'));
    }

    /**
     * Update status of specified SessionType from storage.
     *
     * @param int $id
     * @return false|string
     * @throws BindingResolutionException
     */
    public function toggle(int $id){
        if(!Defender::hasPermission('sessionTypes.edit'))
        {
            return json_encode(false);
        }
        $register = $this->sessionTypeRepository->findById($id);
        $register->active = $register->active>0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }
}
