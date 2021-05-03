<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Libraries\Repositories\UserRepository;
use App\Libraries\Repositories\ProfileRepository;
use App\Models\Assemblyman;
use App\Models\Log;
use App\Models\Role;
use App\Models\Sector;
use App\Models\User;
use App\Models\UserAssemblyman;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Auth;

class UserController extends AppBaseController
{

	/** @var  UserRepository */
	private $userRepository;
    private $profileRepository;

	function __construct(UserRepository $userRepo,ProfileRepository $profileRepo)
	{
		$this->userRepository = $userRepo;
        $this->profileRepository = $profileRepo;
	}

	/**
	 * Display a listing of the User.
	 *
	 * @return Response
	 */
	public function index()
	{
        if(!Defender::hasPermission('users.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

		$users = User::where('company_id','=',Auth::user()->company->id)
            ->paginate(20);

		return view('users.index')
			->with('users', $users);
	}

	/**
	 * Show the form for creating a new User.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(!Defender::hasPermission('users.create')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        if(Defender::hasRole('root')) {
            $levels = Role::all();
        }else{
            $levels = Role::where('name','!=','root')->get();
        }



        $sectors = Sector::lists('name', 'id')->prepend('Selecione...', '');
        $assemblyman = Assemblyman::where('active', 1)->get();

        $user_assemblyman = [];

        return view('users.create',compact('levels'), compact('sectors'))
            ->with('user_assemblyman', $user_assemblyman)
            ->with('assemblyman', $assemblyman);
	}

	/**
	 * Store a newly created User in storage.
	 *
	 * @param CreateUserRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateUserRequest $request)
	{
        if(!Defender::hasPermission('users.create')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $input = $request->all();

		$user = $this->userRepository->create($input);
        $user->password = bcrypt($request->password);
        $user->active   = isset($request->active) ? 1 : 0;
        $user->save();

        $user->syncRoles($input['roles']);

        $profile = $this->profileRepository->findBy("user_id",$user->id);

        if(isset($input['assemblyman'])){
            foreach ($input['assemblyman'] as $item) {
                $user_assemblyman = new UserAssemblyman();
                $user_assemblyman->users_id = $user->id;
                $user_assemblyman->assemblyman_id = $item;
                $user_assemblyman->save();
            }
        }

        if(empty($profile))
        {
            $input['user_id']   =  $user->id;
            $input['active']    = "1";
            $this->profileRepository->create($input);
        }
		Flash::success('Registro salvo com sucesso!');

		return redirect(route('users.index'));
	}

	/**
	 * Display the specified User.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
        if(!Defender::hasPermission('users.show')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $user = $this->userRepository->find($id);

		if(empty($user))
		{
			Flash::error('Registro não existe.');

			return redirect(route('users.index'));
		}

        $permCompany = Role::all();

		return view('users.show',compact(
            'permissions',
            'permCompany'
        ))->with('user', $user);
	}

	/**
	 * Show the form for editing the specified User.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
        if(!Defender::hasPermission('users.edit')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $user = $this->userRepository->find($id);

		if(empty($user))
		{
			Flash::error('Registro não existe.');

			return redirect(route('users.index'));
		}

        if(Defender::hasRole('root')) {
            $levels = Role::all();
        }else{
            $levels = Role::where('name','!=','root')->get();
        }

        $sectors = Sector::lists('name', 'id')->prepend('Selecione...', '');

		$assemblyman = Assemblyman::where('active', 1)->get();

        $user_assemblyman = UserAssemblyman::select('assemblyman_id')->where('users_id', $id)->get();

        $ar_user_assemblyman = [];
        foreach ($user_assemblyman as $item) {
            array_push($ar_user_assemblyman, $item->assemblyman_id);
        }

		return view('users.edit',compact('levels'), compact('sectors'))
            ->with('user', $user)
            ->with('user_assemblyman', $ar_user_assemblyman)
            ->with('assemblyman', $assemblyman);
	}

	/**
	 * Update the specified User in storage.
	 *
	 * @param  int              $id
	 * @param UpdateUserRequest $request
	 *
	 * @return Response
	 */
	public function update($id, UpdateUserRequest $request)
	{
        if(!Defender::hasPermission('users.edit')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $user = $this->userRepository->find($id);
        $input = $request->all();

		if(empty($user))
		{
			Flash::error('Registro não existe.');

			return redirect(route('users.index'));
		}

        !empty($input['password']) ? $input['password'] = bcrypt($input['password']) : $input['password'] = $user->password;
		$new = $this->userRepository->updateRich($input, $id);

        $new = $this->userRepository->find($id);
        $new->active = isset($request->active) ? 1 : 0;
        $new->save();

        $this->clearRoles($new,$user);
        $new->syncRoles($input['roles']);

        if(isset($request['assemblyman'])){

            $user_assemblyman = DB::delete('delete from user_assemblyman where users_id = ' . $user->id);

            foreach ($request['assemblyman'] as $item) {
                $user_assemblyman = new UserAssemblyman();
                $user_assemblyman->users_id = $user->id;
                $user_assemblyman->assemblyman_id = $item;
                $user_assemblyman->save();
            }
        }

        if($request['sector_id'] != 2){
            $user_assemblyman = DB::delete('delete from user_assemblyman where users_id = ' . $user->id);
        }

		Flash::success('Registro editado com sucesso!');

		return redirect(route('users.index'));
	}


    public function clearRoles($new,$user)
    {
        $ids = array();
        foreach($new->roles as $reg)
        {
            $ids[] = $reg->id;
        }
        $user->detachRole($ids);
    }

	/**
	 * Remove the specified User from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!Defender::hasPermission('users.delete')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $user = $this->userRepository->find($id);

		if(empty($user))
		{
			Flash::error('Registro não existe.');

			return redirect(route('users.index'));
		}

		$this->userRepository->delete($id);

		Flash::success('Registro deletado com sucesso!');

		return redirect(route('users.index'));
	}

    /**
	 * Update status of specified User from storage.
	 *
	 * @param  int $id
	 *
	 * @return Json
	 */
	public function toggle($id){

        if(!Defender::hasPermission('users.edit')) {
            return json_encode(false);
        }

        $register = $this->userRepository->find($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
	}

	public function  auditing($id)
    {
        $user = User::find($id);
        $logs = Log::where('user_id',$id)->orderBy('created_at','desc')->paginate(20);
        return view('users.auditing',compact('user'))->with('logs',$logs);
    }
}
