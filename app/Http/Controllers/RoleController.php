<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Libraries\Repositories\RoleRepository;
use App\Models\Permission;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class RoleController extends AppBaseController
{
    /** @var RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @return Application|Factory|View
     * @throws BindingResolutionException
     */
    public function index()
    {
        $roles = $this->roleRepository->newQuery()->paginate(10);

        return view('roles.index')
            ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Application|Factory|View
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
     * @return Application|RedirectResponse|Redirector
     * @throws BindingResolutionException
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();

        $this->roleRepository->create($input);

        flash('Registro salvo com sucesso!')->success();

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        $role = $this->roleRepository->findByID($id);

        if (empty($role)) {
            flash('Registro não existe.')->error();

            return redirect(route('roles.index'));
        }

        return view('roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findByID($id);

        if (empty($role)) {
            flash('Registro não existe.')->error();

            return redirect(route('roles.index'));
        }

        return view('roles.edit')->with('role', $role);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param int $id
     * @param UpdateRoleRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->findByID($id);

        if (empty($role)) {
            flash('Registro não existe.')->error();

            return redirect(route('roles.index'));
        }

        $this->roleRepository->update($role, $request->all());

        flash('Registro editado com sucesso!')->success();

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        $role = $this->roleRepository->findByID($id);

        if (empty($role)) {
            flash('Registro não existe.')->error();

            return redirect(route('roles.index'));
        }

        $this->roleRepository->delete($role);

        flash('Registro deletado com sucesso!')->success();

        return redirect(route('roles.index'));
    }

    /**
     * Update status of specified Role from storage.
     *
     * @param int $id
     * @return false|string
     * @throws BindingResolutionException
     */
    public function toggle(int $id)
    {
        $register = $this->roleRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function permission($id)
    {
        $roles = Defender::findRoleById($id);
        $perms = Permission::all();
        $list = $this->getNameOfPermissions();

        return view('roles.permission', compact('roles', 'perms', 'list'));
    }

    /**
     * @return Permission[]|Collection|\Illuminate\Support\Collection
     */
    public function getNameOfPermissions()
    {
        return Permission::all()->map(function ($permission) {
            return explode('.', $permission->name)[0];
        })->unique();
    }

    public function togglePermission($role, $permission)
    {
        $role = Defender::findRole($role);
        $perm = Defender::findPermissionById($permission);

        $has = $this->checkPermission($role, $perm);
        $has ? $role->detachPermission($perm) : $role->attachPermission($perm);

        return json_encode(true);
    }

    public function checkPermission($role, $perm)
    {
        foreach ($role->permissions as $value2) {
            if ($value2->name == $perm->name) {
                return true;
            }
        }

        return false;
    }
}
