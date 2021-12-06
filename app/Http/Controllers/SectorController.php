<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSectorRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Repositories\SectorRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SectorController extends AppBaseController
{
    /** @var SectorRepository */
    private $sectorRepository;

    public function __construct(SectorRepository $sectorRepo)
    {
        $this->sectorRepository = $sectorRepo;
    }

    /**
     * Display a listing of the Sector.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('sectors.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $sectors = $this->sectorRepository->getAll(0);

        return view('sectors.index')
            ->with('sectors', $sectors);
    }

    /**
     * Show the form for creating a new Sector.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('sectors.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('sectors.create');
    }

    /**
     * Store a newly created Sector in storage.
     *
     * @param CreateSectorRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateSectorRequest $request)
    {
        if (! Defender::hasPermission('sectors.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $sector = $this->sectorRepository->create($input);

        flash('Setor salvo com sucesso.')->success();

        return redirect(route('sectors.index'));
    }

    /**
     * Display the specified Sector.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
        if (! Defender::hasPermission('sectors.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $sector = $this->sectorRepository->findByID($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        return view('sectors.show')->with('sector', $sector);
    }

    /**
     * Show the form for editing the specified Sector.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        if (! Defender::hasPermission('sectors.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $sector = $this->sectorRepository->findByID($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        return view('sectors.edit')->with('sector', $sector);
    }

    /**
     * Update the specified Sector in storage.
     *
     * @param int $id
     * @param UpdateSectorRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateSectorRequest $request)
    {
        if (! Defender::hasPermission('sectors.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $sector = $this->sectorRepository->findByID($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $this->sectorRepository->update($sector, $input);

        flash('Setor atualizado com sucesso.')->success();

        return redirect(route('sectors.index'));
    }

    /**
     * Remove the specified Sector from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if (! Defender::hasPermission('sectors.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $sector = $this->sectorRepository->findByID($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        $this->sectorRepository->delete($sector);

        flash('Setor removido com sucesso.')->success();

        return redirect(route('sectors.index'));
    }

    /**
     * Update status of specified Sector from storage.
     *
     * @param int $id
     * @return false|string
     * @throws BindingResolutionException
     */
    public function toggle(int $id)
    {
        if (! Defender::hasPermission('sectors.edit')) {
            return json_encode(false);
        }
        $register = $this->sectorRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
