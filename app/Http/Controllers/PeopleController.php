<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePeopleRequest;
use App\Http\Requests\UpdatePeopleRequest;
use App\Models\City;
use App\Models\People;
use App\Models\State;
use App\Repositories\PeopleRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class PeopleController extends AppBaseController
{
    /** @var PeopleRepository */
    private $peopleRepository;

    public function __construct(PeopleRepository $peopleRepo)
    {
        $this->peopleRepository = $peopleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('people.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $people = $this->peopleRepository->getAll(0);

        return view('people.index')->with('people', $people);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('people.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $states = $this->statesList();
        $cities = City::where('state', '=', $states[1])->pluck('name', 'id');

        return view('people.create', compact('states', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePeopleRequest $request
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreatePeopleRequest $request)
    {
        if (! Defender::hasPermission('people.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $input = $request->all();

        $people = $this->peopleRepository->create($input);

        flash('Pessoa salva com sucesso.')->success();

        return redirect(route('people.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('people.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $people = $this->peopleRepository->findById($id);

        return view('people.show')->with('people', $people);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('people.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $people = $this->peopleRepository->findById($id);

        $states = $this->statesList();
        $state = State::find($people->state_id);
        $cities = City::where('state', '=', $state->uf)->pluck('name', 'id');

        return view('people.edit', compact('states', 'cities'))->with('people', $people);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePeopleRequest $request
     * @param  int  $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(UpdatePeopleRequest $request, $id)
    {
        if (! Defender::hasPermission('people.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $people = $this->peopleRepository->findById($id);

        $this->peopleRepository->update($people, $request->all());

        return redirect(route('people.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('people.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $people = $this->peopleRepository->findById($id);

        $this->peopleRepository->delete($people);

        return redirect(route('people.index'));
    }

    public function searchByCpf(Request $request)
    {
        return response()
            ->json(People::where('cpf', $request->get('cpf') ?? '')->get());
    }
}
