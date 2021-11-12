<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdvicePublicationDocumentsRequest;
use App\Http\Requests\UpdateAdvicePublicationDocumentsRequest;
use App\Repositories\AdvicePublicationDocumentsRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class AdvicePublicationDocumentsController extends AppBaseController
{
    /** @var  AdvicePublicationDocumentsRepository */
    private $advicePublicationDocumentsRepository;

    public function __construct(AdvicePublicationDocumentsRepository $advicePublicationDocumentsRepo)
    {
        $this->advicePublicationDocumentsRepository = $advicePublicationDocumentsRepo;
    }

    /**
     * Display a listing of the AdvicePublicationDocuments.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('advicePublicationDocuments.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->advicePublicationDocumentsRepository->pushCriteria(new RequestCriteria($request));
        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->all();

        return view('advicePublicationDocuments.index')
            ->with('advicePublicationDocuments', $advicePublicationDocuments);
    }

    /**
     * Show the form for creating a new AdvicePublicationDocuments.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('advicePublicationDocuments.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('advicePublicationDocuments.create');
    }

    /**
     * Store a newly created AdvicePublicationDocuments in storage.
     *
     * @param CreateAdvicePublicationDocumentsRequest $request
     *
     * @return Response
     */
    public function store(CreateAdvicePublicationDocumentsRequest $request)
    {
       if(!Defender::hasPermission('advicePublicationDocuments.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->create($input);

        flash('Aconselhamento de Documentos de Publicação salvos com sucesso.')->success();

        return redirect(route('advicePublicationDocuments.index'));
    }

    /**
     * Display the specified AdvicePublicationDocuments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('advicePublicationDocuments.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        return view('advicePublicationDocuments.show')->with('advicePublicationDocuments', $advicePublicationDocuments);
    }

    /**
     * Show the form for editing the specified AdvicePublicationDocuments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('advicePublicationDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        return view('advicePublicationDocuments.edit')->with('advicePublicationDocuments', $advicePublicationDocuments);
    }

    /**
     * Update the specified AdvicePublicationDocuments in storage.
     *
     * @param  int              $id
     * @param UpdateAdvicePublicationDocumentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdvicePublicationDocumentsRequest $request)
    {
        if(!Defender::hasPermission('advicePublicationDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->update($request->all(), $id);

        flash('Aconselhamento de Documentos de Publicação atualizado com sucesso.')->success();

        return redirect(route('advicePublicationDocuments.index'));
    }

    /**
     * Remove the specified AdvicePublicationDocuments from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('advicePublicationDocuments.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            flash('Aconselhamento de Documentos de Publicação não encontrados')->error();

            return redirect(route('advicePublicationDocuments.index'));
        }

        $this->advicePublicationDocumentsRepository->delete($id);

        flash('Aconselhamento de Documentos de Publicação removido com sucesso.')->success();

        return redirect(route('advicePublicationDocuments.index'));
    }

    /**
    	 * Update status of specified AdvicePublicationDocuments from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('advicePublicationDocuments.edit'))
            {
                return json_encode(false);
            }
            $register = $this->advicePublicationDocumentsRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
