<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Libraries\Repositories\CompanyRepository;
use App\Models\Company;
use App\Models\Parameters;
use App\Models\State;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use App\Models\City;
use Illuminate\Support\Facades\Auth;


class CompanyController extends AppBaseController
{

	/** @var  CompanyRepository */
	private $companyRepository;

	function __construct(CompanyRepository $companyRepo)
	{
		$this->companyRepository = $companyRepo;
	}

    /**
     * Display a listing of the Company.
     *
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
	public function index()
	{
		if(!Defender::hasPermission('companies.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $companies = $this->companyRepository->newQuery()->paginate(10);
        return view('companies.index')
            ->with('companies', $companies);
	}

	/**
	 * Show the form for creating a new Company.
	 *
	 * @return Application|Factory|Redirector|RedirectResponse|View
     */
	public function create()
	{
        if(!Defender::hasPermission('companies.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $states = $this->statesList();
        $cities = City::where('state', '=', $states[1])->pluck('name', 'id');
        return view('companies.create', compact('states', 'cities'));
	}

    /**
     * Store a newly created Company in storage.
     *
     * @param CreateCompanyRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
	public function store(CreateCompanyRequest $request)
	{

        if(!Defender::hasPermission('companies.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $input = $request->all();
		$company = $this->companyRepository->create($input);

        if($request->file('image')) {

            $image = $request['image'];
            $extesion_img = strtolower($image->getClientOriginalExtension());

            $image_file = uniqid() . time() . '.' . $extesion_img;

            $request->file('image')->move(
                base_path() . '/public/uploads/company/', $image_file
            );
            $company->image = $image_file;
            $company->save();

            Image::make(sprintf(base_path() . '/public/uploads/company/%s', $image_file))
                ->resize(null, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
        }

		flash('Registro salvo com sucesso!')->success();
		return redirect(route('companies.index'));
	}

    /**
     * Display the specified Company.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
	public function show($id)
	{
        if(!Defender::hasPermission('companies.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $company = $this->companyRepository->findByID($id);

        $parameters = Parameters::all();

		if(empty($company))
		{
			flash('Registro não existe.')->error();

			return redirect(route('companies.index'));
		}

		return view('companies.show')->with('company', $company)->with('parameters', $parameters);
	}

    /**
     * Show the form for editing the specified Company.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
	public function edit($id)
	{
        if(!Defender::hasPermission('companies.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $company = $this->companyRepository->findByID($id);
        $states = $this->statesList();
        $state = State::find($company->state);
        $cities = City::where('state', '=', $state->uf)->pluck('name', 'id');
		if(empty($company))
		{
			flash('Registro não existe.')->error();

			return redirect(route('companies.index'));
		}

		return view('companies.edit',compact('states','cities'))->with('company', $company);
	}

    /**
     * Update the specified Company in storage.
     *
     * @param int $id
     * @param UpdateCompanyRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
	public function update(int $id, UpdateCompanyRequest $request)
	{
        if(!Defender::hasPermission('companies.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $company = $this->companyRepository->findByID($id);

		if(empty($company))
		{
			flash('Registro não existe.')->error();

			return redirect(route('companies.index'));
		}

		$this->companyRepository->update($company, $request->all());

        $company = Company::find($id);

        if($request->file('image')) {

            $image = $request['image'];
            $extension_img = strtolower($image->getClientOriginalExtension());

            $image_file = uniqid() . time() . '.' . $extension_img;

            $request->file('image')->move(
                base_path() . '/public/uploads/company/', $image_file
            );
            $company->image = $image_file;
            $company->save();

            Image::make(sprintf(base_path() . '/public/uploads/company/%s', $image_file))
                ->resize(null, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
        }


		flash('Registro editado com sucesso!')->success();

		return redirect(route('companies.index'));
	}

    /**
     * Remove the specified Company from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
	public function destroy($id)
	{
        if(!Defender::hasPermission('companies.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $company = $this->companyRepository->findByID($id);

		if(empty($company))
		{
			flash('Registro não existe.')->error();

			return redirect(route('config.companies.index'));
		}

		$this->companyRepository->delete($company);

		flash('Registro deletado com sucesso!')->success();

		return redirect(route('companies.index'));
	}

    /**
     * Update status of specified Company from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
	public function toggle($id)
    {
        if (!Defender::hasPermission('companies.edit')) {
            return json_encode(false);
        }

        $register = $this->companyRepository->findByID($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }

    public function removeImage($id)
    {
        $company = Company::find($id);
        $company->image = null;

        if($company->save()){
            return 'true';
        } else {
            return 'false';
        }
    }

    public function changeParamater($id, $value)
    {
        $parameter = Parameters::find($id);
        $parameter->value = $value;

        if($parameter->save()){
            return 'true';
        } else {
            return 'false';
        }
    }

    public function setStagePanel(Request $request)
    {
        $input = $request->all();
        $company = Company::find(Auth::user()->company->id);
        $company->stage = $input['stage'];
        if($company->save())
            return json_encode(true);

        return json_encode(false);

    }

    public function getStagePanel()
    {
        $company = Company::find(Auth::user()->company->id);

        if($company)
            return json_encode($company);

        return json_encode(false);
    }

}
