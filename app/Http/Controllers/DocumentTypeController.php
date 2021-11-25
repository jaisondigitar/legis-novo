<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateDocumentTypeRequest;
use App\Http\Requests\UpdateDocumentTypeRequest;
use App\Models\DocumentType;
use App\Repositories\DocumentTypeRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DocumentTypeController extends AppBaseController
{
    /** @var DocumentTypeRepository */
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
        if (! Defender::hasPermission('documentTypes.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentTypes = DocumentType::where('parent_id', 0)->get();

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
        if (! Defender::hasPermission('documentTypes.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
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
        if (! Defender::hasPermission('documentTypes.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $documentType = $this->documentTypeRepository->create($input);

        flash('Tipo de documento salvo com sucesso.')->success();

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
        if (! Defender::hasPermission('documentTypes.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentType = $this->documentTypeRepository->findById($id);

        if (empty($documentType)) {
            flash('DocumentType not found')->error();

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
        if (! Defender::hasPermission('documentTypes.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $documentType = $this->documentTypeRepository->findById($id);

        if (empty($documentType)) {
            flash('DocumentType not found')->error();

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
        if (! Defender::hasPermission('documentTypes.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentType = $this->documentTypeRepository->findById($id);

        if (empty($documentType)) {
            flash('DocumentType not found')->error();

            return redirect(route('documentTypes.index'));
        }

        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $documentType = $this->documentTypeRepository->update($documentType, $input);

        flash('Tipo de documento atualizado com sucesso.')->success();

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
        if (! Defender::hasPermission('documentTypes.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $documentType = $this->documentTypeRepository->findById($id);

        if (empty($documentType)) {
            flash('DocumentType not found')->error();

            return redirect(route('documentTypes.index'));
        }

        $this->documentTypeRepository->delete($documentType, $id);

        flash('DocumentType deleted successfully.')->success();

        return redirect(route('documentTypes.index'));
    }

    /**
     * Update status of specified DocumentType from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('documentTypes.edit')) {
            return json_encode(false);
        }
        $register = $this->documentTypeRepository->findById($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
