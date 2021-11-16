<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateParametersRequest;
use App\Http\Requests\UpdateParametersRequest;
use App\Repositories\ParametersRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

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
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('parameters.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->parametersRepository->pushCriteria(new RequestCriteria($request));
        $parameters = $this->parametersRepository->all();

        return view('parameters.index')
            ->with('parameters', $parameters);
    }

    /**
     * Show the form for creating a new Parameters.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('parameters.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('parameters.create');
    }

    /**
     * Store a newly created Parameters in storage.
     *
     * @param CreateParametersRequest $request
     *
     * @return Response
     */
    public function store(CreateParametersRequest $request)
    {
       if(!Defender::hasPermission('parameters.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
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

        flash('Parâmetro salvo com sucesso.')->success();

        return redirect(route('config.parameters.index'));
    }

    /**
     * Display the specified Parameters.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('parameters.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

            return redirect(route('config.parameters.index'));
        }

        return view('parameters.show')->with('parameters', $parameters);
    }

    /**
     * Show the form for editing the specified Parameters.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('parameters.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

            return redirect(route('config.parameters.index'));
        }

        return view('parameters.edit')->with('parameters', $parameters);
    }

    /**
     * Update the specified Parameters in storage.
     *
     * @param  int              $id
     * @param UpdateParametersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParametersRequest $request)
    {
        if(!Defender::hasPermission('parameters.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

            return redirect(route('parameters.index'));
        }

        $request['slug'] = str_slug($request['name']);
        if($request['type'] == 1){
            $request['value'] = $request['valueSelect'];
        } else {
            $request['value'] = $request['valueText'];
        }

        $parameters = $this->parametersRepository->update($request->all(), $id);

        flash('Parâmetro atualizado com sucesso.')->success();

        return redirect(route('config.parameters.index'));
    }

    /**
     * Remove the specified Parameters from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('parameters.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            flash('Parâmetro não encontrado')->error();

            return redirect(route('parameters.index'));
        }

        $this->parametersRepository->delete($id);

        flash('Parâmetro excluído com sucesso.')->success();

        return redirect(route('config.parameters.index'));
    }
}
