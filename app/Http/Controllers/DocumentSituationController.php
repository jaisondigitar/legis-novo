<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateDocumentSituationRequest;
use App\Http\Requests\UpdateDocumentSituationRequest;
use App\Repositories\DocumentSituationRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class DocumentSituationController extends AppBaseController
{
    /** @var  DocumentSituationRepository */
    private $documentSituationRepository;

    public function __construct(DocumentSituationRepository $documentSituationRepo)
    {
        $this->documentSituationRepository = $documentSituationRepo;
    }

    /**
     * Display a listing of the DocumentSituation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('documentSituations.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->documentSituationRepository->pushCriteria(new RequestCriteria($request));
        $documentSituations = $this->documentSituationRepository->all();

        return view('documentSituations.index')
            ->with('documentSituations', $documentSituations);
    }

    /**
     * Show the form for creating a new DocumentSituation.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('documentSituations.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('documentSituations.create');
    }

    /**
     * Store a newly created DocumentSituation in storage.
     *
     * @param CreateDocumentSituationRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentSituationRequest $request)
    {
       if(!Defender::hasPermission('documentSituations.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $documentSituation = $this->documentSituationRepository->create($input);

        flash('Situção de Documento salva com secesso.')->success();

        return redirect(route('documentSituations.index'));
    }

    /**
     * Display the specified DocumentSituation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('documentSituations.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $documentSituation = $this->documentSituationRepository->findWithoutFail($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        return view('documentSituations.show')->with('documentSituation', $documentSituation);
    }

    /**
     * Show the form for editing the specified DocumentSituation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('documentSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $documentSituation = $this->documentSituationRepository->findWithoutFail($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        return view('documentSituations.edit')->with('documentSituation', $documentSituation);
    }

    /**
     * Update the specified DocumentSituation in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentSituationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentSituationRequest $request)
    {
        if(!Defender::hasPermission('documentSituations.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $documentSituation = $this->documentSituationRepository->findWithoutFail($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        $input = $request->all();

        $input['active'] = isset($input['active']) ? 1 : 0;

        $documentSituation = $this->documentSituationRepository->update($input, $id);

        flash('Situção de Documento atualizado com sucesso.')->success();

        return redirect(route('documentSituations.index'));
    }

    /**
     * Remove the specified DocumentSituation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('documentSituations.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $documentSituation = $this->documentSituationRepository->findWithoutFail($id);

        if (empty($documentSituation)) {
            flash('Situção de Documento não encontrada')->error();

            return redirect(route('documentSituations.index'));
        }

        $this->documentSituationRepository->delete($id);

        flash('Situção de Documento removido com sucesso.')->success();

        return redirect(route('documentSituations.index'));
    }

    /**
    	 * Update status of specified DocumentSituation from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('documentSituations.edit'))
            {
                return json_encode(false);
            }
            $register = $this->documentSituationRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
