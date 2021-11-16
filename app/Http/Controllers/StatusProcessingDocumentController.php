<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateStatusProcessingDocumentRequest;
use App\Http\Requests\UpdateStatusProcessingDocumentRequest;
use App\Repositories\StatusProcessingDocumentRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class StatusProcessingDocumentController extends AppBaseController
{
    /** @var  StatusProcessingDocumentRepository */
    private $statusProcessingDocumentRepository;

    public function __construct(StatusProcessingDocumentRepository $statusProcessingDocumentRepo)
    {
        $this->statusProcessingDocumentRepository = $statusProcessingDocumentRepo;
    }

    /**
     * Display a listing of the StatusProcessingDocument.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('statusProcessingDocuments.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->statusProcessingDocumentRepository->pushCriteria(new RequestCriteria($request));
        $statusProcessingDocuments = $this->statusProcessingDocumentRepository->all();

        return view('statusProcessingDocuments.index')
            ->with('statusProcessingDocuments', $statusProcessingDocuments);
    }

    /**
     * Show the form for creating a new StatusProcessingDocument.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('statusProcessingDocuments.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('statusProcessingDocuments.create');
    }

    /**
     * Store a newly created StatusProcessingDocument in storage.
     *
     * @param CreateStatusProcessingDocumentRequest $request
     *
     * @return Response
     */
    public function store(CreateStatusProcessingDocumentRequest $request)
    {
       if(!Defender::hasPermission('statusProcessingDocuments.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->create($input);

        flash('StatusProcessingDocument saved successfully.')->success();

        return redirect(route('statusProcessingDocuments.index'));
    }

    /**
     * Display the specified StatusProcessingDocument.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('statusProcessingDocuments.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findWithoutFail($id);

        if (empty($statusProcessingDocument)) {
            flash('StatusProcessingDocument not found')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        return view('statusProcessingDocuments.show')->with('statusProcessingDocument', $statusProcessingDocument);
    }

    /**
     * Show the form for editing the specified StatusProcessingDocument.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('statusProcessingDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findWithoutFail($id);

        if (empty($statusProcessingDocument)) {
            flash('StatusProcessingDocument not found')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        return view('statusProcessingDocuments.edit')->with('statusProcessingDocument', $statusProcessingDocument);
    }

    /**
     * Update the specified StatusProcessingDocument in storage.
     *
     * @param  int              $id
     * @param UpdateStatusProcessingDocumentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatusProcessingDocumentRequest $request)
    {
        if(!Defender::hasPermission('statusProcessingDocuments.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findWithoutFail($id);

        if (empty($statusProcessingDocument)) {
            flash('StatusProcessingDocument not found')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->update($request->all(), $id);

        flash('StatusProcessingDocument updated successfully.')->success();

        return redirect(route('statusProcessingDocuments.index'));
    }

    /**
     * Remove the specified StatusProcessingDocument from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('statusProcessingDocuments.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $statusProcessingDocument = $this->statusProcessingDocumentRepository->findWithoutFail($id);

        if (empty($statusProcessingDocument)) {
            flash('StatusProcessingDocument not found')->error();

            return redirect(route('statusProcessingDocuments.index'));
        }

        $this->statusProcessingDocumentRepository->delete($id);

        flash('StatusProcessingDocument deleted successfully.')->success();

        return redirect(route('statusProcessingDocuments.index'));
    }

    /**
    	 * Update status of specified StatusProcessingDocument from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('statusProcessingDocuments.edit'))
            {
                return json_encode(false);
            }
            $register = $this->statusProcessingDocumentRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
