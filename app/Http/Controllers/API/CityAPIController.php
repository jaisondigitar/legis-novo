<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Libraries\Repositories\CityRepository;
use app\Models\City;
use Illuminate\Http\Request;
use Mitul\Controller\AppBaseController as AppBaseController;
use Response;

class CityAPIController extends AppBaseController
{
    /** @var CityRepository */
    private $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
    }

    /**
     * Display a listing of the City.
     * GET|HEAD /cities.
     *
     * @return Response
     */
    public function index()
    {
        $cities = $this->cityRepository->all();

        return $this->sendResponse($cities->toArray(), 'Cities retrieved successfully');
    }

    /**
     * Show the form for creating a new City.
     * GET|HEAD /cities/create.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created City in storage.
     * POST /cities.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if (count(City::$rules) > 0) {
            $this->validateRequestOrFail($request, City::$rules);
        }

        $input = $request->all();

        $cities = $this->cityRepository->create($input);

        return $this->sendResponse($cities->toArray(), 'City saved successfully');
    }

    /**
     * Display the specified City.
     * GET|HEAD /cities/{id}.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $city = $this->cityRepository->apiFindOrFail($id);

        return $this->sendResponse($city->toArray(), 'City retrieved successfully');
    }

    /**
     * Show the form for editing the specified City.
     * GET|HEAD /cities/{id}/edit.
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
     * Update the specified City in storage.
     * PUT/PATCH /cities/{id}.
     *
     * @param  int              $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var City $city */
        $city = $this->cityRepository->apiFindOrFail($id);

        $result = $this->cityRepository->updateRich($input, $id);

        $city = $city->fresh();

        return $this->sendResponse($city->toArray(), 'City updated successfully');
    }

    /**
     * Remove the specified City from storage.
     * DELETE /cities/{id}.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->cityRepository->apiDeleteOrFail($id);

        return $this->sendResponse($id, 'City deleted successfully');
    }

    /*
     *
     * Altera status do registro
     *
     */
    public function toggle($id)
    {
        $register = $this->cityRepository->find($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
