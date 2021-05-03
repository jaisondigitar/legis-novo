<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateDocumentTypeRequest;
use App\Http\Requests\UpdateDocumentTypeRequest;
use App\Models\DocumentType;
use App\Repositories\DocumentTypeRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class DocumentTypeController extends AppBaseController
{
    /** @var  DocumentTypeRepository */
    private $documentTypeRepository;

    public function __construct(DocumentTypeRepository $documentTypeRepo)
    {
        $this->documentTypeRepository = $documentTypeRepo;
    }

    /**
     * Display a listing of the DocumentType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('documentTypes.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $documentTypes = DocumentType::where('parent_id',0)->get();

        return view('documentTypes.index')
            ->with('documentTypes', $documentTypes);
    }

    /**
     * Show the form for creating a new DocumentType.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('documentTypes.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('documentTypes.create');
    }

    /**
     * Store a newly created DocumentType in storage.
     *
     * @param CreateDocumentTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentTypeRequest $request)
    {
       if(!Defender::hasPermission('documentTypes.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $documentType = $this->documentTypeRepository->create($input);

        Flash::success('Tipo de documento salvo com sucesso.');

        return redirect(route('documentTypes.index'));
    }

    /**
     * Display the specified DocumentType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('documentTypes.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $documentType = $this->documentTypeRepository->findWithoutFail($id);

        if (empty($documentType)) {
            Flash::error('DocumentType not found');

            return redirect(route('documentTypes.index'));
        }

        return view('documentTypes.show')->with('documentType', $documentType);
    }

    /**
     * Show the form for editing the specified DocumentType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('documentTypes.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $documentType = $this->documentTypeRepository->findWithoutFail($id);

        if (empty($documentType)) {
            Flash::error('DocumentType not found');

            return redirect(route('documentTypes.index'));
        }

        return view('documentTypes.edit')->with('documentType', $documentType);
    }

    /**
     * Update the specified DocumentType in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentTypeRequest $request)
    {
        if(!Defender::hasPermission('documentTypes.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $documentType = $this->documentTypeRepository->findWithoutFail($id);

        if (empty($documentType)) {
            Flash::error('DocumentType not found');

            return redirect(route('documentTypes.index'));
        }

        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $documentType = $this->documentTypeRepository->update($input, $id);

        Flash::success('Tipo de documento atualizado com sucesso.');

        return redirect(route('documentTypes.index'));
    }

    /**
     * Remove the specified DocumentType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('documentTypes.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $documentType = $this->documentTypeRepository->findWithoutFail($id);

        if (empty($documentType)) {
            Flash::error('DocumentType not found');

            return redirect(route('documentTypes.index'));
        }

        $this->documentTypeRepository->delete($id);

        Flash::success('DocumentType deleted successfully.');

        return redirect(route('documentTypes.index'));
    }

    /**
    	 * Update status of specified DocumentType from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('documentTypes.edit'))
            {
                return json_encode(false);
            }
            $register = $this->documentTypeRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
