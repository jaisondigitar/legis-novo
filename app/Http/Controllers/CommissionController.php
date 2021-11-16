<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateCommissionRequest;
use App\Http\Requests\UpdateCommissionRequest;
use App\Models\Assemblyman;
use App\Models\CommissionAssemblyman;
use App\Models\OfficeCommission;
use App\Repositories\CommissionRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class CommissionController extends AppBaseController
{
    /** @var  CommissionRepository */
    private $commissionRepository;

    public function __construct(CommissionRepository $commissionRepo)
    {
        $this->commissionRepository = $commissionRepo;
    }

    /**
     * Display a listing of the Commission.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('commissions.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $commissions = $this->commissionRepository->getAll(0);

        return view('commissions.index')
            ->with('commissions', $commissions);
    }

    /**
     * Show the form for creating a new Commission.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('commissions.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $assemblymen = Assemblyman::lists('full_name', 'id')->prepend('Selecione', '');

        $office_commission = OfficeCommission::lists('name', 'id')->prepend('Selecione', '');

        return view('commissions.create')->with('assemblymen', $assemblymen)->with('office_commission', $office_commission);
    }

    /**
     * Store a newly created Commission in storage.
     *
     * @param CreateCommissionRequest $request
     *
     * @return Response
     */
    public function store(CreateCommissionRequest $request)
    {

        if(!Defender::hasPermission('commissions.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $commission = $this->commissionRepository->create($input);

        if($request->assemblyman_comission){
            foreach ($request->assemblyman_comission as $item){
                $commission_assemblyman = new CommissionAssemblyman();
                $commission_assemblyman->commission_id = $commission->id;
                $commission_assemblyman->assemblyman_id = $item['assemblyman_id'];
                $commission_assemblyman->office = $item['office_id'];
                $commission_assemblyman->start_date = $item['start_date'];
                $commission_assemblyman->end_date = $item['end_date'];
                $commission_assemblyman->save();
            }
        }

        flash('Comissão salva com sucesso.')->success();

        return redirect(route('commissions.index'));
    }

    /**
     * Display the specified Commission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('commissions.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $commission = $this->commissionRepository->findWithoutFail($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        return view('commissions.show')->with('commission', $commission);
    }

    /**
     * Show the form for editing the specified Commission.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('commissions.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $commission = $this->commissionRepository->findWithoutFail($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        $assemblymen = Assemblyman::lists('full_name', 'id')->prepend('Selecione', '');
        $office_commission = OfficeCommission::lists('name', 'id')->prepend('Selecione', '');

        return view('commissions.edit')
            ->with('commission', $commission)
            ->with('assemblymen', $assemblymen)
            ->with('office_commission', $office_commission);
    }

    /**
     * Update the specified Commission in storage.
     *
     * @param  int              $id
     * @param UpdateCommissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCommissionRequest $request)
    {
        if(!Defender::hasPermission('commissions.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $commission = $this->commissionRepository->findWithoutFail($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        $commission = $this->commissionRepository->update($request->all(), $id);

        $delete_all_assemblyman = CommissionAssemblyman::where('commission_id', $commission->id)->delete();

        if($request->assemblyman_comission){
            foreach ($request->assemblyman_comission as $item){
                $commission_assemblyman = new CommissionAssemblyman();
                $commission_assemblyman->commission_id = $commission->id;
                $commission_assemblyman->assemblyman_id = $item['assemblyman_id'];
                $commission_assemblyman->office = $item['office_id'];
                $commission_assemblyman->start_date = $item['start_date'];
                $commission_assemblyman->end_date = $item['end_date'];
                $commission_assemblyman->save();
            }
        }

        flash('Comissão editada com sucesso.')->success();

        return redirect(route('commissions.index'));
    }

    /**
     * Remove the specified Commission from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('commissions.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $commission = $this->commissionRepository->findWithoutFail($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        $commission_assemblyman = CommissionAssemblyman::where('commission_id', $commission->id)->delete();

        $this->commissionRepository->delete($id);

        flash('Comissão excluída com sucesso')->success();

        return redirect(route('commissions.index'));
    }

    public function commissionAssemblymen($id) {

        return CommissionAssemblyman::where('commission_id', $id)->get()->load('assemblyman')->load('office_commission');
    }
}
