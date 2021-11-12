<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateLawSituationRequest;
use App\Http\Requests\UpdateLawSituationRequest;
use App\Repositories\LawSituationRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class LawSituationController extends AppBaseController
{
    /** @var  LawSituationRepository */
    private $lawSituationRepository;

    public function __construct(LawSituationRepository $lawSituationRepo)
    {
        $this->lawSituationRepository = $lawSituationRepo;
    }

    /**
     * Display a listing of the LawSituation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('lawSituations.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->lawSituationRepository->pushCriteria(new RequestCriteria($request));
        $lawSituations = $this->lawSituationRepository->all();

        return view('lawSituations.index')
            ->with('lawSituations', $lawSituations);
    }

    /**
     * Show the form for creating a new LawSituation.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('lawSituations.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('lawSituations.create');
    }

    /**
     * Store a newly created LawSituation in storage.
     *
     * @param CreateLawSituationRequest $request
     *
     * @return Response
     */
    public function store(CreateLawSituationRequest $request)
    {
       if(!Defender::hasPermission('lawSituations.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $lawSituation = $this->lawSituationRepository->create($input);

        flash('LawSituation saved successfully.')->success();

        return redirect(route('lawSituations.index'));
    }

    /**
     * Display the specified LawSituation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('lawSituations.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawSituation = $this->lawSituationRepository->findWithoutFail($id);

        if (empty($lawSituation)) {
            flash('LawSituation not found')->error();

            return redirect(route('lawSituations.index'));
        }

        return view('lawSituations.show')->with('lawSituation', $lawSituation);
    }

    /**
     * Show the form for editing the specified LawSituation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('lawSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $lawSituation = $this->lawSituationRepository->findWithoutFail($id);

        if (empty($lawSituation)) {
            flash('LawSituation not found')->error();

            return redirect(route('lawSituations.index'));
        }

        return view('lawSituations.edit')->with('lawSituation', $lawSituation);
    }

    /**
     * Update the specified LawSituation in storage.
     *
     * @param  int              $id
     * @param UpdateLawSituationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLawSituationRequest $request)
    {
        if(!Defender::hasPermission('lawSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawSituation = $this->lawSituationRepository->findWithoutFail($id);

        if (empty($lawSituation)) {
            flash('LawSituation not found')->error();

            return redirect(route('lawSituations.index'));
        }

        $lawSituation = $this->lawSituationRepository->update($request->all(), $id);

        flash('LawSituation updated successfully.')->success();

        return redirect(route('lawSituations.index'));
    }

    /**
     * Remove the specified LawSituation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('lawSituations.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawSituation = $this->lawSituationRepository->findWithoutFail($id);

        if (empty($lawSituation)) {
            flash('LawSituation not found')->error();

            return redirect(route('lawSituations.index'));
        }

        $this->lawSituationRepository->delete($id);

        flash('LawSituation deleted successfully.')->success();

        return redirect(route('lawSituations.index'));
    }

    /**
    	 * Update status of specified LawSituation from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('lawSituations.edit'))
            {
                return json_encode(false);
            }
            $register = $this->lawSituationRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
