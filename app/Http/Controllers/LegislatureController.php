<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLegislatureRequest;
use App\Http\Requests\UpdateLegislatureRequest;
use App\Models\Assemblyman;
use App\Models\LegislatureAssemblyman;
use App\Repositories\LegislatureRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class LegislatureController extends AppBaseController
{
    /** @var LegislatureRepository */
    private $legislatureRepository;

    public function __construct(LegislatureRepository $legislatureRepo)
    {
        $this->legislatureRepository = $legislatureRepo;
    }

    /**
     * Display a listing of the Legislature.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('legislatures.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $legislatures = $this->legislatureRepository->getAll(0);

        $assemblymen = Assemblyman::all()->load('legislature_assemblyman');

        return view('legislatures.index')
            ->with('assemblymen', $assemblymen)
            ->with('legislatures', $legislatures);
    }

    /**
     * Show the form for creating a new Legislature.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('legislatures.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('legislatures.create');
    }

    /**
     * Store a newly created Legislature in storage.
     *
     * @param CreateLegislatureRequest $request
     *
     * @return Response
     */
    public function store(CreateLegislatureRequest $request)
    {
        if (! Defender::hasPermission('legislatures.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $legislature = $this->legislatureRepository->create($input);

        flash('Legislatura salva com sucesso.')->success();

        return redirect(route('legislatures.index'));
    }

    /**
     * Display the specified Legislature.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('legislatures.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $legislature = $this->legislatureRepository->findByID($id);

        if (empty($legislature)) {
            flash('Legislatura não encontrada')->error();

            return redirect(route('legislatures.index'));
        }

        $legislature_assemblyman = LegislatureAssemblyman::where('legislature_id', $legislature->id)->get();

        $legislature_assemblyman_select = LegislatureAssemblyman::where('legislature_id', $legislature->id)
            ->select('assemblyman_id')
            ->get();

        $assemblyman = Assemblyman::whereNotIn('id', $legislature_assemblyman_select)->get();

        return view('legislatures.show')
            ->with('legislature', $legislature)
            ->with('assemblyman', $assemblyman)
            ->with('legislature_assemblyman', $legislature_assemblyman);
    }

    /**
     * Show the form for editing the specified Legislature.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('legislatures.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $legislature = $this->legislatureRepository->findByID($id);

        if (empty($legislature)) {
            flash('Legislatura não encontrada')->error();

            return redirect(route('legislatures.index'));
        }

        return view('legislatures.edit')->with('legislature', $legislature);
    }

    /**
     * Update the specified Legislature in storage.
     *
     * @param int $id
     * @param UpdateLegislatureRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateLegislatureRequest $request)
    {
        if (! Defender::hasPermission('legislatures.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $legislature = $this->legislatureRepository->findByID($id);

        if (empty($legislature)) {
            flash('Legislatura não encontrada')->error();

            return redirect(route('legislatures.index'));
        }

        $this->legislatureRepository->update($legislature, $request->all());

        flash('Legislature updated successfully.')->success();

        return redirect(route('legislatures.index'));
    }

    /**
     * Remove the specified Legislature from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('legislatures.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $legislature = $this->legislatureRepository->findByID($id);

        if (empty($legislature)) {
            flash('Legislatura não encontrada')->error();

            return redirect(route('legislatures.index'));
        }

        $this->legislatureRepository->delete($legislature);

        flash('Legislatura removido com sucesso.')->success();

        return redirect(route('legislatures.index'));
    }

    /**
     * Update status of specified Legislature from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('legislatures.edit')) {
            return json_encode(false);
        }
        $register = $this->legislatureRepository->findWithoutFail($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function saveAssemblyman($id)
    {
        $params = Input::all();

        foreach ($params['assemblyman_id'] as $assemblyman) {
            $legislature_assemblyman = new LegislatureAssemblyman();
            $legislature_assemblyman->legislature_id = $id;
            $legislature_assemblyman->assemblyman_id = $assemblyman;
            $legislature_assemblyman->save();
        }
        flash('Parlamentares inserido com sucesso.')->success();

        return redirect(route('legislatures.show', $id));
    }

    public function deleteAssemblyman($legislature_id, $assemblyman_id)
    {
        $legislature_assemblyman = LegislatureAssemblyman::where('legislature_id', $legislature_id)
            ->where('assemblyman_id', $assemblyman_id)
            ->first();

        if ($legislature_assemblyman->delete()) {
            flash('Parlamentar deletado com sucesso.')->success();

            return redirect(route('legislatures.show', $legislature_id));
        }
    }
}
