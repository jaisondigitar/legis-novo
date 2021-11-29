<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdviceAwnserRequest;
use App\Http\Requests\UpdateAdviceAwnserRequest;
use App\Repositories\AdviceAwnserRepository;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdviceAwnserController extends AppBaseController
{
    /** @var AdviceAwnserRepository */
    private $adviceAwnserRepository;

    public function __construct(AdviceAwnserRepository $adviceAwnserRepo)
    {
        $this->adviceAwnserRepository = $adviceAwnserRepo;
    }

    /**
     * Display a listing of the AdviceAwnser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('adviceAwnsers.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $this->adviceAwnserRepository->pushCriteria(new RequestCriteria($request));
        $adviceAwnsers = $this->adviceAwnserRepository->all();

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.index')
            ->with('adviceAwnsers', $adviceAwnsers);
    }

    /**
     * Show the form for creating a new AdviceAwnser.
     *
     * @return Response
     */
    public function create()
    {
        if (! Defender::hasPermission('adviceAwnsers.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.create');
    }

    /**
     * Store a newly created AdviceAwnser in storage.
     *
     * @param CreateAdviceAwnserRequest $request
     *
     * @return Response
     */
    public function store(CreateAdviceAwnserRequest $request)
    {
        if (! Defender::hasPermission('adviceAwnsers.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $adviceAwnser = $this->adviceAwnserRepository->create($input);

        flash('Resposta salva com sucesso.')->success();

        return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
    }

    /**
     * Display the specified AdviceAwnser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('adviceAwnsers.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            flash('Resposta não encontrada')->error();

            return redirect(route('adviceAwnsers.index'));
        }

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.show')->with('adviceAwnser', $adviceAwnser);
    }

    /**
     * Show the form for editing the specified AdviceAwnser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('adviceAwnsers.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            flash('Resposta não encontrada')->error();

            return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
        }

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.edit')->with('adviceAwnser', $adviceAwnser);
    }

    /**
     * Update the specified AdviceAwnser in storage.
     *
     * @param  int              $id
     * @param UpdateAdviceAwnserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdviceAwnserRequest $request)
    {
        if (! Defender::hasPermission('adviceAwnsers.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            flash('Resposta não encontrada')->error();

            return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
        }

        $adviceAwnser = $this->adviceAwnserRepository->update($request->all(), $id);

        flash('Resposta atualizado com sucesso.')->success();

        return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
    }

    /**
     * Remove the specified AdviceAwnser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('adviceAwnsers.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            flash('Resposta não encontrada')->error();

            return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
        }

        $this->adviceAwnserRepository->delete($id);

        flash('Resposta removido com sucesso.')->success();

        return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
    }

    /**
     * Update status of specified AdviceAwnser from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('adviceAwnsers.edit')) {
            return json_encode(false);
        }
        $register = $this->adviceAwnserRepository->findWithoutFail($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
