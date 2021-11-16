<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateStatusProcessingLawRequest;
use App\Http\Requests\UpdateStatusProcessingLawRequest;
use App\Repositories\StatusProcessingLawRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class StatusProcessingLawController extends AppBaseController
{
    /** @var  StatusProcessingLawRepository */
    private $statusProcessingLawRepository;

    public function __construct(StatusProcessingLawRepository $statusProcessingLawRepo)
    {
        $this->statusProcessingLawRepository = $statusProcessingLawRepo;
    }

    /**
     * Display a listing of the StatusProcessingLaw.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('statusProcessingLaws.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        // $this->statusProcessingLawRepository->pushCriteria(new RequestCriteria($request));
        $statusProcessingLaws = $this->statusProcessingLawRepository->getAll(0);

        return view('statusProcessingLaws.index')
            ->with('statusProcessingLaws', $statusProcessingLaws);
    }

    /**
     * Show the form for creating a new StatusProcessingLaw.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('statusProcessingLaws.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('statusProcessingLaws.create');
    }

    /**
     * Store a newly created StatusProcessingLaw in storage.
     *
     * @param CreateStatusProcessingLawRequest $request
     *
     * @return Response
     */
    public function store(CreateStatusProcessingLawRequest $request)
    {
       if(!Defender::hasPermission('statusProcessingLaws.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $statusProcessingLaw = $this->statusProcessingLawRepository->create($input);

        flash('StatusProcessingLaw saved successfully.')->success();

        return redirect(route('statusProcessingLaws.index'));
    }

    /**
     * Display the specified StatusProcessingLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('statusProcessingLaws.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $statusProcessingLaw = $this->statusProcessingLawRepository->findWithoutFail($id);

        if (empty($statusProcessingLaw)) {
            flash('StatusProcessingLaw not found')->error();

            return redirect(route('statusProcessingLaws.index'));
        }

        return view('statusProcessingLaws.show')->with('statusProcessingLaw', $statusProcessingLaw);
    }

    /**
     * Show the form for editing the specified StatusProcessingLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('statusProcessingLaws.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $statusProcessingLaw = $this->statusProcessingLawRepository->findWithoutFail($id);

        if (empty($statusProcessingLaw)) {
            flash('StatusProcessingLaw not found')->error();

            return redirect(route('statusProcessingLaws.index'));
        }

        return view('statusProcessingLaws.edit')->with('statusProcessingLaw', $statusProcessingLaw);
    }

    /**
     * Update the specified StatusProcessingLaw in storage.
     *
     * @param  int              $id
     * @param UpdateStatusProcessingLawRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatusProcessingLawRequest $request)
    {
        if(!Defender::hasPermission('statusProcessingLaws.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $statusProcessingLaw = $this->statusProcessingLawRepository->findWithoutFail($id);

        if (empty($statusProcessingLaw)) {
            flash('StatusProcessingLaw not found')->error();

            return redirect(route('statusProcessingLaws.index'));
        }

        $statusProcessingLaw = $this->statusProcessingLawRepository->update($request->all(), $id);

        flash('StatusProcessingLaw updated successfully.')->success();

        return redirect(route('statusProcessingLaws.index'));
    }

    /**
     * Remove the specified StatusProcessingLaw from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('statusProcessingLaws.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $statusProcessingLaw = $this->statusProcessingLawRepository->findWithoutFail($id);

        if (empty($statusProcessingLaw)) {
            flash('StatusProcessingLaw not found')->error();

            return redirect(route('statusProcessingLaws.index'));
        }

        $this->statusProcessingLawRepository->delete($id);

        flash('StatusProcessingLaw deleted successfully.')->success();

        return redirect(route('statusProcessingLaws.index'));
    }

    /**
    	 * Update status of specified StatusProcessingLaw from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('statusProcessingLaws.edit'))
            {
                return json_encode(false);
            }
            $register = $this->statusProcessingLawRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
