<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommissionRequest;
use App\Http\Requests\UpdateCommissionRequest;
use App\Models\Assemblyman;
use App\Models\CommissionAssemblyman;
use App\Models\OfficeCommission;
use App\Repositories\CommissionRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CommissionController extends AppBaseController
{
    /** @var CommissionRepository */
    private $commissionRepository;

    public function __construct(CommissionRepository $commissionRepo)
    {
        $this->commissionRepository = $commissionRepo;
    }

    /**
     * Display a listing of the Commission.
     *
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index()
    {
        if (! Defender::hasPermission('commissions.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $commissions = $this->commissionRepository->getAll(0);

        return view('commissions.index')
            ->with('commissions', $commissions);
    }

    /**
     * Show the form for creating a new Commission.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('commissions.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $assemblymen = Assemblyman::pluck('full_name', 'id')->prepend('Selecione', '');

        $office_commission = OfficeCommission::pluck('name', 'id')->prepend('Selecione', '');

        return view('commissions.create')->with('assemblymen', $assemblymen)->with('office_commission', $office_commission);
    }

    /**
     * Store a newly created Commission in storage.
     *
     * @param CreateCommissionRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateCommissionRequest $request)
    {
        if (! Defender::hasPermission('commissions.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $commission = $this->commissionRepository->create($input);

        if ($request->assemblyman_comission) {
            foreach ($request->assemblyman_comission as $item) {
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
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
        if (! Defender::hasPermission('commissions.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $commission = $this->commissionRepository->findByID($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        return view('commissions.show')->with('commission', $commission);
    }

    /**
     * Show the form for editing the specified Commission.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        if (! Defender::hasPermission('commissions.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $commission = $this->commissionRepository->findByID($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        $assemblymen = Assemblyman::pluck('full_name', 'id')->prepend('Selecione', '');
        $office_commission = OfficeCommission::pluck('name', 'id')->prepend('Selecione', '');

        return view('commissions.edit')
            ->with('commission', $commission)
            ->with('assemblymen', $assemblymen)
            ->with('office_commission', $office_commission);
    }

    /**
     * Update the specified Commission in storage.
     *
     * @param int $id
     * @param UpdateCommissionRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateCommissionRequest $request)
    {
        if (! Defender::hasPermission('commissions.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $commission = $this->commissionRepository->findByID($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        $commission = $this->commissionRepository->update($commission, $request->all());

        CommissionAssemblyman::where('commission_id', $commission->id)->delete();

        if ($request->assemblyman_comission) {
            foreach ($request->assemblyman_comission as $item) {
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
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if (! Defender::hasPermission('commissions.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $commission = $this->commissionRepository->findByID($id);

        if (empty($commission)) {
            flash('Comissão não encontrada.')->error();

            return redirect(route('commissions.index'));
        }

        CommissionAssemblyman::where('commission_id', $commission->id)->delete();

        $this->commissionRepository->delete($commission);

        flash('Comissão excluída com sucesso')->success();

        return redirect(route('commissions.index'));
    }

    public function commissionAssemblymen($id)
    {
        return CommissionAssemblyman::where('commission_id', $id)->get()->load('assemblyman')->load('office_commission');
    }
}
