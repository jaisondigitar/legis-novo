<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Processing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessingController extends Controller
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
        $processing = Processing::create($request->all());
        $processing->owner()->associate(Auth::user());

        if ($processing) {
            $processing = Processing::where('law_projects_id', $input['law_projects_id'])
                ->orderBy('processing_date', 'desc')
                ->with([
                    'AdviceSituationLaw',
                    'AdvicePublicationLaw',
                    'StatusProcessingLaw',
                    'destination',
                ])
                ->get();

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
        //
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
        $processing = Processing::find($id);

        if ($processing && Auth::user()->id == $processing->user_id) {
            $processing->delete();

            return json_encode($id);
        }

        return json_encode(false);
    }
}
