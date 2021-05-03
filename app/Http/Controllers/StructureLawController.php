<?php

namespace App\Http\Controllers;

use App\Models\StructureLaws;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StructureLawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd("index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input  = $request->all();

        $base   = StructureLaws::find($input['parent_id']);
        $data = [
            'law_id' => $input['law_id'],
            'law_structure_id' => $input['type'],
            'number' => (isset($input['number']) || $input['number']) ? $input['number'] : 0,
            'content' => $input['content'],
        ];
        $create = StructureLaws::create($data);
        $create->makeChildOf($base);

        return json_encode(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd("show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd("edit");
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
        $input  = $request->all();
        $new   = StructureLaws::find($id);
        $new->content = $input['content'];
        $new->law_structure_id = $input['type'];
        $new->number = (isset($input['number']) || $input['number']) ? $input['number'] : 0;
        $new->save();

        return json_encode(true);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new   = StructureLaws::find($id);
        $new->delete();
        StructureLaws::rebuild();
        return json_encode(true);
    }
}
