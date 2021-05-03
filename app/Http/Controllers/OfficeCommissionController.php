<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateOfficeCommissionRequest;
use App\Http\Requests\UpdateOfficeCommissionRequest;
use App\Repositories\OfficeCommissionRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class OfficeCommissionController extends AppBaseController
{
    /** @var  OfficeCommissionRepository */
    private $officeCommissionRepository;

    public function __construct(OfficeCommissionRepository $officeCommissionRepo)
    {
        $this->officeCommissionRepository = $officeCommissionRepo;
    }

    /**
     * Display a listing of the OfficeCommission.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('officeCommissions.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->officeCommissionRepository->pushCriteria(new RequestCriteria($request));
        $officeCommissions = $this->officeCommissionRepository->all();

        return view('officeCommissions.index')
            ->with('officeCommissions', $officeCommissions);
    }

    /**
     * Show the form for creating a new OfficeCommission.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('officeCommissions.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('officeCommissions.create');
    }

    /**
     * Store a newly created OfficeCommission in storage.
     *
     * @param CreateOfficeCommissionRequest $request
     *
     * @return Response
     */
    public function store(CreateOfficeCommissionRequest $request)
    {
       if(!Defender::hasPermission('officeCommissions.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $input['slug'] = str_slug($input['name']);

        $officeCommission = $this->officeCommissionRepository->create($input);

        Flash::success('Cargo de comissão salvo com sucesso.');

        return redirect(route('officeCommissions.index'));
    }

    /**
     * Display the specified OfficeCommission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('officeCommissions.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $officeCommission = $this->officeCommissionRepository->findWithoutFail($id);

        if (empty($officeCommission)) {
            Flash::error('OfficeCommission not found');

            return redirect(route('officeCommissions.index'));
        }

        return view('officeCommissions.show')->with('officeCommission', $officeCommission);
    }

    /**
     * Show the form for editing the specified OfficeCommission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('officeCommissions.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $officeCommission = $this->officeCommissionRepository->findWithoutFail($id);

        if (empty($officeCommission)) {
            Flash::error('OfficeCommission not found');

            return redirect(route('officeCommissions.index'));
        }

        return view('officeCommissions.edit')->with('officeCommission', $officeCommission);
    }

    /**
     * Update the specified OfficeCommission in storage.
     *
     * @param  int              $id
     * @param UpdateOfficeCommissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOfficeCommissionRequest $request)
    {
        if(!Defender::hasPermission('officeCommissions.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $officeCommission = $this->officeCommissionRepository->findWithoutFail($id);

        if (empty($officeCommission)) {
            Flash::error('OfficeCommission not found');

            return redirect(route('officeCommissions.index'));
        }

        $request['slug'] = str_slug($request['name']);

        $officeCommission = $this->officeCommissionRepository->update($request->all(), $id);

        Flash::success('Cargo de comissão editado com sucesso.');

        return redirect(route('officeCommissions.index'));
    }

    /**
     * Remove the specified OfficeCommission from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('officeCommissions.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $officeCommission = $this->officeCommissionRepository->findWithoutFail($id);

        if (empty($officeCommission)) {
            Flash::error('OfficeCommission not found');

            return redirect(route('officeCommissions.index'));
        }

        $this->officeCommissionRepository->delete($id);

        Flash::success('Cargo de comissão excluído com sucesso');

        return redirect(route('officeCommissions.index'));
    }

    /**
    	 * Update status of specified OfficeCommission from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
//    	public function toggle($id){
//            if(!Defender::hasPermission('officeCommissions.edit'))
//            {
//                return json_encode(false);
//            }
//            $register = $this->officeCommissionRepository->findWithoutFail($id);
//            $register->active = $register->active>0 ? 0 : 1;
//            $register->save();
//            return json_encode(true);
//        }
}
