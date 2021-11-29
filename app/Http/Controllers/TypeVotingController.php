<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeVotingRequest;
use App\Models\Meeting;
use App\Models\TypeVoting;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;

class TypeVotingController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Defender::hasPermission('typeVotings.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $type_voting = TypeVoting::all();

        return view('typeVotings.index', compact('type_voting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Defender::hasPermission('typeVotings.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('typeVotings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeVotingRequest $request)
    {
        if (! Defender::hasPermission('typeVotings.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $input = $request->all();
        $input['anonymous'] = isset($input['anonymous']) ? 1 : 0;
        $input['active'] = isset($input['active']) ? 1 : 0;

        TypeVoting::create($input);

        flash('Tipo salvo com sucesso.')->success();

        return redirect(route('typeVotings.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Defender::hasPermission('typeVotings.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $type_voting = TypeVoting::find($id);

        if (empty($type_voting)) {
            flash('Tipo de votação não encontrado')->error();

            return redirect(route('typeVotings.index'));
        }

        return view('typeVotings.show')->with('type_voting', $type_voting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Defender::hasPermission('typeVotings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }
        $type_voting = TypeVoting::find($id);

        if (empty($type_voting)) {
            flash('Tipo não encontrado')->error();

            return redirect(route('typeVotings.index'));
        }

        return view('typeVotings.edit')->with('type_voting', $type_voting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeVotingRequest $request, $id)
    {
        if (! Defender::hasPermission('typeVotings.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $type_voting = TypeVoting::find($id);
        $input = $request->all();

        $input['anonymous'] = isset($input['anonymous']) ? 1 : 0;
        $input['active'] = isset($input['active']) ? 1 : 0;

        if (empty($type_voting)) {
            flash('Tipo não encontrado')->error();

            return redirect(route('typeVotings.index'));
        }

        $type_voting = TypeVoting::find($id);

        $type_voting->name = $input['name'];
        $type_voting->active = $input['active'];
        $type_voting->anonymous = $input['anonymous'];
        $type_voting->save();

        flash('Tipo atualizado com sucesso.')->success();

        return redirect(route('typeVotings.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('typeVotings.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $type_voting = TypeVoting::find($id);

        if (empty($type_voting)) {
            flash('Tipo não encontrado')->error();

            return redirect(route('typeVotings.index'));
        }

        $type_voting->delete($id);

        flash('Tipo removido com sucesso.')->success();

        return redirect(route('typeVotings.index'));
    }
}
