<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateSectorRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Repositories\SectorRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Support\Str;

class SectorController extends AppBaseController
{
    /** @var  SectorRepository */
    private $sectorRepository;

    public function __construct(SectorRepository $sectorRepo)
    {
        $this->sectorRepository = $sectorRepo;
    }

    /**
     * Display a listing of the Sector.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('sectors.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->sectorRepository->pushCriteria(new RequestCriteria($request));
        $sectors = $this->sectorRepository->all();

        return view('sectors.index')
            ->with('sectors', $sectors);
    }

    /**
     * Show the form for creating a new Sector.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('sectors.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('sectors.create');
    }

    /**
     * Store a newly created Sector in storage.
     *
     * @param CreateSectorRequest $request
     *
     * @return Response
     */
    public function store(CreateSectorRequest $request)
    {
       if(!Defender::hasPermission('sectors.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }

        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $sector = $this->sectorRepository->create($input);

        flash('Setor salvo com sucesso.')->success();

        return redirect(route('sectors.index'));
    }

    /**
     * Display the specified Sector.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('sectors.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        return view('sectors.show')->with('sector', $sector);
    }

    /**
     * Show the form for editing the specified Sector.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('sectors.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        return view('sectors.edit')->with('sector', $sector);
    }

    /**
     * Update the specified Sector in storage.
     *
     * @param  int              $id
     * @param UpdateSectorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSectorRequest $request)
    {
        if(!Defender::hasPermission('sectors.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        $input = $request->all();

        $input['slug'] = Str::slug($request->name);

        $sector = $this->sectorRepository->update($input, $id);

        flash('Setor atualizado com sucesso.')->success();

        return redirect(route('sectors.index'));
    }

    /**
     * Remove the specified Sector from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('sectors.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            flash('Setor não encontrado')->error();

            return redirect(route('sectors.index'));
        }

        $this->sectorRepository->delete($id);

        flash('Setor removido com sucesso.')->success();

        return redirect(route('sectors.index'));
    }

    /**
    	 * Update status of specified Sector from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('sectors.edit'))
            {
                return json_encode(false);
            }
            $register = $this->sectorRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
