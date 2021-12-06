<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdvicePublicationLawRequest;
use App\Http\Requests\UpdateAdvicePublicationLawRequest;
use App\Repositories\AdvicePublicationLawRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdvicePublicationLawController extends AppBaseController
{
    /** @var AdvicePublicationLawRepository */
    private $advicePublicationLawRepository;

    public function __construct(AdvicePublicationLawRepository $advicePublicationLawRepo)
    {
        $this->advicePublicationLawRepository = $advicePublicationLawRepo;
    }

    /**
     * Display a listing of the AdvicePublicationLaw.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('advicePublicationLaws.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        // $this->advicePublicationLawRepository->pushCriteria(new RequestCriteria($request));
        $advicePublicationLaws = $this->advicePublicationLawRepository->getAll(0);

        return view('advicePublicationLaws.index')
            ->with('advicePublicationLaws', $advicePublicationLaws);
    }

    /**
     * Show the form for creating a new AdvicePublicationLaw.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('advicePublicationLaws.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('advicePublicationLaws.create');
    }

    /**
     * Store a newly created AdvicePublicationLaw in storage.
     *
     * @param CreateAdvicePublicationLawRequest $request
     *
     * @return Response
     */
    public function store(CreateAdvicePublicationLawRequest $request)
    {
        if (! Defender::hasPermission('advicePublicationLaws.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $advicePublicationLaw = $this->advicePublicationLawRepository->create($input);

        flash('Publicação do Parecer da Lei salvo com sucesso.')->success();

        return redirect(route('advicePublicationLaws.index'));
    }

    /**
     * Display the specified AdvicePublicationLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('advicePublicationLaws.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advicePublicationLaw = $this->advicePublicationLawRepository->findById($id);

        if (empty($advicePublicationLaw)) {
            flash('Publicação do Parecer da Lei não encontrado')->error();

            return redirect(route('advicePublicationLaws.index'));
        }

        return view('advicePublicationLaws.show')->with('advicePublicationLaw', $advicePublicationLaw);
    }

    /**
     * Show the form for editing the specified AdvicePublicationLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('advicePublicationLaws.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $advicePublicationLaw = $this->advicePublicationLawRepository->findById($id);

        if (empty($advicePublicationLaw)) {
            flash('Publicação do Parecer da Lei não encontrado')->error();

            return redirect(route('advicePublicationLaws.index'));
        }

        return view('advicePublicationLaws.edit')->with('advicePublicationLaw', $advicePublicationLaw);
    }

    /**
     * Update the specified AdvicePublicationLaw in storage.
     *
     * @param  int              $id
     * @param UpdateAdvicePublicationLawRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdvicePublicationLawRequest $request)
    {
        if (! Defender::hasPermission('advicePublicationLaws.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advicePublicationLaw = $this->advicePublicationLawRepository->findById($id);

        if (empty($advicePublicationLaw)) {
            flash('Publicação do Parecer da Lei não encontrado')->error();

            return redirect(route('advicePublicationLaws.index'));
        }

        $advicePublicationLaw = $this->advicePublicationLawRepository->update($advicePublicationLaw, $request->all(), );

        flash('Publicação do Parecer da Lei atualizado com sucesso.')->success();

        return redirect(route('advicePublicationLaws.index'));
    }

    /**
     * Remove the specified AdvicePublicationLaw from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('advicePublicationLaws.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advicePublicationLaw = $this->advicePublicationLawRepository->findById($id);

        if (empty($advicePublicationLaw)) {
            flash('Publicação do Parecer da Lei não encontrado')->error();

            return redirect(route('advicePublicationLaws.index'));
        }

        $this->advicePublicationLawRepository->delete($advicePublicationLaw);

        flash('Publicação do Parecer da Lei removido com sucesso.')->success();

        return redirect(route('advicePublicationLaws.index'));
    }

    /**
     * Update status of specified AdvicePublicationLaw from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('advicePublicationLaws.edit')) {
            return json_encode(false);
        }
        $register = $this->advicePublicationLawRepository->findById($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
