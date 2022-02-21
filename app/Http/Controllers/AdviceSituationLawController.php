<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdviceSituationLawRequest;
use App\Http\Requests\UpdateAdviceSituationLawRequest;
use App\Repositories\AdviceSituationLawRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdviceSituationLawController extends AppBaseController
{
    /** @var AdviceSituationLawRepository */
    private $adviceSituationLawRepository;

    public function __construct(AdviceSituationLawRepository $adviceSituationLawRepo)
    {
        $this->adviceSituationLawRepository = $adviceSituationLawRepo;
    }

    /**
     * Display a listing of the AdviceSituationLaw.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('adviceSituationLaws.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        // $this->adviceSituationLawRepository->pushCriteria(new RequestCriteria($request));
        $adviceSituationLaws = $this->adviceSituationLawRepository->getAll(0);

        return view('adviceSituationLaws.index')
            ->with('adviceSituationLaws', $adviceSituationLaws);
    }

    /**
     * Show the form for creating a new AdviceSituationLaw.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('adviceSituationLaws.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('adviceSituationLaws.create');
    }

    /**
     * Store a newly created AdviceSituationLaw in storage.
     *
     * @param CreateAdviceSituationLawRequest $request
     *
     * @return Response
     */
    public function store(CreateAdviceSituationLawRequest $request)
    {
        if (! Defender::hasPermission('adviceSituationLaws.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $adviceSituationLaw = $this->adviceSituationLawRepository->create($input);

        flash('Situação do Parecer da Lei salvo com sucesso.')->success();

        return redirect(route('adviceSituationLaws.index'));
    }

    /**
     * Display the specified AdviceSituationLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('adviceSituationLaws.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->findById($id);

        if (empty($adviceSituationLaw)) {
            flash('Situação do Parecer da Lei não encontrado')->error();

            return redirect(route('adviceSituationLaws.index'));
        }

        return view('adviceSituationLaws.show')->with('adviceSituationLaw', $adviceSituationLaw);
    }

    /**
     * Show the form for editing the specified AdviceSituationLaw.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('adviceSituationLaws.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $adviceSituationLaw = $this->adviceSituationLawRepository->findById($id);

        if (empty($adviceSituationLaw)) {
            flash('Situação do Parecer da Lei não encontrado')->error();

            return redirect(route('adviceSituationLaws.index'));
        }

        return view('adviceSituationLaws.edit')->with('adviceSituationLaw', $adviceSituationLaw);
    }

    /**
     * Update the specified AdviceSituationLaw in storage.
     *
     * @param  int              $id
     * @param UpdateAdviceSituationLawRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdviceSituationLawRequest $request)
    {
        if (! Defender::hasPermission('adviceSituationLaws.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->findById($id);

        if (empty($adviceSituationLaw)) {
            flash('Situação do Parecer da Lei não encontrado')->error();

            return redirect(route('adviceSituationLaws.index'));
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->update($adviceSituationLaw, $request->all());

        flash('Situação do Parecer da Lei atualizado com sucesso.')->success();

        return redirect(route('adviceSituationLaws.index'));
    }

    /**
     * Remove the specified AdviceSituationLaw from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        if (! Defender::hasPermission('adviceSituationLaws.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $adviceSituationLaw = $this->adviceSituationLawRepository->findById($id);

        if (empty($adviceSituationLaw)) {
            flash('Situação do Parecer da Lei não encontrado')->error();

            return redirect(route('adviceSituationLaws.index'));
        }

        $this->adviceSituationLawRepository->delete($adviceSituationLaw);

        if ($request->ajax()) {
            return 'success';
        }

        flash('Situação do Parecer da Lei removido com sucesso.')->success();

        return redirect(route('adviceSituationLaws.index'));
    }

    /**
     * Update status of specified AdviceSituationLaw from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('adviceSituationLaws.edit')) {
            return json_encode(false);
        }
        $register = $this->adviceSituationLawRepository->findById($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
