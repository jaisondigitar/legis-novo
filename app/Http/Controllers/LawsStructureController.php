<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateLawsStructureRequest;
use App\Http\Requests\UpdateLawsStructureRequest;
use App\Repositories\LawsStructureRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class LawsStructureController extends AppBaseController
{
    /** @var LawsStructureRepository */
    private $lawsStructureRepository;

    public function __construct(LawsStructureRepository $lawsStructureRepo)
    {
        $this->lawsStructureRepository = $lawsStructureRepo;
    }

    /**
     * Display a listing of the LawsStructure.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('lawsStructures.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $lawsStructures = $this->lawsStructureRepository->getAll(0);

        return view('lawsStructures.index')
            ->with('lawsStructures', $lawsStructures);
    }

    /**
     * Show the form for creating a new LawsStructure.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('lawsStructures.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('lawsStructures.create');
    }

    /**
     * Store a newly created LawsStructure in storage.
     *
     * @param CreateLawsStructureRequest $request
     *
     * @return Response
     */
    public function store(CreateLawsStructureRequest $request)
    {
        if (! Defender::hasPermission('lawsStructures.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $lawsStructure = $this->lawsStructureRepository->create($input);

        flash('Estrutura da lei salva com sucesso.')->success();

        return redirect(route('lawsStructures.index'));
    }

    /**
     * Display the specified LawsStructure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('lawsStructures.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $lawsStructure = $this->lawsStructureRepository->findById($id);

        if (empty($lawsStructure)) {
            flash('Estrutura da lei não encontrada')->error();

            return redirect(route('lawsStructures.index'));
        }

        return view('lawsStructures.show')->with('lawsStructure', $lawsStructure);
    }

    /**
     * Show the form for editing the specified LawsStructure.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('lawsStructures.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $lawsStructure = $this->lawsStructureRepository->findById($id);

        if (empty($lawsStructure)) {
            flash('Estrutura da lei não encontrada')->error();

            return redirect(route('lawsStructures.index'));
        }

        return view('lawsStructures.edit')->with('lawsStructure', $lawsStructure);
    }

    /**
     * Update the specified LawsStructure in storage.
     *
     * @param  int              $id
     * @param UpdateLawsStructureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLawsStructureRequest $request)
    {
        if (! Defender::hasPermission('lawsStructures.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $lawsStructure = $this->lawsStructureRepository->findById($id);

        if (empty($lawsStructure)) {
            flash('Estrutura da lei não encontrada')->error();

            return redirect(route('lawsStructures.index'));
        }

        $lawsStructure = $this->lawsStructureRepository->update($lawsStructure, $request->all());

        flash('Estrutura da lei atualizada com sucesso.')->success();

        return redirect(route('lawsStructures.index'));
    }

    /**
     * Remove the specified LawsStructure from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('lawsStructures.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $lawsStructure = $this->lawsStructureRepository->findById($id);

        if (empty($lawsStructure)) {
            flash('Estrutura da lei não encontrada')->error();

            return redirect(route('lawsStructures.index'));
        }

        $this->lawsStructureRepository->delete($lawsStructure);

        flash('Estrutura da lei removido com sucesso.')->success();

        return redirect(route('lawsStructures.index'));
    }

    /**
     * Update status of specified LawsStructure from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('lawsStructures.edit')) {
            return json_encode(false);
        }
        $register = $this->lawsStructureRepository->findById($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
