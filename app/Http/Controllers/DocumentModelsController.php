<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateDocumentModelsRequest;
use App\Http\Requests\UpdateDocumentModelsRequest;
use App\Models\DocumentType;
use App\Repositories\DocumentModelsRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class DocumentModelsController extends AppBaseController
{
    /** @var  DocumentModelsRepository */
    private $documentModelsRepository;

    public function __construct(DocumentModelsRepository $documentModelsRepo)
    {
        $this->documentModelsRepository = $documentModelsRepo;
    }

    /**
     * Display a listing of the DocumentModels.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('documentModels.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->documentModelsRepository->pushCriteria(new RequestCriteria($request));
        $documentModels = $this->documentModelsRepository->all();

        return view('documentModels.index')
            ->with('documentModels', $documentModels);

    }

    /**
     * Show the form for creating a new DocumentModels.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('documentModels.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $document_type = DocumentType::lists('name', 'id')->prepend('Selecione...', '');;

        return view('documentModels.create')->with('document_type', $document_type);
    }

    /**
     * Store a newly created DocumentModels in storage.
     *
     * @param CreateDocumentModelsRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentModelsRequest $request)
    {
       if(!Defender::hasPermission('documentModels.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $documentModels = $this->documentModelsRepository->create($input);

        Flash::success('Modelo de documento salvo com sucesso.');

        return redirect(route('documentModels.index'));
    }

    /**
     * Display the specified DocumentModels.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
//        if(!Defender::hasPermission('documentModels.show'))
//        {
//            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
//            return redirect("/");
//        }

        $documentModels = $this->documentModelsRepository->findWithoutFail($id);

        if (empty($documentModels)) {
            Flash::error('Modelo de documento não encontrado');

            return redirect(route('documentModels.index'));
        }

        return view('documentModels.show')->with('documentModels', $documentModels);
    }

    /**
     * Show the form for editing the specified DocumentModels.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('documentModels.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $documentModels = $this->documentModelsRepository->findWithoutFail($id);

        if (empty($documentModels)) {
            Flash::error('DocumentModels not found');

            return redirect(route('documentModels.index'));
        }

        $document_type = DocumentType::lists('name', 'id')->prepend('Selecione...', '');

        return view('documentModels.edit')->with('documentModels', $documentModels)->with('document_type', $document_type);
    }

    /**
     * Update the specified DocumentModels in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentModelsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentModelsRequest $request)
    {
        if(!Defender::hasPermission('documentModels.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $documentModels = $this->documentModelsRepository->findWithoutFail($id);

        if (empty($documentModels)) {
            Flash::error('DocumentModels not found');

            return redirect(route('documentModels.index'));
        }

        $documentModels = $this->documentModelsRepository->update($request->all(), $id);

        Flash::success('Modelo de documento atualizado com sucesso.');

        return redirect(route('documentModels.index'));
    }

    /**
     * Remove the specified DocumentModels from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('documentModels.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $documentModels = $this->documentModelsRepository->findWithoutFail($id);

        if (empty($documentModels)) {
            Flash::error('DocumentModels not found');

            return redirect(route('documentModels.index'));
        }

        $this->documentModelsRepository->delete($id);

        Flash::success('DocumentModels deleted successfully.');

        return redirect(route('documentModels.index'));
    }

    /**
    	 * Update status of specified DocumentModels from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('documentModels.edit'))
            {
                return json_encode(false);
            }
            $register = $this->documentModelsRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
