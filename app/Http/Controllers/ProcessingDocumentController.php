<?php

namespace App\Http\Controllers;

use App\Models\DocumentSituation;
use App\Models\ProcessingDocument;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProcessingDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        $processing = ProcessingDocument::create($request->all());
        $processing->observation = $request->observation;
        $processing->save();

        if($processing){
            $processing = ProcessingDocument::where('document_id', $input['document_id'])->orderBy('processing_document_date', 'desc')->with('DocumentSituation')->with('StatusProcessingDocument')->get();
            return json_encode($processing);
        }

        return json_encode(false);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $processing = ProcessingDocument::find($id);

        if($processing){
            $processing->delete();
            return json_encode($id);
        }

        return json_encode(false);
    }
}
