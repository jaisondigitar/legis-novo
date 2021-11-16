<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateResponsibilityRequest;
use App\Http\Requests\UpdateResponsibilityRequest;
use App\Repositories\ResponsibilityRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class ResponsibilityController extends AppBaseController
{
    /** @var  ResponsibilityRepository */
    private $responsibilityRepository;

    public function __construct(ResponsibilityRepository $responsibilityRepo)
    {
        $this->responsibilityRepository = $responsibilityRepo;
    }

    /**
     * Display a listing of the Responsibility.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('responsibilities.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->responsibilityRepository->pushCriteria(new RequestCriteria($request));
        $responsibilities = $this->responsibilityRepository->all();

        return view('responsibilities.index')
            ->with('responsibilities', $responsibilities);
    }

    /**
     * Show the form for creating a new Responsibility.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('responsibilities.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('responsibilities.create');
    }

    /**
     * Store a newly created Responsibility in storage.
     *
     * @param CreateResponsibilityRequest $request
     *
     * @return Response
     */
    public function store(CreateResponsibilityRequest $request)
    {
       if(!Defender::hasPermission('responsibilities.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $responsibility = $this->responsibilityRepository->create($input);

        flash('Responsabilidade salva com sucesso.')->success();

        return redirect(route('responsibilities.index'));
    }

    /**
     * Display the specified Responsibility.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('responsibilities.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $responsibility = $this->responsibilityRepository->findWithoutFail($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        return view('responsibilities.show')->with('responsibility', $responsibility);
    }

    /**
     * Show the form for editing the specified Responsibility.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('responsibilities.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $responsibility = $this->responsibilityRepository->findWithoutFail($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        return view('responsibilities.edit')->with('responsibility', $responsibility);
    }

    /**
     * Update the specified Responsibility in storage.
     *
     * @param  int              $id
     * @param UpdateResponsibilityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResponsibilityRequest $request)
    {
        if(!Defender::hasPermission('responsibilities.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $responsibility = $this->responsibilityRepository->findWithoutFail($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        $input = $request->all();
        $input['skip_board'] = isset($input['skip_board']) ? 1 : 0;
        $responsibility = $this->responsibilityRepository->update($input, $id);

        flash('Responsabilidade atualizada com sucesso.')->success();

        return redirect(route('responsibilities.index'));
    }

    /**
     * Remove the specified Responsibility from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('responsibilities.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $responsibility = $this->responsibilityRepository->findWithoutFail($id);

        if (empty($responsibility)) {
            flash('Responsabilidade não encontrada')->error();

            return redirect(route('responsibilities.index'));
        }

        $this->responsibilityRepository->delete($id);

        flash('Responsabilidade removida com sucesso.')->success();

        return redirect(route('responsibilities.index'));
    }

    /**
    	 * Update status of specified Responsibility from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('responsibilities.edit'))
            {
                return json_encode(false);
            }
            $register = $this->responsibilityRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
