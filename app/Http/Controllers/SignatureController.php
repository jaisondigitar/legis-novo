<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $document_controller = resolve(DocumentController::class);

        $document_controller->show($request->get('document_id'));

        return view('signature.index');
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
