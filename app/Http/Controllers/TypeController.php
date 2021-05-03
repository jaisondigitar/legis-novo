<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Repositories\TypeRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class TypeController extends AppBaseController
{
    /** @var  TypeRepository */
    private $typeRepository;

    public function __construct(TypeRepository $typeRepo)
    {
        $this->typeRepository = $typeRepo;
    }

    /**
     * Display a listing of the Type.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('types.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->typeRepository->pushCriteria(new RequestCriteria($request));
        $types = $this->typeRepository->all();

        return view('types.index')
            ->with('types', $types);
    }

    /**
     * Show the form for creating a new Type.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('types.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('types.create');
    }

    /**
     * Store a newly created Type in storage.
     *
     * @param CreateTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateTypeRequest $request)
    {
       if(!Defender::hasPermission('types.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $type = $this->typeRepository->create($input);

        Flash::success('Type saved successfully.');

        return redirect(route('types.index'));
    }

    /**
     * Display the specified Type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('types.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            Flash::error('Type not found');

            return redirect(route('types.index'));
        }

        return view('types.show')->with('type', $type);
    }

    /**
     * Show the form for editing the specified Type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('types.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            Flash::error('Type not found');

            return redirect(route('types.index'));
        }

        return view('types.edit')->with('type', $type);
    }

    /**
     * Update the specified Type in storage.
     *
     * @param  int              $id
     * @param UpdateTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTypeRequest $request)
    {
        if(!Defender::hasPermission('types.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            Flash::error('Type not found');

            return redirect(route('types.index'));
        }

        $type = $this->typeRepository->update($request->all(), $id);

        Flash::success('Type updated successfully.');

        return redirect(route('types.index'));
    }

    /**
     * Remove the specified Type from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('types.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $type = $this->typeRepository->findWithoutFail($id);

        if (empty($type)) {
            Flash::error('Type not found');

            return redirect(route('types.index'));
        }

        $this->typeRepository->delete($id);

        Flash::success('Type deleted successfully.');

        return redirect(route('types.index'));
    }

    /**
    	 * Update status of specified Type from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('types.edit'))
            {
                return json_encode(false);
            }
            $register = $this->typeRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
