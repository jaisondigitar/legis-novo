<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Repositories\PartyRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class PartyController extends AppBaseController
{
    /** @var PartyRepository */
    private $partyRepository;

    public function __construct(PartyRepository $partyRepo)
    {
        $this->partyRepository = $partyRepo;
    }

    /**
     * Display a listing of the Party.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('parties.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $parties = $this->partyRepository->getAll(0);

        return view('parties.index')
            ->with('parties', $parties);
    }

    /**
     * Show the form for creating a new Party.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('parties.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('parties.create');
    }

    /**
     * Store a newly created Party in storage.
     *
     * @param CreatePartyRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreatePartyRequest $request)
    {
        if (! Defender::hasPermission('parties.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $input = $request->all();

        $party = $this->partyRepository->create($input);

        flash('Partido salvo com sucesso.')->success();

        return redirect(route('parties.index'));
    }

    /**
     * Display the specified Party.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('parties.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $party = $this->partyRepository->findByID($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        return view('parties.show')->with('party', $party);
    }

    /**
     * Show the form for editing the specified Party.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('parties.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $party = $this->partyRepository->findByID($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        return view('parties.edit')->with('party', $party);
    }

    /**
     * Update the specified Party in storage.
     *
     * @param int $id
     * @param UpdatePartyRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdatePartyRequest $request)
    {
        if (! Defender::hasPermission('parties.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $party = $this->partyRepository->findByID($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        $this->partyRepository->update($party, $request->all());

        flash('Partido atualizado com sucesso.')->success();

        return redirect(route('parties.index'));
    }

    /**
     * Remove the specified Party from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('parties.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $party = $this->partyRepository->findByID($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        $this->partyRepository->delete($party);

        flash('Partido removido com sucesso.')->success();

        return redirect(route('parties.index'));
    }

    /**
     * Update status of specified Party from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('parties.edit')) {
            return json_encode(false);
        }

        $register = $this->partyRepository->findByID($id);

        $register->active = $register->active > 0 ? 0 : 1;

        $register->save();

        return json_encode(true);
    }
}
