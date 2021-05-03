<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdviceSituationLawRequest;
use App\Http\Requests\UpdateAdviceSituationLawRequest;
use App\Repositories\AdviceSituationLawRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class AdviceSituationLawController extends AppBaseController
{
    /** @var  AdviceSituationLawRepository */
    private $adviceSituationLawRepository;

    public function __construct(AdviceSituationLawRepository $adviceSituationLawRepo)
    {
        $this->adviceSituationLawRepository = $adviceSituationLawRepo;
    }

    /**
     * Display a listing of the AdviceSituationLaw.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('adviceSituationLaws.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->adviceSituationLawRepository->pushCriteria(new RequestCriteria($request));
        $adviceSituationLaws = $this->adviceSituationLawRepository->all();

        return view('adviceSituationLaws.index')
            ->with('adviceSituationLaws', $adviceSituationLaws);
    }

    /**
     * Show the form for creating a new AdviceSituationLaw.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('adviceSituationLaws.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('adviceSituationLaws.create');
    }

    /**
     * Store a newly created AdviceSituationLaw in storage.
     *
     * @param CreateAdviceSituationLawRequest $request
     *
     * @return Response
     */
    public function store(CreateAdviceSituationLawRequest $request)
    {
       if(!Defender::hasPermission('adviceSituationLaws.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $adviceSituationLaw = $this->adviceSituationLawRepository->create($input);


        Flash::success('AdviceSituationLaw saved successfully.');

        return redirect(route('adviceSituationLaws.index'));
    }

    /**
     * Display the specified AdviceSituationLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('adviceSituationLaws.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->findWithoutFail($id);

        if (empty($adviceSituationLaw)) {
            Flash::error('AdviceSituationLaw not found');

            return redirect(route('adviceSituationLaws.index'));
        }

        return view('adviceSituationLaws.show')->with('adviceSituationLaw', $adviceSituationLaw);
    }

    /**
     * Show the form for editing the specified AdviceSituationLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('adviceSituationLaws.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $adviceSituationLaw = $this->adviceSituationLawRepository->findWithoutFail($id);

        if (empty($adviceSituationLaw)) {
            Flash::error('AdviceSituationLaw not found');

            return redirect(route('adviceSituationLaws.index'));
        }

        return view('adviceSituationLaws.edit')->with('adviceSituationLaw', $adviceSituationLaw);
    }

    /**
     * Update the specified AdviceSituationLaw in storage.
     *
     * @param  int              $id
     * @param UpdateAdviceSituationLawRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdviceSituationLawRequest $request)
    {
        if(!Defender::hasPermission('adviceSituationLaws.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->findWithoutFail($id);

        if (empty($adviceSituationLaw)) {
            Flash::error('AdviceSituationLaw not found');

            return redirect(route('adviceSituationLaws.index'));
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->update($request->all(), $id);

        Flash::success('AdviceSituationLaw updated successfully.');

        return redirect(route('adviceSituationLaws.index'));
    }

    /**
     * Remove the specified AdviceSituationLaw from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('adviceSituationLaws.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->findWithoutFail($id);

        if (empty($adviceSituationLaw)) {
            Flash::error('AdviceSituationLaw not found');

            return redirect(route('adviceSituationLaws.index'));
        }

        $this->adviceSituationLawRepository->delete($id);

        Flash::success('AdviceSituationLaw deleted successfully.');

        return redirect(route('adviceSituationLaws.index'));
    }

    /**
    	 * Update status of specified AdviceSituationLaw from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('adviceSituationLaws.edit'))
            {
                return json_encode(false);
            }
            $register = $this->adviceSituationLawRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
