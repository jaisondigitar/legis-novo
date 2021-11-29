<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Structurepautum;
use App\Models\VersionPauta;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laracasts\Flash\Flash;

class VersionPautaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Defender::hasPermission('version_pauta.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $versao_pautas = VersionPauta::all();

        return view('versionPautas.index', compact('versao_pautas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Defender::hasPermission('version_pauta.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
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
        if (! Defender::hasPermission('version_pauta.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $input = $request->all();

        $version = VersionPauta::where('slug', Str::slug($input['name']))->get();

        if ($version->count() == 0) {
            $version_pauta = VersionPauta::create($input);
            flash('Versão da pauta salva com sucesso!!')->warning();
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
        if (! Defender::hasPermission('version_pauta.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $version = VersionPauta::find($id);

        if (empty($version)) {
            flash('Versão da pauta não encontrada')->error();

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
        if (! Defender::hasPermission('version_pauta.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $input = $request->all();

        $version = VersionPauta::find($id);

        if (empty($version)) {
            flash('Versão da pauta não encontrada')->error();

            return redirect(route('version_pauta.index'));
        }

        $version->update($input, $version);

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
        if (! Defender::hasPermission('version_pauta.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $version = VersionPauta::find($id);

        if (empty($version)) {
            flash('Versão da pauta não encontrada')->error();

            return redirect(route('version_pauta.index'));
        }

        $version->delete($id);

        flash('Versão da pauta removida com sucesso.')->success();

        return redirect(route('version_pauta.index'));
    }

    public function createStructure($id)
    {
        if (! Defender::hasPermission('structurepautas.create')) {
            \Laracasts\Flash\flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $version_pauta = VersionPauta::find($id);
        $structurepautas = Structurepautum::whereNull('parent_id')->where('version_pauta_id', $id)->get();

        return view('versionPautas.structure', compact('version_pauta', 'structurepautas'));
    }

    public function destroyStructure($id, $structure_id)
    {
        $structure = Structurepautum::where('version_pauta_id', $id)->where('id', $structure_id)->first();

        if (! $structure) {
            return \GuzzleHttp\json_encode(false);
        }

        $structure->delete();

        return json_encode(true);
    }
}
