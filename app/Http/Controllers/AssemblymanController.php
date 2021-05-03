<?php

namespace App\Http\Controllers;

use App\Http\Requests;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Input;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;
use Intervention\Image\Facades\Image;

class AssemblymanController extends AppBaseController
{
    /** @var  AssemblymanRepository */
    private $assemblymanRepository;

    public function __construct(AssemblymanRepository $assemblymanRepo)
    {
        $this->assemblymanRepository = $assemblymanRepo;
    }

    /**
     * Display a listing of the Assemblyman.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('assemblymen.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->assemblymanRepository->pushCriteria(new RequestCriteria($request));

        $assemblymen = $this->assemblymanRepository->orderBy('short_name', 'ASC')->all()
            ->load('legislature_assemblyman')
            ->load('party_assemblyman')
            ->load('responsibility_assemblyman');

        foreach($assemblymen as $assemblyman){
            $assemblyman->party_last = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)
                ->orderBy('date', 'DESC')
                ->first();

            $assemblyman->responsibility_last = ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman->id)
                ->orderBy('date', 'DESC')
                ->first();

            $assemblyman->legislature_last = DB::table("legislature_assemblymen")
                ->where('assemblyman_id', $assemblyman->id)
                ->join('legislatures', 'legislatures.id', '=', 'legislature_assemblymen.legislature_id')
                ->orderBy('legislatures.from', 'DESC')
                ->select('from', 'to')
                ->first();
        }

        $parties = Party::lists('name', 'id')->prepend('Selecione..','');
        $responsibilities = Responsibility::lists('name', 'id')->prepend('Selecione..','');

        $legislatures = Legislature::all();
        $selectLegislature = ['' => 'Selecione...'];
        foreach($legislatures as $legislature)
        {
            $selectLegislature[$legislature->id] = $legislature->from .' - '. $legislature->to;
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
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('assemblymen.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $states = $this->statesList();
        $cities = City::where('state', '=', $states[1])->lists('name', 'id');

        $legislatures = Legislature::all();
        $selectLegislature = ['' => 'Selecione...'];
        foreach($legislatures as $legislature)
        {
            $selectLegislature[$legislature->id] = $legislature->from .' - '. $legislature->to;
        }

        $parties = Party::lists('prefix', 'id')->prepend('Selecione..','');

        $responsibility = Responsibility::lists('name', 'id')->prepend('Selecione..','');

        return view('assemblymen.create',
            compact('states','cities','selectLegislature','parties','responsibility')
        );
    }

    /**
     * Store a newly created Assemblyman in storage.
     *
     * @param CreateAssemblymanRequest $request
     *
     * @return Response
     */
    public function store(CreateAssemblymanRequest $request)
    {
       if(!Defender::hasPermission('assemblymen.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $assemblyman = $this->assemblymanRepository->create($input);
        if(is_file($request->file('image'))){
            $path       = '/uploads/assemblyman/';
            $pathFull   = base_path()."/public".$path;
            $this->checkPath($pathFull);

            $name = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $image = Image::make($request->file('image'));
            $image->resize(400, null, function ($constraint) {$constraint->aspectRatio();});

            if($image->save($pathFull.$name))
            {
                $assemblyman->image =  $path.$name;
                $assemblyman->save();
            }

        }
        if(!empty($input['legislature_id'])){
            $legislature_assemblyman = new LegislatureAssemblyman();
            $legislature_assemblyman->assemblyman_id = $assemblyman->id;
            $legislature_assemblyman->legislature_id = $input['legislature_id'];
            $legislature_assemblyman->save();
        }

        if(!empty($input['party_id'])){
            $party_assemblyman = new PartiesAssemblyman();
            $party_assemblyman->assemblyman_id = $assemblyman->id;
            $party_assemblyman->date = $input['party_date'];
            $party_assemblyman->party_id = $input['party_id'];
            $party_assemblyman->save();
        }

        if(!empty($input['responsibility_id'])){
            $responsibility_assemblyman = new ResponsibilityAssemblyman();
            $responsibility_assemblyman->assemblyman_id = $assemblyman->id;
            $responsibility_assemblyman->date = $input['responsibility_date'];
            $responsibility_assemblyman->responsibility_id = $input['responsibility_id'];
            $responsibility_assemblyman->save();
        }

        Flash::success('Assemblyman saved successfully.');

        return redirect(route('assemblymen.index'));
    }

    /**
     * Display the specified Assemblyman.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('assemblymen.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $assemblyman = $this->assemblymanRepository->findWithoutFail($id);

        if (empty($assemblyman)) {
            Flash::error('Assemblyman not found');

            return redirect(route('assemblymen.index'));
        }

        return view('assemblymen.show')->with('assemblyman', $assemblyman);
    }

    /**
     * Show the form for editing the specified Assemblyman.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('assemblymen.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $assemblyman = $this->assemblymanRepository
            ->findWithoutFail($id)
            ->load('legislature_assemblyman')
            ->load('party_assemblyman')
            ->load('responsibility_assemblyman');

        if (empty($assemblyman)) {
            Flash::error('Assemblyman not found');

            return redirect(route('assemblymen.index'));
        }

        $assemblyman->legislature_id = LegislatureAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->legislature_id;
        $assemblyman->party_id = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->party_id;
        $assemblyman->party_date = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->date;
        $assemblyman->responsibility_id = ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->responsibility_id;
        $assemblyman->responsibility_date = ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('created_at', 'desc')->first()->date;

        $states = $this->statesList();
        $state = State::find($assemblyman->state_id);
        $cities = City::where('state', '=', $state->uf)->lists('name', 'id');

        $legislatures = Legislature::all();
        $selectLegislature = ['' => 'Selecione...'];
        foreach($legislatures as $legislature)
        {
            $selectLegislature[$legislature->id] = $legislature->from .' - '. $legislature->to;
        }

        $parties = Party::lists('prefix', 'id')->prepend('Selecione..','');

        $responsibility = Responsibility::lists('name', 'id')->prepend('Selecione..','');

        return view('assemblymen.edit',
            compact('states','cities','selectLegislature','parties','responsibility'))
            ->with('assemblyman', $assemblyman);
    }

    /**
     * Update the specified Assemblyman in storage.
     *
     * @param  int              $id
     * @param UpdateAssemblymanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAssemblymanRequest $request)
    {
        if(!Defender::hasPermission('assemblymen.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $assemblyman = $this->assemblymanRepository->findWithoutFail($id);

        if (empty($assemblyman)) {
            Flash::error('Assemblyman not found');

            return redirect(route('assemblymen.index'));
        }

        $assemblyman = $this->assemblymanRepository->update($request->all(), $id);
        $assemblyman = $this->assemblymanRepository->findWithoutFail($id);

        $params = Input::all();
        if(is_file($request->file('image'))){
            $path       = '/uploads/assemblyman/';
            $pathFull   = base_path()."/public".$path;
            $this->checkPath($pathFull);

            $name = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $image = Image::make($request->file('image'));
            $image->resize(400, null, function ($constraint) {$constraint->aspectRatio();});

            if($image->save($pathFull.$name))
            {
                $assemblyman->image =  $path.$name;
                $assemblyman->save();
            }
        }

        if(!empty($params['legislature_id'])){
            $legislature = LegislatureAssemblyman::where('assemblyman_id', $id)->orderBy('created_at', 'desc')->first();
            $legislature->assemblyman_id = $id;
            $legislature->legislature_id = $params['legislature_id'];
            $legislature->save();
        }

        if(!empty($params['party_id'])){
            $party = PartiesAssemblyman::where('assemblyman_id', $id)->orderBy('created_at', 'desc')->first();
            $party->date = $params['party_date'];
            $party->party_id = $params['party_id'];
            $party->save();
        }

        if(!empty($params['responsibility_id'])){
            $responsibility = ResponsibilityAssemblyman::where('assemblyman_id', $id)->orderBy('created_at', 'desc')->first();
            $responsibility->date = $params['responsibility_date'];
            $responsibility->responsibility_id = $params['responsibility_id'];
            $responsibility->save();
        }

        Flash::success('Assemblyman updated successfully.');

        return redirect(route('assemblymen.index'));
    }

    /**
     * Remove the specified Assemblyman from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('assemblymen.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $assemblyman = $this->assemblymanRepository->findWithoutFail($id);

        if (empty($assemblyman)) {
            Flash::error('Assemblyman not found');

            return redirect(route('assemblymen.index'));
        }

        $this->assemblymanRepository->delete($id);

        Flash::success('Assemblyman deleted successfully.');

        return redirect(route('assemblymen.index'));
    }

    /**
     * Update status of specified Assemblyman from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id){
        if(!Defender::hasPermission('assemblymen.edit'))
        {
            return json_encode(false);
        }
        $register = $this->assemblymanRepository->findWithoutFail($id);
        $register->active = $register->active>0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }

    public function delimage($id){
        $path       = '/uploads/assemblyman/';
        $register   = Assemblyman::find($id);
        if(unlink(base_path()."/public".$register->image)){
            $register->image=null;
            $register->save();
            return json_encode(true);
        }else{
            return json_encode(false);
        }
    }

    public function listLegislatures($assemblyman_id){

        return DB::table("legislature_assemblymen")
            ->where('assemblyman_id', $assemblyman_id)
            ->join('legislatures', 'legislatures.id', '=', 'legislature_assemblymen.legislature_id')
            ->orderBy('legislatures.from', 'desc')
            ->get();
    }

    public function listParties($assemblyman_id){
        return PartiesAssemblyman::where('assemblyman_id', $assemblyman_id)
            ->orderBy('date', 'DESC')
            ->get()
            ->load('party');
    }

    public function listResponsibilities($assemblyman_id){
        return ResponsibilityAssemblyman::where('assemblyman_id', $assemblyman_id)
            ->orderBy('date', 'DESC')
            ->get()
            ->load('responsibility');
    }

    public function addLegislatures(){
        $params = Input::all();
        $legislature_assemblyman = new LegislatureAssemblyman();
        $legislature_assemblyman->legislature_id = $params['legislature_id'];
        $legislature_assemblyman->assemblyman_id = $params['assemblyman_id'];

        if($legislature_assemblyman->save()){
            Flash::success('Legislatura inserida com sucesso.');
            return redirect(route('assemblymen.index'));
        } else {
            Flash::success('Legislatura não inserida, favor tentar novamente.');
            return redirect(route('assemblymen.index'));
        }
    }

    public function addParties(){
        $params = Input::all();
        $party_assemblyman = new PartiesAssemblyman();
        $party_assemblyman->party_id = $params['party_id'];
        $party_assemblyman->date = $params['party_date'];
        $party_assemblyman->assemblyman_id = $params['assemblyman_id'];

        if($party_assemblyman->save()){
            Flash::success('Partido inserido com sucesso.');
            return redirect(route('assemblymen.index'));
        }else{
            Flash::success('Partido não inserido, favor tentar novamente.');
            return redirect(route('assemblymen.index'));
        }
    }

    public function addResponsibilities(){
        $params = Input::all();
        $responsibility_assemblyman = new ResponsibilityAssemblyman();
        $responsibility_assemblyman->responsibility_id = $params['responsibility_id'];
        $responsibility_assemblyman->date = $params['responsibility_date'];
        $responsibility_assemblyman->assemblyman_id = $params['assemblyman_id'];

        if($responsibility_assemblyman->save()){
            Flash::success('Responsabilidade inserida com sucesso.');
            return redirect(route('assemblymen.index'));
        }else{
            Flash::success('Responsabilidade não inserida, favor tentar novamente.');
            return redirect(route('assemblymen.index'));
        }
    }

    public function removeParties($party_id, $assemblyman_id){

        $party_assemblyman = DB::delete('delete from parties_assemblymen where assemblyman_id = '. $assemblyman_id .' AND party_id = '. $party_id);

        return ['data' => 'success'];
    }

    public function removeResponsibilities($responsibility_id, $assemblyman_id){

        $responsibility_assemblyman = DB::delete('delete from responsibility_assemblymen where assemblyman_id = '. $assemblyman_id .' AND responsibility_id = '. $responsibility_id);

        return ['data' => 'success'];
    }

    public function removeLegislatures($legislature_id, $assemblyman_id){

        $legislature_assemblyman = DB::delete('delete from legislature_assemblymen where assemblyman_id = '. $assemblyman_id .' AND legislature_id = '. $legislature_id);

        return ['data' => 'success'];
    }


}
