<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAssemblymanRequest;
use App\Http\Requests\UpdateAssemblymanRequest;
use App\Models\Assemblyman;
use App\Models\City;
use App\Models\Legislature;
use App\Models\LegislatureAssemblyman;
use App\Models\PartiesAssemblyman;
use App\Models\Party;
use App\Models\Responsibility;
use App\Models\ResponsibilityAssemblyman;
use App\Models\State;
use App\Repositories\AssemblymanRepository;
use App\Services\StorageService;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class AssemblymanController extends AppBaseController
{
    /** @var AssemblymanRepository */
    private $assemblymanRepository;

    private static $uploadService;

    public function __construct(AssemblymanRepository $assemblymanRepo)
    {
        $this->assemblymanRepository = $assemblymanRepo;

        static::$uploadService = new StorageService();
    }

    /**
     * Display a listing of the Assemblyman.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('assemblymen.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $assemblymen = $this->assemblymanRepository->newQuery()->orderBy('short_name', 'ASC')->get()
            ->load('legislature_assemblyman')
            ->load('party_assemblyman')
            ->load('responsibility_assemblyman');

        foreach ($assemblymen as $assemblyman) {
            $assemblyman->party_last = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)
                ->orderBy('date', 'DESC')
                ->first();

            $assemblyman->responsibility_last = ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman->id)
                ->orderBy('date', 'DESC')
                ->first();

            $assemblyman->legislature_last = DB::table('legislature_assemblymen')
                ->where('assemblyman_id', $assemblyman->id)
                ->join('legislatures', 'legislatures.id', '=', 'legislature_assemblymen.legislature_id')
                ->orderBy('legislatures.from', 'DESC')
                ->select('from', 'to')
                ->first();
        }

        $parties = Party::pluck('name', 'id')->prepend('Selecione..', '');
        $responsibilities = Responsibility::pluck('name', 'id')->prepend('Selecione..', '');

        $legislatures = Legislature::all();
        $selectLegislature = ['' => 'Selecione...'];
        foreach ($legislatures as $legislature) {
            $selectLegislature[$legislature->id] = $legislature->from.' - '.$legislature->to;
        }

        return view('assemblymen.index')
            ->with('assemblymen', $assemblymen)
            ->with('parties', $parties)
            ->with('legislatures', $selectLegislature)
            ->with('responsibilities', $responsibilities);
    }

    /**
     * Show the form for creating a new Assemblyman.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('assemblymen.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $states = $this->statesList();
        $state = State::find(12);
        $cities = City::where('state', '=', $state->uf)->pluck('name', 'id');

        $legislatures = Legislature::all();
        $selectLegislature = ['' => 'Selecione...'];
        foreach ($legislatures as $legislature) {
            $selectLegislature[$legislature->id] = $legislature->from.' - '.$legislature->to;
        }

        $parties = Party::pluck('prefix', 'id')->prepend('Selecione..', '');

        $responsibility = Responsibility::pluck('name', 'id')->prepend('Selecione..', '');

        return view(
            'assemblymen.create',
            compact('states', 'cities', 'selectLegislature', 'parties', 'responsibility')
        );
    }

    /**
     * Store a newly created Parlamentar in storage.
     *
     * @param CreateAssemblymanRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateAssemblymanRequest $request)
    {
        if (! Defender::hasPermission('assemblymen.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();

        $assemblyman = $this->assemblymanRepository->create($input);

        $image = $request->file('image');

        if ($image) {
            $filename = static::$uploadService
                ->inAssemblymanFolder()
                ->sendFile($image)
                ->send();

            $assemblyman->image = $filename;
            $assemblyman->save();
        }
        if (! empty($input['legislature_id'])) {
            $legislature_assemblyman = new LegislatureAssemblyman();
            $legislature_assemblyman->assemblyman_id = $assemblyman->id;
            $legislature_assemblyman->legislature_id = $input['legislature_id'];
            $legislature_assemblyman->save();
        }

        if (! empty($input['party_id'])) {
            $party_assemblyman = new PartiesAssemblyman();
            $party_assemblyman->assemblyman_id = $assemblyman->id;
            $party_assemblyman->date = $input['party_date'];
            $party_assemblyman->party_id = $input['party_id'];
            $party_assemblyman->save();
        }

        if (! empty($input['responsibility_id'])) {
            $responsibility_assemblyman = new ResponsibilityAssemblyman();
            $responsibility_assemblyman->assemblyman_id = $assemblyman->id;
            $responsibility_assemblyman->date = $input['responsibility_date'];
            $responsibility_assemblyman->responsibility_id = $input['responsibility_id'];
            $responsibility_assemblyman->save();
        }

        flash('Parlamentar salvo com sucesso.')->success();

        return redirect(route('assemblymen.index'));
    }

    /**
     * Display the specified Assemblyman.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('assemblymen.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $assemblyman = $this->assemblymanRepository->findByID($id);

        if (empty($assemblyman)) {
            flash('Parlamentar não encontrado')->error();

            return redirect(route('assemblymen.index'));
        }

        return view('assemblymen.show')->with('assemblyman', $assemblyman);
    }

    /**
     * Show the form for editing the specified Assemblyman.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('assemblymen.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $assemblyman = $this->assemblymanRepository
            ->findByID($id)
            ->load('legislature_assemblyman')
            ->load('party_assemblyman')
            ->load('responsibility_assemblyman');

        if (empty($assemblyman)) {
            flash('Parlamentar não encontrado')->error();

            return redirect(route('assemblymen.index'));
        }

        $assemblyman->legislature_id = LegislatureAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->legislature_id;
        $assemblyman->party_id = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->party_id;
        $assemblyman->party_date = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->date;
        $assemblyman->responsibility_id = ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->responsibility_id;
        $assemblyman->responsibility_date = ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->date;

        $states = $this->statesList();
        $state = State::find($assemblyman->state_id);
        $cities = City::where('state', '=', $state->uf)->pluck('name', 'id');

        $legislatures = Legislature::all();
        $selectLegislature = ['' => 'Selecione...'];
        foreach ($legislatures as $legislature) {
            $selectLegislature[$legislature->id] = $legislature->from.' - '.$legislature->to;
        }

        $parties = Party::pluck('prefix', 'id')->prepend('Selecione..', '');

        $responsibility = Responsibility::pluck('name', 'id')->prepend('Selecione..', '');

        return view(
            'assemblymen.edit',
            compact('states', 'cities', 'selectLegislature', 'parties', 'responsibility')
        )
            ->with('assemblyman', $assemblyman);
    }

    /**
     * Update the specified Parlamentar in storage.
     *
     * @param int $id
     * @param UpdateAssemblymanRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateAssemblymanRequest $request)
    {
        if (! Defender::hasPermission('assemblymen.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $assemblyman = $this->assemblymanRepository->findByID($id);

        if (empty($assemblyman)) {
            flash('Parlamentar não encontrado')->error();

            return redirect(route('assemblymen.index'));
        }

        $this->assemblymanRepository->update($assemblyman, $request->all());

        $assemblyman = $this->assemblymanRepository->findByID($id);

        $params = \Illuminate\Support\Facades\Request::all();

        $image = $request->file('image');

        if ($image) {
            $filename = static::$uploadService
                ->inAssemblymanFolder()
                ->sendFile($image)
                ->send();

            $assemblyman->image = $filename;
            $assemblyman->save();
        }

        if (! empty($params['legislature_id'])) {
            $legislature = LegislatureAssemblyman::where('assemblyman_id', $id)->orderBy('created_at', 'desc')->first();
            $legislature->assemblyman_id = $id;
            $legislature->legislature_id = $params['legislature_id'];
            $legislature->save();
        }

        if (! empty($params['party_id'])) {
            $party = PartiesAssemblyman::where('assemblyman_id', $id)->orderBy('created_at', 'desc')->first();
            $party->date = $params['party_date'];
            $party->party_id = $params['party_id'];
            $party->save();
        }

        if (! empty($params['responsibility_id'])) {
            $responsibility = ResponsibilityAssemblyman::where('assemblyman_id', $id)->orderBy('created_at', 'desc')->first();
            $responsibility->date = $params['responsibility_date'];
            $responsibility->responsibility_id = $params['responsibility_id'];
            $responsibility->save();
        }

        flash('Parlamentar atualizado com sucesso.')->success();

        return redirect(route('assemblymen.index'));
    }

    /**
     * Remove the specified Parlamentar from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('assemblymen.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $assemblyman = $this->assemblymanRepository->findByID($id);

        if (empty($assemblyman)) {
            flash('Parlamentar não encontrado')->error();

            return redirect(route('assemblymen.index'));
        }

        $this->assemblymanRepository->delete($assemblyman);

        flash('Parlamentar removido com sucesso.')->success();

        return redirect(route('assemblymen.index'));
    }

    /**
     * Update status of specified Parlamentar from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('assemblymen.edit')) {
            return json_encode(false);
        }
        $register = $this->assemblymanRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function delimage($id)
    {
        if ($register = Assemblyman::find($id)) {
            $register->image = null;
            $register->save();

            return json_encode(true);
        }

        return json_encode(false);
    }

    public function listLegislatures($assemblyman_id)
    {
        return DB::table('legislature_assemblymen')
            ->where('assemblyman_id', $assemblyman_id)
            ->join('legislatures', 'legislatures.id', '=', 'legislature_assemblymen.legislature_id')
            ->orderBy('legislatures.from', 'desc')
            ->get();
    }

    public function listParties($assemblyman_id)
    {
        return PartiesAssemblyman::where('assemblyman_id', $assemblyman_id)
            ->orderBy('date', 'DESC')
            ->get()
            ->load('party');
    }

    public function listResponsibilities($assemblyman_id)
    {
        return ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman_id)
            ->orderBy('date', 'DESC')
            ->get()
            ->load('responsibility');
    }

    public function addLegislatures()
    {
        $params = \Illuminate\Support\Facades\Request::all();
        $legislature_assemblyman = new LegislatureAssemblyman();
        $legislature_assemblyman->legislature_id = $params['legislature_id'];
        $legislature_assemblyman->assemblyman_id = $params['assemblyman_id'];

        if ($legislature_assemblyman->save()) {
            flash('Legislatura inserida com sucesso.')->success();

            return redirect(route('assemblymen.index'));
        } else {
            flash('Legislatura não inserida, favor tentar novamente.')->success();

            return redirect(route('assemblymen.index'));
        }
    }

    public function addParties()
    {
        $params = \Illuminate\Support\Facades\Request::all();
        $party_assemblyman = new PartiesAssemblyman();
        $party_assemblyman->party_id = $params['party_id'];
        $party_assemblyman->date = $params['party_date'];
        $party_assemblyman->assemblyman_id = $params['assemblyman_id'];

        if ($party_assemblyman->save()) {
            flash('Partido inserido com sucesso.')->success();

            return redirect(route('assemblymen.index'));
        } else {
            flash('Partido não inserido, favor tentar novamente.')->success();

            return redirect(route('assemblymen.index'));
        }
    }

    public function addResponsibilities()
    {
        $params = \Illuminate\Support\Facades\Request::all();
        $responsibility_assemblyman = new ResponsibilityAssemblyman();
        $responsibility_assemblyman->responsibility_id = $params['responsibility_id'];
        $responsibility_assemblyman->date = $params['responsibility_date'];
        $responsibility_assemblyman->assemblyman_id = $params['assemblyman_id'];

        if ($responsibility_assemblyman->save()) {
            flash('Responsabilidade inserida com sucesso.')->success();

            return redirect(route('assemblymen.index'));
        } else {
            flash('Responsabilidade não inserida, favor tentar novamente.')->success();

            return redirect(route('assemblymen.index'));
        }
    }

    public function removeParties($party_id, $assemblyman_id)
    {
        DB::delete('delete from parties_assemblymen where assemblyman_id = '.$assemblyman_id.' AND party_id = '.$party_id);

        return ['data' => 'success'];
    }

    public function removeResponsibilities($responsibility_id, $assemblyman_id)
    {
        DB::delete('delete from responsibility_assemblymen where assemblyman_id = '.$assemblyman_id.' AND responsibility_id = '.$responsibility_id);

        return ['data' => 'success'];
    }

    public function removeLegislatures($legislature_id, $assemblyman_id)
    {
        DB::delete('delete from legislature_assemblymen where assemblyman_id = '.$assemblyman_id.' AND legislature_id = '.$legislature_id);

        return ['data' => 'success'];
    }
}
