<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateLegislatureRequest;
use App\Http\Requests\UpdateLegislatureRequest;
use App\Models\Assemblyman;
use App\Models\LegislatureAssemblyman;
use App\Repositories\LegislatureRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Input;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class LegislatureController extends AppBaseController
{
    /** @var  LegislatureRepository */
    private $legislatureRepository;

    public function __construct(LegislatureRepository $legislatureRepo)
    {
        $this->legislatureRepository = $legislatureRepo;
    }

    /**
     * Display a listing of the Legislature.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('legislatures.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->legislatureRepository->pushCriteria(new RequestCriteria($request));
        $legislatures = $this->legislatureRepository->all();

        $assemblymen = Assemblyman::all()->load('legislature_assemblyman');

        return view('legislatures.index')
            ->with('assemblymen', $assemblymen)
            ->with('legislatures', $legislatures);
    }

    /**
     * Show the form for creating a new Legislature.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('legislatures.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('legislatures.create');
    }

    /**
     * Store a newly created Legislature in storage.
     *
     * @param CreateLegislatureRequest $request
     *
     * @return Response
     */
    public function store(CreateLegislatureRequest $request)
    {
       if(!Defender::hasPermission('legislatures.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $legislature = $this->legislatureRepository->create($input);

        Flash::success('Legislature saved successfully.');

        return redirect(route('legislatures.index'));
    }

    /**
     * Display the specified Legislature.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('legislatures.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $legislature = $this->legislatureRepository->findWithoutFail($id);

        if (empty($legislature)) {
            Flash::error('Legislature not found');

            return redirect(route('legislatures.index'));
        }

        $legislature_assemblyman = LegislatureAssemblyman::where('legislature_id', $legislature->id)->get();

        $legislature_assemblyman_select = LegislatureAssemblyman::where('legislature_id', $legislature->id)
            ->select('assemblyman_id')
            ->get();

        $assemblyman = Assemblyman::whereNotIn('id', $legislature_assemblyman_select)->get();

        return view('legislatures.show')
            ->with('legislature', $legislature)
            ->with('assemblyman', $assemblyman)
            ->with('legislature_assemblyman', $legislature_assemblyman);
    }

    /**
     * Show the form for editing the specified Legislature.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('legislatures.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $legislature = $this->legislatureRepository->findWithoutFail($id);

        if (empty($legislature)) {
            Flash::error('Legislature not found');

            return redirect(route('legislatures.index'));
        }

        return view('legislatures.edit')->with('legislature', $legislature);
    }

    /**
     * Update the specified Legislature in storage.
     *
     * @param  int              $id
     * @param UpdateLegislatureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLegislatureRequest $request)
    {
        if(!Defender::hasPermission('legislatures.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $legislature = $this->legislatureRepository->findWithoutFail($id);

        if (empty($legislature)) {
            Flash::error('Legislature not found');

            return redirect(route('legislatures.index'));
        }

        $legislature = $this->legislatureRepository->update($request->all(), $id);

        Flash::success('Legislature updated successfully.');

        return redirect(route('legislatures.index'));
    }

    /**
     * Remove the specified Legislature from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('legislatures.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $legislature = $this->legislatureRepository->findWithoutFail($id);

        if (empty($legislature)) {
            Flash::error('Legislature not found');

            return redirect(route('legislatures.index'));
        }

        $this->legislatureRepository->delete($id);

        Flash::success('Legislature deleted successfully.');

        return redirect(route('legislatures.index'));
    }

    /**
    	 * Update status of specified Legislature from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('legislatures.edit'))
            {
                return json_encode(false);
            }
            $register = $this->legislatureRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }

    public function saveAssemblyman($id){
        $params = Input::all();

        foreach($params['assemblyman_id'] as $assemblyman){
            $legislature_assemblyman = new LegislatureAssemblyman();
            $legislature_assemblyman->legislature_id = $id;
            $legislature_assemblyman->assemblyman_id = $assemblyman;
            $legislature_assemblyman->save();
        }
            Flash::success('Parlamentares inserido com sucesso.');
            return redirect(route('legislatures.show', $id));
    }

    public function deleteAssemblyman($legislature_id, $assemblyman_id){

        $legislature_assemblyman = LegislatureAssemblyman::where('legislature_id', $legislature_id)
            ->where('assemblyman_id', $assemblyman_id)
            ->first();

        if($legislature_assemblyman->delete()){
            Flash::success('Parlamentar deletado com sucesso.');
            return redirect(route('legislatures.show', $legislature_id));
        }
    }
}
