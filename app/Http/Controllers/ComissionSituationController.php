<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateComissionSituationRequest;
use App\Http\Requests\UpdateComissionSituationRequest;
use App\Repositories\ComissionSituationRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class ComissionSituationController extends AppBaseController
{
    /** @var  ComissionSituationRepository */
    private $comissionSituationRepository;

    public function __construct(ComissionSituationRepository $comissionSituationRepo)
    {
        $this->comissionSituationRepository = $comissionSituationRepo;
    }

    /**
     * Display a listing of the ComissionSituation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('comissionSituations.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->comissionSituationRepository->pushCriteria(new RequestCriteria($request));
        $comissionSituations = $this->comissionSituationRepository->all();

        return view('comissionSituations.index')
            ->with('comissionSituations', $comissionSituations);
    }

    /**
     * Show the form for creating a new ComissionSituation.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('comissionSituations.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('comissionSituations.create');
    }

    /**
     * Store a newly created ComissionSituation in storage.
     *
     * @param CreateComissionSituationRequest $request
     *
     * @return Response
     */
    public function store(CreateComissionSituationRequest $request)
    {
       if(!Defender::hasPermission('comissionSituations.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $comissionSituation = $this->comissionSituationRepository->create($input);

        flash('ComissionSituation saved successfully.')->success();

        return redirect(route('comissionSituations.index'));
    }

    /**
     * Display the specified ComissionSituation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('comissionSituations.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $comissionSituation = $this->comissionSituationRepository->findWithoutFail($id);

        if (empty($comissionSituation)) {
            flash('ComissionSituation not found')->error();

            return redirect(route('comissionSituations.index'));
        }

        return view('comissionSituations.show')->with('comissionSituation', $comissionSituation);
    }

    /**
     * Show the form for editing the specified ComissionSituation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('comissionSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $comissionSituation = $this->comissionSituationRepository->findWithoutFail($id);

        if (empty($comissionSituation)) {
            flash('ComissionSituation not found')->error();

            return redirect(route('comissionSituations.index'));
        }

        return view('comissionSituations.edit')->with('comissionSituation', $comissionSituation);
    }

    /**
     * Update the specified ComissionSituation in storage.
     *
     * @param  int              $id
     * @param UpdateComissionSituationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComissionSituationRequest $request)
    {
        if(!Defender::hasPermission('comissionSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $comissionSituation = $this->comissionSituationRepository->findWithoutFail($id);

        if (empty($comissionSituation)) {
            flash('ComissionSituation not found')->error();

            return redirect(route('comissionSituations.index'));
        }

        $comissionSituation = $this->comissionSituationRepository->update($request->all(), $id);

        flash('ComissionSituation updated successfully.')->success();

        return redirect(route('comissionSituations.index'));
    }

    /**
     * Remove the specified ComissionSituation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('comissionSituations.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $comissionSituation = $this->comissionSituationRepository->findWithoutFail($id);

        if (empty($comissionSituation)) {
            flash('ComissionSituation not found')->error();

            return redirect(route('comissionSituations.index'));
        }

        $this->comissionSituationRepository->delete($id);

        flash('ComissionSituation deleted successfully.')->success();

        return redirect(route('comissionSituations.index'));
    }

    /**
    	 * Update status of specified ComissionSituation from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('comissionSituations.edit'))
            {
                return json_encode(false);
            }
            $register = $this->comissionSituationRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
