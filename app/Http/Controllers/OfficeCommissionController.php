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
use Illuminate\Support\Str;

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $officeCommissions = $this->officeCommissionRepository->getAll(0);

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
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
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $input['slug'] = Str::slug($input['name']);

        $officeCommission = $this->officeCommissionRepository->create($input);

        flash('Cargo de comissão salvo com sucesso.')->success();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $officeCommission = $this->officeCommissionRepository->findById($id);

        if (empty($officeCommission)) {
            flash('OfficeCommission not found')->error();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $officeCommission = $this->officeCommissionRepository->findById($id);

        if (empty($officeCommission)) {
            flash('OfficeCommission not found')->error();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $officeCommission = $this->officeCommissionRepository->findById($id);

        if (empty($officeCommission)) {
            flash('OfficeCommission not found')->error();

            return redirect(route('officeCommissions.index'));
        }

        $request['slug'] = Str::slug($request['name']);

        $officeCommission = $this->officeCommissionRepository->update($officeCommission, $request->all());

        flash('Cargo de comissão editado com sucesso.')->success();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $officeCommission = $this->officeCommissionRepository->findById($id);

        if (empty($officeCommission)) {
            flash('OfficeCommission not found')->error();

            return redirect(route('officeCommissions.index'));
        }

        $this->officeCommissionRepository->delete($officeCommission);

        flash('Cargo de comissão excluído com sucesso')->success();

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
//            $register = $this->officeCommissionRepository->findById($id);
//            $register->active = $register->active>0 ? 0 : 1;
//            $register->save();
//            return json_encode(true);
//        }
}
