<?php namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Libraries\Repositories\PermissionRepository;
use App\Models\Permission;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

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
	 * @return Application|Factory|View
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
	 * @return Application|Factory|View
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
     * @return Application|RedirectResponse|Redirector
     * @throws BindingResolutionException
     */
	public function store(CreatePermissionRequest $request)
	{
		$input = $request->all();

		$this->permissionRepository->create($input);

		Flash::success('Registro salvo com sucesso!');

		return redirect(route('permissions.index'));
	}

    /**
     * Display the specified Permission.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
	public function show(int $id)
	{
		$permission = $this->permissionRepository->findByID($id);

		if(empty($permission))
		{
			Flash::error('Registro não existe.');

			return redirect(route('permissions.index'));
		}

		return view('permissions.show')->with('permission', $permission);
	}

    /**
     * Show the form for editing the specified Permission.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
	public function edit(int $id)
	{
		$permission = $this->permissionRepository->findByID($id);

		if(empty($permission))
		{
			Flash::error('Registro não existe.');

			return redirect(route('permissions.index'));
		}

		return view('permissions.edit')->with('permission', $permission);
	}

    /**
     * Update the specified Permission in storage.
     *
     * @param int $id
     * @param UpdatePermissionRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
	public function update(int $id, UpdatePermissionRequest $request)
	{
		$permission = $this->permissionRepository->findByID($id);

		if(empty($permission))
		{
			Flash::error('Registro não existe.');

			return redirect(route('permissions.index'));
		}

		$this->permissionRepository->update($permission, $request->all());

		Flash::success('Registro editado com sucesso!');

		return redirect(route('permissions.index'));
	}

    /**
     * Remove the specified Permission from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
	public function destroy(int $id)
	{
		$permission = $this->permissionRepository->findByID($id);

		if(empty($permission))
		{
			Flash::error('Registro não existe.');

			return redirect(route('permissions.index'));
		}

		$this->permissionRepository->delete($permission);

		Flash::success('Registro deletado com sucesso!');

		return redirect(route('permissions.index'));
	}

    /**
     * Update status of specified Permission from storage.
     *
     * @param int $id
     * @return false|string
     * @throws BindingResolutionException
     */
	public function toggle(int $id){
            $register = $this->permissionRepository->findByID($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
