<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Libraries\Repositories\ProfileRepository;
use App\Libraries\Repositories\UserRepository;
use App\Models\Assemblyman;
use App\Models\Log;
use App\Models\Role;
use App\Models\Sector;
use App\Models\User;
use App\Models\UserAssemblyman;
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
        $register->save();

        return json_encode(true);
    }

    public function auditing($id)
    {
        $translation = [
            'DOCUMENT' => 'DOCUMENTO',
            'LAWSPROJECT' => 'PROJETO DE LEI',
            'DOCUMENTNUMBER' => 'NÚMERO DO DUCUMENTO',
            'COMMISSIONASSEMBLYMAN' => 'ASSEMBLÉIA DA COMISSÃO',
            'ADVICESITUATION' => 'SITUAÇÃO DE CONSELHOS',
            'ADVICEAWNSER' => 'RESPOSTA DE CONSELHOS',
            'ADVICE' => 'CONSELHO',
            'MEETINGPAUTA' => 'ENCONTRO PAUTA',
            'PROCESSING' => 'EM PROCESSAMENTO',
            'DESTINATION' => 'DESTINO',
            'LAWSPROJECTASSEMBLYMAN' => 'ASSEMBLÉIA DE PROJETOS DE LEIS',
            'LAWPROJECTSNUMBER' => 'NÚMERO DE PROJETOS DE LEI',
            'STATUSPROCESSINGLAW' => 'LEI DE PROCESSAMENTO DE STATUS',
            'ADVICESITUATIONLAW' => 'LEI DE SITUAÇÃO DE CONSELHOS',
            'LAWFILE' => 'ARQUIVO DE LEI',
            'PROCESSINGDOCUMENT' => 'PROCESSANDO DOCUMENTO',
            'DOCUMENTSITUATION' => 'SITUAÇÃO DO DOCUMENTO',
            'MEETING' => 'ENCONTRO',
            'DOCUMENTMODELS' => 'MODELOS DE DOCUMENTOS',
            'DOCUMENTPROTOCOL' => 'PROTOCOLO DO DOCUMENTO',
            'PARAMETERS' => 'PARÂMETROS',
            'PERMISSION' => 'PERMISSÃO',
            'USERASSEMBLYMAN' => 'ASSEMBLYMAN DO USUÁRIO',
            'LAWSITUATION' => 'SITUAÇÃO DA LEI',
            'DOCUMENTTYPE' => 'TIPO DE DOCUMENTO',
            'LEGISLATUREASSEMBLYMAN' => 'LEGISLATURA',
            'PARTIESASSEMBLYMAN' => 'PARTIDOS',
            'RESPONSIBILITYASSEMBLYMAN' => 'RESPONSABILIDADE',
            'RESPONSIBILITY' => 'RESPONSABILIDADE',
            'PEOPLE' => 'PESSOA',
            'ATTENDANCE' => 'ATENDIMENTO',
            'USER' => 'USUÁRIO',
            'ASSEMBLYMAN' => 'PARLAMENTAR',
            'SECTOR' => 'SETOR',
            'PARTY' => 'PARTIDOS',
            'LEGISLATURE' => 'LEGISLATURA',
            'ADVICEPUBLICATIONDOCUMENTS' => 'PUBLICAÇÃO DO PARECER DO DOCUMENTO',
            'ADVICESITUATIONDOCUMENTS' => 'SITUAÇÃO DO PARECER DO DOCUMENTO',
            'STATUSPROCESSINGDOCUMENT' => 'STATUS DO TRAMITE',
            'COMISSIONSITUATION' => 'SITUAÇÃO DA COMISSÃO',
            'OFFICECOMMISSION' => 'CARGO DE COMISSÃO',
            'COMMISSION' => 'COMISSÃO',
            'TYPEVOTING' => 'TIPO DE VOTAÇÃO',
            'SESSIONTYPE' => 'TIPO DE SESSÕES',
            'VERSIONPAUTA' => 'ESTRUTURA DA PAUTA',
            'LAWSPLACE' => 'LOCAL DE PUBLICAÇÃO',
            'LAWSSTRUCTURE' => 'TIPO DE ESTRUTURA DE LEI',
            'LAWSTAG' => 'TAG DE LEI',
            'LAWSTYPE' => 'TIPOS DE LEI',
            'ADVICEPUBLICATIONLAW' => 'PUBLICAÇÃO DO PARECER DE LEI',
            'TYPESOFATTENDANCE' => 'TIPO DE ATENDIMENTO',
            'ROLE' => 'GRUPO DE PERMISSÕES',
            'document_id' => 'Id do Documento',
            'remember_token' => 'Tokem',
            'rg' => 'RG',
            'laws_project_id' => 'Referente à',
            'is_read' => 'Lido',
            'anonymous' => 'Anônima',
            'text_initial' => 'Texto Inicial',
            'approved' => 'Aprovado',
            'read' => 'Lido',
            'from' => 'De',
            'to' => 'Até',
            'prefix' => 'Sigla',
            'skip_board' => 'Ignora Mesa',
            'order' => 'Ordem',
            'external' => 'Externo',
            'document_type_id' => 'Tipo de Documento',
            'owner_id' => 'Setor',
            'date' => 'Data',
            'sector_id' => 'Setor',
            'resume' => 'Ementa',
            'content' => 'Conteúdo',
            'users_id' => 'Usuário',
            'law_date' => 'Data projeto',
            'law_type_id' => 'Tipo de le',
            'reference_id' => 'Referente à',
            'situation_id' => 'Situação Atual',
            'date_presentation' => 'Data da Apresentação',
            'comission_id' => 'Comissão',
            'assemblyman_id' => 'Responsável',
            'title' => 'Ementa',
            'sub_title' => ' Texto PREFIXO',
            'sufix' => 'Texto SUFIXO',
            'justify' => 'Texto JUSTIFICATIVA',
            'town_hall' => 'Prefeitura',
            'time' => 'Horário',
            'description' => 'Descrição',
            'type_id' => 'Id do Tipo',
            'people_id' => 'Id da Pessoa',
            'cpf' => 'CPF',
            'name' => 'Nome',
            'email' => 'E-Mail',
            'celular' => 'Celular',
            'telephone' => 'Telefone',
            'zipcode' => 'CEP',
            'street' => 'Rua',
            'number' => 'Número',
            'complement' => 'Complemento',
            'district' => 'Bairro',
            'state_id' => 'Id do Estado',
            'city_id' => 'Id da Cidade',
            'office' => 'Escritório',
            'start_date' => 'Data de Início',
            'end_date' => 'Data de Fim',
            'commission_id' => 'Id da Comissão',
            'advice_id' => 'Id da Situação',
            'comission_situation_id' => 'Id da Situação da Comissão',
            'file' => 'Arquivo',
            'filename' => 'Nome do Arquivo',
            'type' => 'Tipo',
            'to_id' => 'Para',
            'laws_projects_id' => 'Id da Lei do Projeto',
            'meeting_id' => 'Id da Reunião',
            'structure_id' => 'Id da Estrutura',
            'law_id' => 'Id da Lei',
            'observation' => 'Observação',
            'law_projects_id' => 'Id da Lei do Projeto',
            'advice_publication_id' => 'ID de Publicação de Conselho',
            'advice_situation_id' => 'Id da Situação do Conselho',
            'status_processing_law_id' => 'Id de Lei de Processamento de Status',
            'processing_date' => 'Processando Dados',
            'destination_id' => 'Id de Destino',
            'obsevation' => 'Observação',
            'law_project_id' => 'Id da Lei do Projeto',
            'document_situation_id' => 'Id da Situação do Documento',
            'status_processing_document_id' => 'Id do Status do Documento',
            'processing_document_date' => 'Data do Processo do Documento',
            'session_type_id' => 'id do Tipo de Sessão',
            'session_place_id' => 'id do Local da Sessão',
            'date_start' => 'Data Inicio',
            'date_end' => 'Data Final',
            'version_pauta_id' => 'Id da Estrutura da Pauta',
            'protocol_type_id' => 'Id do Tipo do Protocolo',
            'slug' => 'Slug',
            'value' => 'Valor',
            'readable_name' => 'Nome Legível',
            'phone1' => 'Celular',
            'phone2' => 'Telefone',
            'official_document' => 'Documento Oficial',
            'general_register' => 'Registro Geral',
            'parent_id' => 'Id dos Pais',
            'active' => 'Ativo',
            'company_id' => 'ID da Empresa',
            'password' => 'Senha',
            'image' => 'Imagem',
            'legislature_id' => 'Id da Legislatura',
            'party_id' => 'Id do Partido',
            'responsibility_id' => 'Id da Responsabilidade',
            'companies_id' => 'Id do Setor',
            'short_name' => 'Nome Curto',
            'full_name' => 'Nome Completo',
            'id' => 'Id',
        ];

        $user = User::find($id);
        $logs = Log::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(20);

        return view('users.auditing', compact('user', 'logs', 'translation'));
    }
}
