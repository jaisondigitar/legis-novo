<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Structurepautum;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class StructurepautaController extends AppBaseController
{
    /** @var  StructurepautaRepository */


    /**
     * Display a listing of the Structurepauta.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('structurepautas.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $structurepautas = Structurepautum::whereNull('parent_id')->get();

        return view('structurepautas.index')
            ->with('structurepautas', $structurepautas);
    }

    /**
     * Show the form for creating a new Structurepauta.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('structurepautas.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('$ROUTES_AS_PREFIX$structurepautas.create');
    }

    /**
     * Store a newly created Structurepauta in storage.
     *
     * @param CreateStructurepautaRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
       if(!Defender::hasPermission('structurepautas.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }

        $input      = $request->all();
        $input['parent_id'] = $input['parent_id']==0 ? null : $input['parent_id'];
        $structure  = Structurepautum::create($input);

        if($structure)
        {
            return json_encode(true);
        }
        return json_encode(false);
    }

    /**
     * Display the specified Structurepauta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('structurepautas.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }


    }

    /**
     * Show the form for editing the specified Structurepauta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('structurepautas.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

    }

    /**
     * Update the specified Structurepauta in storage.
     *
     * @param  int              $id
     * @param UpdateStructurepautaRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $structure = Structurepautum::find($id);

        if(!$structure)
        {
            return \GuzzleHttp\json_encode(false);
        }
        $input = $request->all();


        $data = [
            'order' => $input['order'],
            'name' => $input['name']
        ];

        $structure->update($data);

        return \GuzzleHttp\json_encode(true);

    }

    /**
     * Remove the specified Structurepauta from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

        $structure = Structurepautum::find($id);

        if(!$structure)
        {
            return \GuzzleHttp\json_encode(false);
        }

        $structure->delete();

        return json_encode(true);

    }

    /**
     * Update status of specified Structurepauta from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id){

        return json_encode(true);
    }


    /**
     * Update status of specified Structurepaut
     *
     * @param $field
     * @param $id
     * @return string
     */
    public function toggleField($field,$id){

        $structure = Structurepautum::find($id);

        if(!$structure)
        {
            return \GuzzleHttp\json_encode(false);
        }

        $structure->$field = $structure->$field ? 0 : 1;
        $structure->save();

        return json_encode(true);
    }
}
