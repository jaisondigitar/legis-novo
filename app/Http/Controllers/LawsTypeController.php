<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateLawsTypeRequest;
use App\Http\Requests\UpdateLawsTypeRequest;
use App\Repositories\LawsTypeRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class LawsTypeController extends AppBaseController
{
    /** @var LawsTypeRepository */
    private $lawsTypeRepository;

    public function __construct(LawsTypeRepository $lawsTypeRepo)
    {
        $this->lawsTypeRepository = $lawsTypeRepo;
    }

    /**
     * Display a listing of the LawsType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('lawsTypes.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        // $this->lawsTypeRepository->pushCriteria(new RequestCriteria($request));
        $lawsTypes = $this->lawsTypeRepository->getAll(0);

        return view('lawsTypes.index')
            ->with('lawsTypes', $lawsTypes);
    }

    /**
     * Show the form for creating a new LawsType.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('lawsTypes.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('lawsTypes.create');
    }

    /**
     * Store a newly created LawsType in storage.
     *
     * @param CreateLawsTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateLawsTypeRequest $request)
    {
        if (! Defender::hasPermission('lawsTypes.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $lawsType = $this->lawsTypeRepository->create($input);

        flash('Tipo de lei salvo com sucesso.')->success();

        return redirect(route('lawsTypes.index'));
    }

    /**
     * Display the specified LawsType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('lawsTypes.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $lawsType = $this->lawsTypeRepository->findById($id);

        if (empty($lawsType)) {
            flash('Tipo de lei não encontrada')->error();

            return redirect(route('lawsTypes.index'));
        }

        return view('lawsTypes.show')->with('lawsType', $lawsType);
    }

    /**
     * Show the form for editing the specified LawsType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('lawsTypes.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $lawsType = $this->lawsTypeRepository->findById($id);

        if (empty($lawsType)) {
            flash('Tipo de lei não encontrada')->error();

            return redirect(route('lawsTypes.index'));
        }

        return view('lawsTypes.edit')->with('lawsType', $lawsType);
    }

    /**
     * Update the specified LawsType in storage.
     *
     * @param  int              $id
     * @param UpdateLawsTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLawsTypeRequest $request)
    {
        if (! Defender::hasPermission('lawsTypes.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $lawsType = $this->lawsTypeRepository->findById($id);

        if (empty($lawsType)) {
            flash('Tipo de lei não encontrada')->error();

            return redirect(route('lawsTypes.index'));
        }

        $lawsType = $this->lawsTypeRepository->update($lawsType, $request->all());

        flash('Tipo de lei atualizado com sucesso.')->success();

        return redirect(route('lawsTypes.index'));
    }

    /**
     * Remove the specified LawsType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('lawsTypes.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $lawsType = $this->lawsTypeRepository->findById($id);

        if (empty($lawsType)) {
            flash('Tipo de lei não encontrada')->error();

            return redirect(route('lawsTypes.index'));
        }

        $this->lawsTypeRepository->delete($lawsType);

        flash('Tipo de lei removido com sucesso.')->success();

        return redirect(route('lawsTypes.index'));
    }

    /**
     * Update status of specified LawsType from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('lawsTypes.edit')) {
            return json_encode(false);
        }
        $register = $this->lawsTypeRepository->findById($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function toggleActive($id)
    {
        $register = $this->lawsTypeRepository->findById($id);
        $register->is_active = $register->is_active == 0 ? 1 : 0;
        $register->save();

        return json_encode(true);
    }
}
