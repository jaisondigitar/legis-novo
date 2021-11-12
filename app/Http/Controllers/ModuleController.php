<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Libraries\Repositories\ModuleRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class ModuleController extends AppBaseController
{

	/** @var  ModuleRepository */
	private $moduleRepository;

	function __construct(ModuleRepository $moduleRepo)
	{
		$this->moduleRepository = $moduleRepo;
	}

    /**
     * Display a listing of the Module.
     *
     * @return Application|Factory|View
     * @throws BindingResolutionException
     */
	public function index()
	{
            $modules = $this->moduleRepository->newQuery()->paginate(30);
            return view('modules.index')
                ->with('modules', $modules);

	}

	/**
	 * Show the form for creating a new Module.
	 *
	 * @return Application|Factory|View
	 */
	public function create()
	{
            return view('modules.create');

	}

    /**
     * Store a newly created Module in storage.
     *
     * @param CreateModuleRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     * @throws BindingResolutionException
     */
	public function store(CreateModuleRequest $request)
	{
		$input = $request->all();

		$this->moduleRepository->create($input);

        flash('Registro salvo com sucesso!')->success();

		return redirect(route('modules.index'));
	}

    /**
     * Display the specified Module.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
	public function show($id)
	{
            $module = $this->moduleRepository->findByID($id);

            if (empty($module)) {
                Flash::error('Registro não existe.');

                return redirect(route('modules.index'));
            }

            return view('modules.show')->with('module', $module);

	}

    /**
     * Show the form for editing the specified Module.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
	public function edit($id)
	{
            $module = $this->moduleRepository->findByID($id);

            if (empty($module)) {
                Flash::error('Registro não existe.');

                return redirect(route('config.modules.index'));
            }

            return view('modules.edit')->with('module', $module);

	}

    /**
     * Update the specified Module in storage.
     *
     * @param int $id
     * @param UpdateModuleRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
	public function update($id, UpdateModuleRequest $request)
	{
		$module = $this->moduleRepository->findByID($id);

		if(empty($module))
		{
			Flash::error('Registro não existe.');

			return redirect(route('config.modules.index'));
		}

		$module = $this->moduleRepository->updateRich($request->all(), $id);

		Flash::success('Registro editado com sucesso!');

		return redirect(route('config.modules.index'));
	}

    /**
     * Remove the specified Module from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
	public function destroy($id)
	{
            $module = $this->moduleRepository->findByID($id);

            if (empty($module)) {
                Flash::error('Registro não existe.');

                return redirect(route('config.modules.index'));
            }

            $this->moduleRepository->delete($id);

            Flash::success('Registro deletado com sucesso!');

            return redirect(route('config.modules.index'));

	}

    /**
     * Update status of specified Module from storage.
     *
     * @param int $id
     *
     * @throws BindingResolutionException
     */
	public function toggle($id){
            $register = $this->moduleRepository->findByID($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
