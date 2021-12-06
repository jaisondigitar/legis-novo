<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Repositories\TypeRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TypeController extends AppBaseController
{
    /** @var TypeRepository */
    private $typeRepository;

    public function __construct(TypeRepository $typeRepo)
    {
        $this->typeRepository = $typeRepo;
    }

    /**
     * Display a listing of the Type.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('types.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $this->typeRepository->pushCriteria(new RequestCriteria($request));
        $types = $this->typeRepository->all();

        return view('types.index')
            ->with('types', $types);
    }

    /**
     * Show the form for creating a new Type.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('types.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('types.create');
    }

    /**
     * Store a newly created Type in storage.
     *
     * @param CreateTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateTypeRequest $request)
    {
        if (! Defender::hasPermission('types.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $type = $this->typeRepository->create($input);

        flash('Tipo salvo com sucesso.')->success();

        return redirect(route('types.index'));
    }

    /**
     * Display the specified Type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('types.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            flash('Tipo não encontrado')->error();

            return redirect(route('types.index'));
        }

        return view('types.show')->with('type', $type);
    }

    /**
     * Show the form for editing the specified Type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('types.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            flash('Tipo não encontrado')->error();

            return redirect(route('types.index'));
        }

        return view('types.edit')->with('type', $type);
    }

    /**
     * Update the specified Type in storage.
     *
     * @param  int              $id
     * @param UpdateTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTypeRequest $request)
    {
        if (! Defender::hasPermission('types.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            flash('Tipo não encontrado')->error();

            return redirect(route('types.index'));
        }

        $type = $this->typeRepository->update($request->all(), $id);

        flash('Tipo atualizado com sucesso.')->success();

        return redirect(route('types.index'));
    }

    /**
     * Remove the specified Type from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('types.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            flash('Tipo não encontrado')->error();

            return redirect(route('types.index'));
        }

        $this->typeRepository->delete($id);

        flash('Tipo removido com sucesso.')->success();

        return redirect(route('types.index'));
    }

    /**
     * Update status of specified Type from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('types.edit')) {
            return json_encode(false);
        }
        $register = $this->typeRepository->findWithoutFail($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
