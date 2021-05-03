<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateProtocolTypeRequest;
use App\Http\Requests\UpdateProtocolTypeRequest;
use App\Repositories\ProtocolTypeRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class ProtocolTypeController extends AppBaseController
{
    /** @var  ProtocolTypeRepository */
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
        if(!Defender::hasPermission('protocolTypes.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->protocolTypeRepository->pushCriteria(new RequestCriteria($request));
        $protocolTypes = $this->protocolTypeRepository->all();

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
        if(!Defender::hasPermission('protocolTypes.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
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
       if(!Defender::hasPermission('protocolTypes.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();
        $input['slug'] = str_slug($input['name']);

        $protocolType = $this->protocolTypeRepository->create($input);

        Flash::success('Tipo de protocolo salvo com sucesso');

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
        if(!Defender::hasPermission('protocolTypes.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            Flash::error('ProtocolType not found');

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
        if(!Defender::hasPermission('protocolTypes.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            Flash::error('ProtocolType not found');

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
        if(!Defender::hasPermission('protocolTypes.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            Flash::error('ProtocolType not found');

            return redirect(route('protocolTypes.index'));
        }

        $request['slug'] = str_slug($request['name']);

        $protocolType = $this->protocolTypeRepository->update($request->all(), $id);

        Flash::success('Tipo de protocolo editado com sucesso.');

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
        if(!Defender::hasPermission('protocolTypes.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $protocolType = $this->protocolTypeRepository->findWithoutFail($id);

        if (empty($protocolType)) {
            Flash::error('ProtocolType not found');

            return redirect(route('protocolTypes.index'));
        }

        $this->protocolTypeRepository->delete($id);

        Flash::success('ProtocolType deleted successfully.');

        return redirect(route('protocolTypes.index'));
    }

    /**
    	 * Update status of specified ProtocolType from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('protocolTypes.edit'))
            {
                return json_encode(false);
            }
            $register = $this->protocolTypeRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
