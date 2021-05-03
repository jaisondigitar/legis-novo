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
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
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
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
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
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->create($input);

        Flash::success('AdvicePublicationDocuments saved successfully.');

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
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            Flash::error('AdvicePublicationDocuments not found');

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
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            Flash::error('AdvicePublicationDocuments not found');

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
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            Flash::error('AdvicePublicationDocuments not found');

            return redirect(route('advicePublicationDocuments.index'));
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->update($request->all(), $id);

        Flash::success('AdvicePublicationDocuments updated successfully.');

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
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $advicePublicationDocuments = $this->advicePublicationDocumentsRepository->findWithoutFail($id);

        if (empty($advicePublicationDocuments)) {
            Flash::error('AdvicePublicationDocuments not found');

            return redirect(route('advicePublicationDocuments.index'));
        }

        $this->advicePublicationDocumentsRepository->delete($id);

        Flash::success('AdvicePublicationDocuments deleted successfully.');

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
