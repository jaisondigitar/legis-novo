<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\PartiesAssemblymanAPIController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Libraries\Repositories\ProfileRepository;
use App\Libraries\Repositories\UserRepository;
use App\Models\Advice;
use App\Models\AdviceAwnser;
use App\Models\AdvicePublicationDocuments;
use App\Models\AdvicePublicationLaw;
use App\Models\AdviceSituation;
use App\Models\AdviceSituationDocuments;
use App\Models\AdviceSituationLaw;
use App\Models\Assemblyman;
use App\Models\Attendance;
use App\Models\ComissionSituation;
use App\Models\Commission;
use App\Models\Destination;
use App\Models\Document;
use App\Models\DocumentAssemblyman;
use App\Models\DocumentFiles;
use App\Models\DocumentModels;
use App\Models\DocumentNumber;
use App\Models\DocumentProtocol;
use App\Models\DocumentSituation;
use App\Models\DocumentType;
use App\Models\LawFile;
use App\Models\LawProjectsNumber;
use App\Models\LawSituation;
use App\Models\LawsPlace;
use App\Models\LawsProject;
use App\Models\LawsProjectAssemblyman;
use App\Models\LawsStructure;
use App\Models\LawsTag;
use App\Models\LawsType;
use App\Models\Legislature;
use App\Models\LegislatureAssemblyman;
use App\Models\Log;
use App\Models\Meeting;
use App\Models\MeetingPauta;
use App\Models\OfficeCommission;
use App\Models\Parameters;
use App\Models\PartiesAssemblyman;
use App\Models\Party;
use App\Models\People;
use App\Models\Permission;
use App\Models\Processing;
use App\Models\ProcessingDocument;
use App\Models\Responsibility;
use App\Models\ResponsibilityAssemblyman;
use App\Models\Role;
use App\Models\Sector;
use App\Models\SessionType;
use App\Models\StatusProcessingDocument;
use App\Models\StatusProcessingLaw;
use App\Models\TypesOfAttendance;
use App\Models\TypeVoting;
use App\Models\User;
use App\Models\UserAssemblyman;
use App\Models\VersionPauta;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends AppBaseController
{
    /** @var UserRepository */
    private $userRepository;
    private $profileRepository;

    public function __construct(UserRepository $userRepo, ProfileRepository $profileRepo)
    {
        $this->userRepository = $userRepo;
        $this->profileRepository = $profileRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function index()
    {
        if (! Defender::hasPermission('users.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $users = User::where('company_id', '=', Auth::user()->company->id)
            ->paginate(20);

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('users.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        if (Defender::hasRole('root')) {
            $levels = Role::all();
        } else {
            $levels = Role::where('name', '!=', 'root')->get();
        }

        $sectors = Sector::pluck('name', 'id')->prepend('Selecione...', '');
        $assemblyman = Assemblyman::where('active', 1)->get();

        $user_assemblyman = [];

        return view('users.create', compact('levels'), compact('sectors'))
            ->with('user_assemblyman', $user_assemblyman)
            ->with('assemblyman', $assemblyman);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateUserRequest $request)
    {
        if (! Defender::hasPermission('users.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $validated = $request->validated();

        $user = $this->userRepository->create($validated);

        $user->password = bcrypt($request->password);
        $user->active = isset($request->active) ? 1 : 0;
        $user->legal = isset($request->legal) ? 1 : 0;
        $user->save();

        $user->syncRoles($validated['roles']);

        $profile = $this->profileRepository->newQuery()->where('user_id', $user->id)->get();

        if (isset($input['assemblyman'])) {
            foreach ($input['assemblyman'] as $item) {
                $user_assemblyman = new UserAssemblyman();
                $user_assemblyman->users_id = $user->id;
                $user_assemblyman->assemblyman_id = $item;
                $user_assemblyman->save();
            }
        }

        if (empty($profile)) {
            $input['user_id'] = $user->id;
            $input['active'] = '1';
            $this->profileRepository->create($input);
        }
        flash('Registro salvo com sucesso!')->success();

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('users.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $user = $this->userRepository->findByID($id);

        if (Defender::hasRole('root')) {
            $levels = Role::all();
        } else {
            $levels = Role::where('name', '!=', 'root')->get();
        }

        $assemblyman = Assemblyman::where('active', 1)->get();

        if (empty($user)) {
            flash('Registro não existe.')->error();

            return redirect(route('users.index'));
        }

        $permCompany = Role::all();

        return view(
            'users.show',
            compact('permCompany', 'levels')
        )
            ->with('user', $user)
            ->with('assemblyman', $assemblyman);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('users.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $user = $this->userRepository->findByID($id);

        if (empty($user)) {
            flash('Registro não existe.')->error();

            return redirect(route('users.index'));
        }

        if (Defender::hasRole('root')) {
            $levels = Role::all();
        } else {
            $levels = Role::where('name', '!=', 'root')->get();
        }

        $sectors = Sector::pluck('name', 'id')->prepend('Selecione...', '');

        $assemblyman = Assemblyman::where('active', 1)->get();

        $user_assemblyman = UserAssemblyman::select('assemblyman_id')->where('users_id', $id)->get();

        $ar_user_assemblyman = [];
        foreach ($user_assemblyman as $item) {
            array_push($ar_user_assemblyman, $item->assemblyman_id);
        }

        return view('users.edit', compact('levels'), compact('sectors'))
            ->with('user', $user)
            ->with('user_assemblyman', $ar_user_assemblyman)
            ->with('assemblyman', $assemblyman);
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        if (! Defender::hasPermission('users.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $user = $this->userRepository->findByID($id);

        $validated = $request->validated();

        if (empty($user)) {
            flash('Registro não existe.')->error();

            return redirect(route('users.index'));
        }

        ! empty($validated['password']) ? $validated['password'] = bcrypt($validated['password']) : $validated['password'] = $user->password;
        $this->userRepository->update($user, $validated);

        $new = $this->userRepository->findByID($id);
        $new->active = isset($request->active) ? 1 : 0;
        $new->legal = isset($request->legal) ? 1 : 0;
        $new->save();

        $this->clearRoles($new, $user);
        $new->syncRoles($validated['roles']);

        if (isset($request['assemblyman'])) {
            DB::delete('delete from user_assemblyman where users_id = '.$user->id);

            foreach ($request['assemblyman'] as $item) {
                $user_assemblyman = new UserAssemblyman();
                $user_assemblyman->users_id = $user->id;
                $user_assemblyman->assemblyman_id = $item;
                $user_assemblyman->save();
            }
        }

        if ($request['sector_id'] != 2) {
            DB::delete('delete from user_assemblyman where users_id = '.$user->id);
        }

        flash('Registro editado com sucesso!')->success();

        return redirect(route('users.index'));
    }

    public function clearRoles($new, $user)
    {
        $ids = [];
        foreach ($new->roles as $reg) {
            $ids[] = $reg->id;
        }
        $user->detachRole($ids);
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('users.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $user = $this->userRepository->findByID($id);

        if (empty($user)) {
            flash('Registro não existe.')->error();

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($user);

        flash('Registro deletado com sucesso!')->success();

        return redirect(route('users.index'));
    }

    /**
     * Update status of specified User from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('users.edit')) {
            return json_encode(false);
        }

        $register = $this->userRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->legal = $register->legal > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function auditing($id)
    {
        $translationNews = [
            'DOCUMENT' => Document::$translation,
            'LAWSPROJECT' => LawsProject::$translation,
            'DOCUMENTNUMBER' => DocumentNumber::$translation,
            'COMMISSIONASSEMBLYMAN' => DocumentAssemblyman::$translation,
            'ADVICESITUATION' => AdviceSituation::$translation,
            'ADVICEAWNSER' => AdviceAwnser::$translation,
            'ADVICE' => Advice::$translation,
            'MEETINGPAUTA' => MeetingPauta::$translation,
            'PROCESSING' => Processing::$translation,
            'DESTINATION' => Destination::$translation,
            'LAWSPROJECTASSEMBLYMAN' => LawsProjectAssemblyman::$translation,
            'LAWPROJECTSNUMBER' => LawProjectsNumber::$translation,
            'STATUSPROCESSINGLAW' => StatusProcessingLaw::$translation,
            'ADVICESITUATIONLAW' => AdviceSituationLaw::$translation,
            'LAWFILE' => LawFile::$translation,
            'PROCESSINGDOCUMENT' => ProcessingDocument::$translation,
            'DOCUMENTSITUATION' => DocumentSituation::$translation,
            'MEETING' => Meeting::$translation,
            'DOCUMENTMODELS' => DocumentModels::$translation,
            'DOCUMENTPROTOCOL' => DocumentProtocol::$translation,
            'PARAMETERS' => Parameters::$translation,
            'PERMISSION' => Permission::$translation,
            'USERASSEMBLYMAN' => UserAssemblyman::$translation,
            'LAWSITUATION' => LawSituation::$translation,
            'DOCUMENTTYPE' => DocumentType::$translation,
            'LEGISLATUREASSEMBLYMAN' => LegislatureAssemblyman::$translation,
            'PARTIESASSEMBLYMAN' => PartiesAssemblyman::$translation,
            'RESPONSIBILITYASSEMBLYMAN' => ResponsibilityAssemblyman::$translation,
            'RESPONSIBILITY' => Responsibility::$translation,
            'PEOPLE' => People::$translation,
            'ATTENDANCE' => Attendance::$translation,
            'USER' => User::$translation,
            'ASSEMBLYMAN' => Assemblyman::$translation,
            'SECTOR' => Sector::$translation,
            'PARTY' => Party::$translation,
            'LEGISLATURE' => Legislature::$translation,
            'ADVICEPUBLICATIONDOCUMENTS' => AdvicePublicationDocuments::$translation,
            'ADVICESITUATIONDOCUMENTS' => AdviceSituationDocuments::$translation,
            'STATUSPROCESSINGDOCUMENT' => StatusProcessingDocument::$translation,
            'COMISSIONSITUATION' => ComissionSituation::$translation,
            'OFFICECOMMISSION' => OfficeCommission::$translation,
            'COMMISSION' => Commission::$translation,
            'TYPEVOTING' => TypeVoting::$translation,
            'SESSIONTYPE' => SessionType::$translation,
            'VERSIONPAUTA' => VersionPauta::$translation,
            'LAWSPLACE' => LawsPlace::$translation,
            'LAWSSTRUCTURE' => LawsStructure::$translation,
            'LAWSTAG' => LawsTag::$translation,
            'LAWSTYPE' => LawsType::$translation,
            'ADVICEPUBLICATIONLAW' => AdvicePublicationLaw::$translation,
            'TYPESOFATTENDANCE' => TypesOfAttendance::$translation,
            'ROLE' => Role::$translation,
            'DOCUMENTFILES' => DocumentFiles::$translation,
        ];

        $user = User::find($id);
        $logs = Log::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(20);

        return view('users.auditing', compact('user', 'logs', 'translationNews'));
    }
}
