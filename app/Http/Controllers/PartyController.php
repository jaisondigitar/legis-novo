<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreatePartyRequest;
use App\Http\Requests\UpdatePartyRequest;
use App\Repositories\PartyRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class PartyController extends AppBaseController
{
    /** @var  PartyRepository */
    private $partyRepository;

    public function __construct(PartyRepository $partyRepo)
    {
        $this->partyRepository = $partyRepo;
    }

    /**
     * Display a listing of the Party.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('parties.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $this->partyRepository->pushCriteria(new RequestCriteria($request));
        $parties = $this->partyRepository->all();

        return view('parties.index')
            ->with('parties', $parties);
    }

    /**
     * Show the form for creating a new Party.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('parties.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('parties.create');
    }

    /**
     * Store a newly created Party in storage.
     *
     * @param CreatePartyRequest $request
     *
     * @return Response
     */
    public function store(CreatePartyRequest $request)
    {
       if(!Defender::hasPermission('parties.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $party = $this->partyRepository->create($input);

        flash('Partido salvo com sucesso.')->success();

        return redirect(route('parties.index'));
    }

    /**
     * Display the specified Party.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('parties.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $party = $this->partyRepository->findWithoutFail($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        return view('parties.show')->with('party', $party);
    }

    /**
     * Show the form for editing the specified Party.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('parties.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $party = $this->partyRepository->findWithoutFail($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        return view('parties.edit')->with('party', $party);
    }

    /**
     * Update the specified Party in storage.
     *
     * @param  int              $id
     * @param UpdatePartyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePartyRequest $request)
    {
        if(!Defender::hasPermission('parties.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $party = $this->partyRepository->findWithoutFail($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        $party = $this->partyRepository->update($request->all(), $id);

        flash('Partido atualizado com sucesso.')->success();

        return redirect(route('parties.index'));
    }

    /**
     * Remove the specified Party from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('parties.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $party = $this->partyRepository->findWithoutFail($id);

        if (empty($party)) {
            flash('Partido não encontrado')->error();

            return redirect(route('parties.index'));
        }

        $this->partyRepository->delete($id);

        flash('Partido removido com sucesso.')->success();

        return redirect(route('parties.index'));
    }

    /**
    	 * Update status of specified Party from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('parties.edit'))
            {
                return json_encode(false);
            }
            $register = $this->partyRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
