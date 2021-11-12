<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParametersRequest;
use App\Http\Requests\UpdateParametersRequest;
use App\Repositories\ParametersRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class ParametersController extends AppBaseController
{
    /** @var  ParametersRepository */
    private $parametersRepository;

    public function __construct(ParametersRepository $parametersRepo)
    {
        $this->parametersRepository = $parametersRepo;
    }

    /**
     * Display a listing of the Parameters.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('parameters.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $parameters = $this->parametersRepository->getAll();

        return view('parameters.index')
            ->with('parameters', $parameters);
    }

    /**
     * Show the form for creating a new Parameters.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if(!Defender::hasPermission('parameters.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('parameters.create');
    }

    /**
     * Store a newly created Parameters in storage.
     *
     * @param CreateParametersRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateParametersRequest $request)
    {
       if(!Defender::hasPermission('parameters.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();
        $input['slug'] = str_slug($input['name']);
        if($input['type'] == 1){
            $input['value'] = $input['valueSelect'];
        } else {
            $input['value'] = $input['valueText'];
        }

        $parameters = $this->parametersRepository->create($input);

        Flash::success('Parâmetro salvo com sucesso.');

        return redirect(route('parameters.index'));
    }

    /**
     * Display the specified Parameters.
     *
     * @param  int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function show($id)
    {
        if(!Defender::hasPermission('parameters.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            Flash::error('Parameters not found');

            return redirect(route('parameters.index'));
        }

        return view('parameters.show')->with('parameters', $parameters);
    }

    /**
     * Show the form for editing the specified Parameters.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('parameters.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            Flash::error('Parameters not found');

            return redirect(route('config.parameters.index'));
        }

        return view('parameters.edit')->with('parameters', $parameters);
    }

    /**
     * Update the specified Parameters in storage.
     *
     * @param int $id
     * @param UpdateParametersRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update($id, UpdateParametersRequest $request)
    {
        if(!Defender::hasPermission('parameters.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            Flash::error('Parameters not found');

            return redirect(route('parameters.index'));
        }

        $request['slug'] = Str::slug($request['name']);
        if($request['type'] == 1){
            $request['value'] = $request['valueSelect'];
        } else {
            $request['value'] = $request['valueText'];
        }

        $this->parametersRepository->update($parameters, $request->all());

        Flash::success('Parâmetro atualizado com sucesso.');

        return redirect(route('parameters.index'));
    }

    /**
     * Remove the specified Parameters from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('parameters.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            Flash::error('Parameters not found');

            return redirect(route('parameters.index'));
        }

        $this->parametersRepository->delete($id);

        Flash::success('Parâmetro excluído com sucesso.');

        return redirect(route('parameters.index'));
    }
}
