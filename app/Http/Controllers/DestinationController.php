<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestinationRequest;
use App\Models\Destination;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DestinationController extends Controller
{
    /**
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function index()
    {
        if (! Defender::hasPermission('destination.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $destinations = Destination::paginate(10);

        return view('destinations.index')
            ->with('destinations', $destinations);
    }

    /**
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        if (! Defender::hasPermission('destination.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        return view('destinations.create');
    }

    /**
     * @param  DestinationRequest  $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(DestinationRequest $request)
    {
        if (! Defender::hasPermission('destination.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        Destination::create($request->validated());

        flash('Registro salvo com sucesso!')->success();

        return redirect(route('destinations.index'));
    }

    /**
     * @param  int  $destination_id
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function show(int $destination_id)
    {
        if (! Defender::hasPermission('destination.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $destination = Destination::find($destination_id);

        if (empty($destination)) {
            flash('Registro não existe.')->error();

            return redirect(route('destinations.index'));
        }

        return view('destinations.show')->with('destination', $destination);
    }

    /**
     * @param  int  $destination_id
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function edit(int $destination_id)
    {
        if (! Defender::hasPermission('destination.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $destination = Destination::find($destination_id);

        if (empty($destination)) {
            flash('Registro não existe.')->error();

            return redirect(route('destinations.index'));
        }

        return view('destinations.edit')->with('destination', $destination);
    }

    /**
     * @param  DestinationRequest  $request
     * @param  int  $destination_id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(DestinationRequest $request, int $destination_id)
    {
        if (! Defender::hasPermission('destination.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $destination = Destination::find($destination_id);

        if (empty($destination)) {
            flash('Registro não existe.')->error();

            return redirect(route('destinations.index'));
        }

        $destination = Destination::find($destination_id);

        $destination->update($request->validated());

        flash('Registro editado com sucesso!')->success();

        return redirect(route('destinations.index'));
    }

    /**
     * @param  int  $destination_id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $destination_id)
    {
        if (! Defender::hasPermission('destination.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $destination = Destination::find($destination_id);

        if (empty($destination)) {
            flash('Registro não existe.')->error();

            return redirect(route('destinations.index'));
        }

        Destination::destroy($destination_id);

        flash('Registro deletado com sucesso!')->success();

        return redirect(route('destinations.index'));
    }
}
