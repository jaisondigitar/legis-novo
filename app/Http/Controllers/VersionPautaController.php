<?php

namespace App\Http\Controllers;

use App\Models\Structurepautum;
use App\Models\VersionPauta;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Validation\Rule;



class VersionPautaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Defender::hasPermission('version_pauta.index'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $versao_pautas = VersionPauta::all();

        return view( 'versionPautas.index', compact('versao_pautas' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Defender::hasPermission('version_pauta.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('versionPautas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Defender::hasPermission('version_pauta.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $input = $request->all();

        $version = VersionPauta::where('slug', str_slug($input['name']))->get();

        if($version->count() == 0){
            $version_pauta = VersionPauta::create($input);
            Flash::warning('Versão salva com sucesso!!');
        }

        return redirect(route('version_pauta.createStructure', [$version_pauta->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('version_pauta.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $version = VersionPauta::find($id);


        if (empty($version)) {
            Flash::error('Version not found');

            return redirect(route('version_pauta.index'));
        }

        return view('versionPautas.edit')->with('version_pauta', $version);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Defender::hasPermission('version_pauta.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $input = $request->all();

        $version = VersionPauta::find($id);

        if (empty($version)) {
            Flash::error('Version not found');

            return redirect(route('version_pauta.index'));
        }

        $version->update($input, $id);

        return redirect(route('version_pauta.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('version_pauta.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $version = VersionPauta::find($id);

        if (empty($version)) {
            Flash::error('Version not found');

            return redirect(route('version_pauta.index'));
        }

        $version->delete($id);

        Flash::success('Version deleted successfully.');

        return redirect(route('version_pauta.index'));
    }

    public function createStructure($id)
    {
        if(!Defender::hasPermission('structurepautas.create'))
        {
            \Laracasts\Flash\Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $version_pauta = VersionPauta::find($id);
        $structurepautas = Structurepautum::whereNull('parent_id')->where('version_pauta_id', $id)->get();

        return view('versionPautas.structure', compact('version_pauta', 'structurepautas'));
    }

    public function destroyStructure($id, $structure_id)
    {

        $structure = Structurepautum::where('version_pauta_id', $id)->where('id', $structure_id)->first();

        if(!$structure)
        {
            return \GuzzleHttp\json_encode(false);
        }

        $structure->delete();

        return json_encode(true);
    }

}
