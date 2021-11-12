<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Libraries\Repositories\RoleRepository;
use App\Models\Permission;
use Artesaos\Defender\Facades\Defender;
use Flash;
use Response;

class RoleController extends AppBaseController
{

	/** @var  RoleRepository */
	private $roleRepository;

	function __construct(RoleRepository $roleRepo)
	{
		$this->roleRepository = $roleRepo;
	}

	/**
	 * Display a listing of the Role.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = $this->roleRepository->paginate(10);

		return view('roles.index')
			->with('roles', $roles);
	}

	/**
	 * Show the form for creating a new Role.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('roles.create');
	}

	/**
	 * Store a newly created Role in storage.
	 *
	 * @param CreateRoleRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateRoleRequest $request)
	{
		$input = $request->all();

		$role = $this->roleRepository->create($input);

		flash('Registro salvo com sucesso!')->success();

		return redirect(route('gerencial.roles.index'));
	}

	/**
	 * Display the specified Role.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$role = $this->roleRepository->find($id);

		if(empty($role))
		{
			flash('Registro não existe.')->error();

			return redirect(route('gerencial.roles.index'));
		}

		return view('roles.show')->with('role', $role);
	}

	/**
	 * Show the form for editing the specified Role.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$role = $this->roleRepository->find($id);

		if(empty($role))
		{
			flash('Registro não existe.')->error();

			return redirect(route('gerencial.roles.index'));
		}

		return view('roles.edit')->with('role', $role);
	}

	/**
	 * Update the specified Role in storage.
	 *
	 * @param  int              $id
	 * @param UpdateRoleRequest $request
	 *
	 * @return Response
	 */
	public function update($id, UpdateRoleRequest $request)
	{
		$role = $this->roleRepository->find($id);

		if(empty($role))
		{
			flash('Registro não existe.')->error();

			return redirect(route('gerencial.roles.index'));
		}

		$role = $this->roleRepository->updateRich($request->all(), $id);

		flash('Registro editado com sucesso!')->success();

		return redirect(route('gerencial.roles.index'));
	}

	/**
	 * Remove the specified Role from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$role = $this->roleRepository->find($id);

		if(empty($role))
		{
			flash('Registro não existe.')->error();

			return redirect(route('gerencial.roles.index'));
		}

		$this->roleRepository->delete($id);

		flash('Registro deletado com sucesso!')->success();

		return redirect(route('gerencial.roles.index'));
	}

    /**
	 * Update status of specified Role from storage.
	 *
	 * @param  int $id
	 *
	 * @return Json
	 */
	public function toggle($id){
            $register = $this->roleRepository->find($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }


    /**
     * @param $id
     * @return $this
     */
    public function permission($id){
        $roles  = Defender::findRoleById($id);
        $perms  = Permission::all();
        $list   = $this->getNameOfPermissions();
        return view('roles.permission',compact('roles','perms','list'));
    }

    /**
     * @return array
     */

    public function getNameOfPermissions(){
        $arr = array();
        $tmp = '';
        $perms  = Permission::all();
        foreach($perms as $value){
            $tmp2 = explode(".",$value->name);
            if($tmp != $tmp2[0]){
                $tmp = $tmp2[0];
                $arr[] = $tmp;
            }
        }
        return $arr;
    }

    public function togglePermission($role,$permission)
    {

        $role = Defender::findRole($role);
        $perm = Defender::findPermissionById($permission);


        $has = $this->checkPermission($role,$perm);
        $has ? $role->detachPermission($perm) : $role->attachPermission($perm);

        return json_encode(true);
    }

    public function checkPermission($role,$perm){
        foreach($role->permissions as $value2){
            if($value2->name==$perm->name)
                return true;
        }
        return false;
    }
}
