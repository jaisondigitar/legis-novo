<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\TypeVoting;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;

class TypeVotingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!Defender::hasPermission('typeVotings.index'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $type_voting = TypeVoting::all();

        return view( 'typeVotings.index', compact('type_voting' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Defender::hasPermission('typeVotings.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('typeVotings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Defender::hasPermission('typeVotings.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $input = $request->all();
        $input['anonymous'] = isset($input['anonymous']) ? 1 : 0;
        $input['active'] = isset($input['active']) ? 1 : 0;

        TypeVoting::create($input);

        Flash::success('Type saved successfully.');

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
        if(!Defender::hasPermission('typeVotings.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $type_voting = TypeVoting::find($id);

        if (empty($type_voting)) {
            Flash::error('Type voting not found');

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
        if(!Defender::hasPermission('typeVotings.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $type_voting = TypeVoting::find($id);

        if (empty($type_voting)) {
            Flash::error('Type not found');

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
    public function update(Request $request, $id)
    {
        if(!Defender::hasPermission('typeVotings.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $type_voting = TypeVoting::find($id);
        $input = $request->all();

        $input['anonymous'] = isset($input['anonymous']) ? 1 : 0;
        $input['active'] = isset($input['active']) ? 1 : 0;


        if (empty($type_voting)) {
            Flash::error('Type not found');

            return redirect(route('typeVotings.index'));
        }

        $type_voting = TypeVoting::find($id);

        $type_voting->name = $input['name'];
        $type_voting->active = $input['active'];
        $type_voting->anonymous = $input['anonymous'];
        $type_voting->save();


        Flash::success('Type updated successfully.');

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
        if(!Defender::hasPermission('typeVotings.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $type_voting = TypeVoting::find($id);

        if (empty($type_voting)) {
            Flash::error('Type not found');

            return redirect(route('typeVotings.index'));
        }

        $type_voting->delete($id);

        Flash::success('Type deleted successfully.');

        return redirect(route('typeVotings.index'));
    }
}
