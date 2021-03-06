<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProtocolTypeRequest;
use App\Http\Requests\UpdateProtocolTypeRequest;
use App\Repositories\ProtocolTypeRepository;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;

class ProtocolTypeController extends AppBaseController
{
    /** @var ProtocolTypeRepository */
    private $protocolTypeRepository;

    public function __construct(ProtocolTypeRepository $protocolTypeRepo)
    {
        $this->protocolTypeRepository = $protocolTypeRepo;
    }

    /**
     * Display a listing of the ProtocolType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('protocolTypes.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        // $this->protocolTypeRepository->pushCriteria(new RequestCriteria($request));
        $protocolTypes = $this->protocolTypeRepository->getAll(0);

        return view('protocolTypes.index')
            ->with('protocolTypes', $protocolTypes);
    }

    /**
     * Show the form for creating a new ProtocolType.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('protocolTypes.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('protocolTypes.create');
    }

    /**
     * Store a newly created ProtocolType in storage.
     *
     * @param CreateProtocolTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateProtocolTypeRequest $request)
    {
        if (! Defender::hasPermission('protocolTypes.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();
        $input['slug'] = str_slug($input['name']);

        $protocolType = $this->protocolTypeRepository->create($input);

        flash('Tipo de protocolo salvo com sucesso')->success();

        return redirect(route('protocolTypes.index'));
    }

    /**
     * Display the specified ProtocolType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('protocolTypes.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            flash('Tipo de protocolo não encontrado')->error();

            return redirect(route('protocolTypes.index'));
        }

        return view('protocolTypes.show')->with('protocolType', $protocolType);
    }

    /**
     * Show the form for editing the specified ProtocolType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('protocolTypes.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            flash('Tipo de protocolo não encontrado')->error();

            return redirect(route('protocolTypes.index'));
        }

        return view('protocolTypes.edit')->with('protocolType', $protocolType);
    }

    /**
     * Update the specified ProtocolType in storage.
     *
     * @param  int              $id
     * @param UpdateProtocolTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProtocolTypeRequest $request)
    {
        if (! Defender::hasPermission('protocolTypes.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            flash('Tipo de protocolo não encontrado')->error();

            return redirect(route('protocolTypes.index'));
        }

        $request['slug'] = str_slug($request['name']);

        $protocolType = $this->protocolTypeRepository->update($request->all(), $id);

        flash('Tipo de protocolo editado com sucesso.')->success();

        return redirect(route('protocolTypes.index'));
    }

    /**
     * Remove the specified ProtocolType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('protocolTypes.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            flash('Tipo de protocolo não encontrado')->error();

            return redirect(route('protocolTypes.index'));
        }

        $this->protocolTypeRepository->delete($id);

        flash('Tipo de protocolo removido com sucesso.')->success();

        return redirect(route('protocolTypes.index'));
    }

    /**
     * Update status of specified ProtocolType from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('protocolTypes.edit')) {
            return json_encode(false);
        }
        $register = $this->protocolTypeRepository->findWithoutFail($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
