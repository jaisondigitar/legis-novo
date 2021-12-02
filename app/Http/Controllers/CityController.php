<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Libraries\Repositories\CityRepository;
use App\Models\City;
use App\Models\State;
use Flash;
use Illuminate\Http\Request;
use Response;

class CityController extends AppBaseController
{
    /** @var CityRepository */
    private $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
    }

    /**
     * Display a listing of the City.
     *
     * @return Response
     */
    public function index()
    {
        $cities = $this->cityRepository->paginate(10);

        return view('cities.index')
            ->with('cities', $cities);
    }

    /**
     * Show the form for creating a new City.
     *
     * @return Response
     */
    public function create()
    {
        return view('cities.create');
    }

    /**
     * Store a newly created City in storage.
     *
     * @param CreateCityRequest $request
     *
     * @return Response
     */
    public function store(CreateCityRequest $request)
    {
        $input = $request->all();

        $city = $this->cityRepository->create($input);

        flash('Registro salvo com sucesso!')->success();

        return redirect(route('cities.index'));
    }

    /**
     * Display the specified City.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            flash('Registro não existe.')->error();

            return redirect(route('cities.index'));
        }

        return view('cities.show')->with('city', $city);
    }

    /**
     * Show the form for editing the specified City.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            flash('Registro não existe.')->error();

            return redirect(route('cities.index'));
        }

        return view('cities.edit')->with('city', $city);
    }

    /**
     * Update the specified City in storage.
     *
     * @param  int              $id
     * @param UpdateCityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCityRequest $request)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            flash('Registro não existe.')->error();

            return redirect(route('cities.index'));
        }

        $city = $this->cityRepository->updateRich($request->all(), $id);

        flash('Registro editado com sucesso!')->success();

        return redirect(route('cities.index'));
    }

    /**
     * Remove the specified City from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            flash('Registro não existe.')->error();

            return redirect(route('cities.index'));
        }

        $this->cityRepository->delete($id);

        flash('Registro deletado com sucesso!')->success();

        return redirect(route('cities.index'));
    }

    /**
     * Update status of specified City from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        $register = $this->cityRepository->find($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function getByUf($id)
    {
        $state = State::find($id);
        $cities = City::where('state', '=', $state->uf)->get();

        return json_encode($cities);
    }
}
