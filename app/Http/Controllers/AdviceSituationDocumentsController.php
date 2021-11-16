<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdviceSituationDocumentsRequest;
use App\Http\Requests\UpdateAdviceSituationDocumentsRequest;
use App\Repositories\AdviceSituationDocumentsRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class AdviceSituationDocumentsController extends AppBaseController
{
    /** @var  AdviceSituationDocumentsRepository */
    private $adviceSituationDocumentsRepository;

    public function __construct(AdviceSituationDocumentsRepository $adviceSituationDocumentsRepo)
    {
        $this->adviceSituationDocumentsRepository = $adviceSituationDocumentsRepo;
    }

    /**
     * Display a listing of the AdviceSituationDocuments.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->adviceSituationDocumentsRepository->pushCriteria(new RequestCriteria($request));
        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->all();

        return view('adviceSituationDocuments.index')
            ->with('adviceSituationDocuments', $adviceSituationDocuments);
    }

    /**
     * Show the form for creating a new AdviceSituationDocuments.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('adviceSituationDocuments.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('adviceSituationDocuments.create');
    }

    /**
     * Store a newly created AdviceSituationDocuments in storage.
     *
     * @param CreateAdviceSituationDocumentsRequest $request
     *
     * @return Response
     */
    public function store(CreateAdviceSituationDocumentsRequest $request)
    {
       if(!Defender::hasPermission('adviceSituationDocuments.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->create($input);

        flash('Situação de Aconselhamento de Documentos salvo com sucesso.')->success();

        return redirect(route('adviceSituationDocuments.index'));
    }

    /**
     * Display the specified AdviceSituationDocuments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findWithoutFail($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        return view('adviceSituationDocuments.show')->with('adviceSituationDocuments', $adviceSituationDocuments);
    }

    /**
     * Show the form for editing the specified AdviceSituationDocuments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findWithoutFail($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        return view('adviceSituationDocuments.edit')->with('adviceSituationDocuments', $adviceSituationDocuments);
    }

    /**
     * Update the specified AdviceSituationDocuments in storage.
     *
     * @param  int              $id
     * @param UpdateAdviceSituationDocumentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdviceSituationDocumentsRequest $request)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findWithoutFail($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->update($request->all(), $id);

        flash('Situação de Aconselhamento de Documentos atualizado com sucesso.')->success();

        return redirect(route('adviceSituationDocuments.index'));
    }

    /**
     * Remove the specified AdviceSituationDocuments from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('adviceSituationDocuments.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $adviceSituationDocuments = $this->adviceSituationDocumentsRepository->findWithoutFail($id);

        if (empty($adviceSituationDocuments)) {
            flash('Situação de Aconselhamento de Documentos não encontrado')->error();

            return redirect(route('adviceSituationDocuments.index'));
        }

        $this->adviceSituationDocumentsRepository->delete($id);

        flash('Situação de Aconselhamento de Documentos removido com sucesso.')->success();

        return redirect(route('adviceSituationDocuments.index'));
    }

    /**
    	 * Update status of specified AdviceSituationDocuments from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('adviceSituationDocuments.edit'))
            {
                return json_encode(false);
            }
            $register = $this->adviceSituationDocumentsRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
