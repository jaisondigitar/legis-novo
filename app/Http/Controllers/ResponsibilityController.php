<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateResponsibilityRequest;
use App\Http\Requests\UpdateResponsibilityRequest;
use App\Repositories\ResponsibilityRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ResponsibilityController extends AppBaseController
{
    /** @var ResponsibilityRepository */
    private $responsibilityRepository;

    public function __construct(ResponsibilityRepository $responsibilityRepo)
    {
        $this->responsibilityRepository = $responsibilityRepo;
    }

    /**
     * Display a listing of the Responsibility.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('responsibilities.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $responsibilities = $this->responsibilityRepository->getAll(0);

        return view('responsibilities.index')
            ->with('responsibilities', $responsibilities);
    }

    /**
     * Show the form for creating a new Responsibility.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('responsibilities.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('responsibilities.create');
    }

    /**
     * Store a newly created Responsibility in storage.
     *
     * @param CreateResponsibilityRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateResponsibilityRequest $request)
    {
        if (! Defender::hasPermission('responsibilities.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $this->responsibilityRepository->create($input);

        flash('Responsabilidade salva com sucesso.')->success();

        return redirect(route('responsibilities.index'));
    }

    /**
     * Display the specified Responsibility.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('responsibilities.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $responsibility = $this->responsibilityRepository->findByID($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        return view('responsibilities.show')->with('responsibility', $responsibility);
    }

    /**
     * Show the form for editing the specified Responsibility.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('responsibilities.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $responsibility = $this->responsibilityRepository->findByID($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        return view('responsibilities.edit')->with('responsibility', $responsibility);
    }

    /**
     * Update the specified Responsibility in storage.
     *
     * @param  int              $id
     * @param UpdateResponsibilityRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function update($id, UpdateResponsibilityRequest $request)
    {
        if (! Defender::hasPermission('responsibilities.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $responsibility = $this->responsibilityRepository->findByID($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        $input = $request->all();
        $input['skip_board'] = $input['skip_board'] === 'true' ? 1 : 0;
        $this->responsibilityRepository->update($responsibility, $input);

        if ($request->ajax()) {
            return json_encode(['success' => true]);
        }

        flash('Responsabilidade atualizada com sucesso.')->success();

        return redirect(route('responsibilities.index'));
    }

    /**
     * Remove the specified Responsibility from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id, Request $request)
    {
        if (! Defender::hasPermission('responsibilities.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $responsibility = $this->responsibilityRepository->findByID($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        $this->responsibilityRepository->delete($responsibility);

        if ($request->ajax()) {
            return 'success';
        }

        flash('Responsabilidade removida com sucesso.')->success();

        return redirect(route('responsibilities.index'));
    }

    /**
     * Update status of specified Responsibility from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('responsibilities.edit')) {
            return json_encode(false);
        }
        $register = $this->responsibilityRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
