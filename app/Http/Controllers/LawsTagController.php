<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateLawsTagRequest;
use App\Http\Requests\UpdateLawsTagRequest;
use App\Repositories\LawsTagRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class LawsTagController extends AppBaseController
{
    /** @var  LawsTagRepository */
    private $lawsTagRepository;

    public function __construct(LawsTagRepository $lawsTagRepo)
    {
        $this->lawsTagRepository = $lawsTagRepo;
    }

    /**
     * Display a listing of the LawsTag.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('lawsTags.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->lawsTagRepository->pushCriteria(new RequestCriteria($request));
        $lawsTags = $this->lawsTagRepository->all();

        return view('lawsTags.index')
            ->with('lawsTags', $lawsTags);
    }

    /**
     * Show the form for creating a new LawsTag.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('lawsTags.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('lawsTags.create');
    }

    /**
     * Store a newly created LawsTag in storage.
     *
     * @param CreateLawsTagRequest $request
     *
     * @return Response
     */
    public function store(CreateLawsTagRequest $request)
    {
       if(!Defender::hasPermission('lawsTags.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $lawsTag = $this->lawsTagRepository->create($input);

        Flash::success('LawsTag saved successfully.');

        return redirect(route('lawsTags.index'));
    }

    /**
     * Display the specified LawsTag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('lawsTags.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            Flash::error('LawsTag not found');

            return redirect(route('lawsTags.index'));
        }

        return view('lawsTags.show')->with('lawsTag', $lawsTag);
    }

    /**
     * Show the form for editing the specified LawsTag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('lawsTags.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            Flash::error('LawsTag not found');

            return redirect(route('lawsTags.index'));
        }

        return view('lawsTags.edit')->with('lawsTag', $lawsTag);
    }

    /**
     * Update the specified LawsTag in storage.
     *
     * @param  int              $id
     * @param UpdateLawsTagRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLawsTagRequest $request)
    {
        if(!Defender::hasPermission('lawsTags.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            Flash::error('LawsTag not found');

            return redirect(route('lawsTags.index'));
        }

        $lawsTag = $this->lawsTagRepository->update($request->all(), $id);

        Flash::success('LawsTag updated successfully.');

        return redirect(route('lawsTags.index'));
    }

    /**
     * Remove the specified LawsTag from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('lawsTags.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            Flash::error('LawsTag not found');

            return redirect(route('lawsTags.index'));
        }

        $this->lawsTagRepository->delete($id);

        Flash::success('LawsTag deleted successfully.');

        return redirect(route('lawsTags.index'));
    }

    /**
    	 * Update status of specified LawsTag from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('lawsTags.edit'))
            {
                return json_encode(false);
            }
            $register = $this->lawsTagRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
