<?php

namespace App\Http\Controllers;

use App\Models\ProcessingDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProcessingDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return false|string
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $date = explode('/', $input['processing_document_date']);
        $date_first = explode('/', $input['processing_document_date_first']);

        $documents_date = $date[2].'-'.$date[1].'-'.$date[0];
        $documents_date_first = $date_first[2].'-'.$date_first[1].'-'.$date_first[0];

        if (strtotime($documents_date) < strtotime($documents_date_first)) {
            return json_encode(false);
        }

        $processing = ProcessingDocument::create($input);
        $processing->observation = $request->observation;
        $processing->save();

        if ($processing) {
            $processing = ProcessingDocument::where('document_id', $input['document_id'])
                ->orderBy('processing_document_date', 'desc')
                ->with(['DocumentSituation', 'StatusProcessingDocument', 'destination'])
                ->get();

            return json_encode($processing);
        }

        return json_encode(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return false|string
     */
    public function destroy($id)
    {
        $processing = ProcessingDocument::find($id);

        if ($processing) {
            $processing->delete();

            return json_encode($id);
        }

        return json_encode(false);
    }
}
