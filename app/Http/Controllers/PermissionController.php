<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Libraries\Repositories\PermissionRepository;
use App\Models\Permission;
use Flash;
use Response;

class PermissionController extends AppBaseController
{

	/** @var  PermissionRepository */
	private $permissionRepository;

	function __construct(PermissionRepository $permissionRepo)
	{
		$this->permissionRepository = $permissionRepo;
	}

	/**
	 * Display a listing of the Permission.
	 *
	 * @return Response
	 */
	public function index()
	{
		$permissions = Permission::all();

		return view('permissions.index')
			->with('permissions', $permissions);
	}

	/**
	 * Show the form for creating a new Permission.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('permissions.create');
	}

	/**
	 * Store a newly created Permission in storage.
	 *
	 * @param CreatePermissionRequest $request
	 *
	 * @return Response
	 */
	public function store(CreatePermissionRequest $request)
	{
		$input = $request->all();

		$permission = $this->permissionRepository->create($input);

		flash('Registro salvo com sucesso!')->success();

		return redirect(route('config.permissions.index'));
	}

	/**
	 * Display the specified Permission.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$permission = $this->permissionRepository->find($id);

		if(empty($permission))
		{
			flash('Registro não existe.')->error();

			return redirect(route('config.permissions.index'));
		}

		return view('permissions.show')->with('permission', $permission);
	}

	/**
	 * Show the form for editing the specified Permission.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$permission = $this->permissionRepository->find($id);

		if(empty($permission))
		{
			flash('Registro não existe.')->error();

			return redirect(route('config.permissions.index'));
		}

		return view('permissions.edit')->with('permission', $permission);
	}

	/**
	 * Update the specified Permission in storage.
	 *
	 * @param  int              $id
	 * @param UpdatePermissionRequest $request
	 *
	 * @return Response
	 */
	public function update($id, UpdatePermissionRequest $request)
	{
		$permission = $this->permissionRepository->find($id);

		if(empty($permission))
		{
			flash('Registro não existe.')->error();

			return redirect(route('config.permissions.index'));
		}

		$permission = $this->permissionRepository->updateRich($request->all(), $id);

		flash('Registro editado com sucesso!')->success();

		return redirect(route('config.permissions.index'));
	}

	/**
	 * Remove the specified Permission from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$permission = $this->permissionRepository->find($id);

		if(empty($permission))
		{
			flash('Registro não existe.')->error();

			return redirect(route('config.permissions.index'));
		}

		$this->permissionRepository->delete($id);

		flash('Registro deletado com sucesso!')->success();

		return redirect(route('config.permissions.index'));
	}

    /**
	 * Update status of specified Permission from storage.
	 *
	 * @param  int $id
	 *
	 * @return Json
	 */
	public function toggle($id){
            $register = $this->permissionRepository->find($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
