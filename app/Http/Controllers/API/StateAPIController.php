<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Libraries\Repositories\StateRepository;
use app\Models\State;
use Illuminate\Http\Request;
use Mitul\Controller\AppBaseController as AppBaseController;
use Response;

class StateAPIController extends AppBaseController
{
    /** @var StateRepository */
    private $stateRepository;

    public function __construct(StateRepository $stateRepo)
    {
        $this->stateRepository = $stateRepo;
    }

    /**
     * Display a listing of the State.
     * GET|HEAD /states.
     *
     * @return Response
     */
    public function index()
    {
        $states = $this->stateRepository->all();

        return $this->sendResponse($states->toArray(), 'States retrieved successfully');
    }

    /**
     * Show the form for creating a new State.
     * GET|HEAD /states/create.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created State in storage.
     * POST /states.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if (count(State::$rules) > 0) {
            $this->validateRequestOrFail($request, State::$rules);
        }

        $input = $request->all();

        $states = $this->stateRepository->create($input);

        return $this->sendResponse($states->toArray(), 'State saved successfully');
    }

    /**
     * Display the specified State.
     * GET|HEAD /states/{id}.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $state = $this->stateRepository->apiFindOrFail($id);

        return $this->sendResponse($state->toArray(), 'State retrieved successfully');
    }

    /**
     * Show the form for editing the specified State.
     * GET|HEAD /states/{id}/edit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // maybe, you can return a template for JS
//		Errors::throwHttpExceptionWithCode(Errors::EDITION_FORM_NOT_EXISTS, ['id' => $id], static::getHATEOAS(['%id' => $id]));
    }

    /**
     * Update the specified State in storage.
     * PUT/PATCH /states/{id}.
     *
     * @param  int              $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var State $state */
        $state = $this->stateRepository->apiFindOrFail($id);

        $result = $this->stateRepository->updateRich($input, $id);

        $state = $state->fresh();

        return $this->sendResponse($state->toArray(), 'State updated successfully');
    }

    /**
     * Remove the specified State from storage.
     * DELETE /states/{id}.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->stateRepository->apiDeleteOrFail($id);

        return $this->sendResponse($id, 'State deleted successfully');
    }

    /*
     *
     * Altera status do registro
     *
     */
    public function toggle($id)
    {
        $register = $this->stateRepository->find($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
