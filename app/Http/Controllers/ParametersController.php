<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParametersRequest;
use App\Http\Requests\UpdateParametersRequest;
use App\Repositories\ParametersRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class ParametersController extends AppBaseController
{
    /** @var ParametersRepository */
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
        if (! Defender::hasPermission('parameters.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $parameters = $this->parametersRepository->getAll(0);

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
        if (! Defender::hasPermission('parameters.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
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
        if (! Defender::hasPermission('parameters.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $input = $request->all();
        $input['slug'] = Str::slug($input['name']);
        if ($input['type'] == 1) {
            $input['value'] = $input['valueSelect'];
        } else {
            $input['value'] = $input['valueText'];
        }

        $parameters = $this->parametersRepository->create($input);

        flash('Parâmetro salvo com sucesso.')->success();

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
        if (! Defender::hasPermission('parameters.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

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
        if (! Defender::hasPermission('parameters.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

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
        if (! Defender::hasPermission('parameters.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

            return redirect(route('parameters.index'));
        }

        $request['slug'] = Str::slug($request['name']);
        if ($request['type'] == 1) {
            $request['value'] = $request['valueSelect'];
        } else {
            $request['value'] = $request['valueText'];
        }

        $this->parametersRepository->update($parameters, $request->all());

        flash('Parâmetro atualizado com sucesso.')->success();

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
    public function destroy($id, Request $request)
    {
        if (! Defender::hasPermission('parameters.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $parameters = $this->parametersRepository->findByID($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

            return redirect(route('parameters.index'));
        }

        $this->parametersRepository->delete($parameters);

        if ($request->ajax()) {
            return 'success';
        }

        flash('Parâmetro excluído com sucesso.')->success();

        return redirect(route('parameters.index'));
    }
}
