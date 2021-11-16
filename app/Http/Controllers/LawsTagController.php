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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsTags = $this->lawsTagRepository->getAll(0);

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
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
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $lawsTag = $this->lawsTagRepository->create($input);

        flash('Tag de Lei salva com sucesso.')->success();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            flash('Tag de Lei não encontrada')->error();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            flash('Tag de Lei não encontrada')->error();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            flash('Tag de Lei não encontrada')->error();

            return redirect(route('lawsTags.index'));
        }

        $lawsTag = $this->lawsTagRepository->update($request->all(), $id);

        flash('Tag de Lei atualizada com sucesso.')->success();

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
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $lawsTag = $this->lawsTagRepository->findWithoutFail($id);

        if (empty($lawsTag)) {
            flash('Tag de Lei não encontrada')->error();

            return redirect(route('lawsTags.index'));
        }

        $this->lawsTagRepository->delete($id);

        flash('Tag de Lei removida com sucesso.')->success();

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
