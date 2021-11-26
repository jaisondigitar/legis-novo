<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\City;
use App\Models\People;
use App\Models\State;
use App\Models\TypesOfAttendance;
use App\Repositories\AttendanceRepository;
use Artesaos\Defender\Facades\Defender;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /** @var AttendanceRepository */
    private $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepo)
    {
        $this->attendanceRepository = $attendanceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     * @JsonFormat(shape = JsonFormat.Shape.STRING ,pattern = "dd-MM-YYYY hh:mm:ss" , timezone="UTC")
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('attendance.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $attendance = $this->attendanceRepository->getAll(0);

        return view('attendance.index')->with('attendance', $attendance);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('attendance.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $type = TypesOfAttendance::pluck('name', 'id')->prepend('Selecione..', '');

        $states = $this->statesList();
        $cities = City::where('state', '=', $states[1])->pluck('name', 'id');

        return view('attendance.create', compact('states', 'cities', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAttendanceRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateAttendanceRequest $request)
    {
        if (! Defender::hasPermission('attendance.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $people = People::firstOrCreate(
            ['cpf' => $request->cpf],
            ['name' => $request->name,
                'email' => $request->email,
                'celular' => $request->celular,
                'zipcode' => $request->zipcode,
                'street' => $request->street,
                'number' => $request->number,
                'complement' => $request->complement,
                'district' => $request->district,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id, ]
        );

        $input = $request->only([
            'date',
            'time',
            'description',
            'type_id',
        ]);

        $input['people_id'] = $people->id;

        $attendance = $this->attendanceRepository->create($input);

        flash('Atendimento salvo com sucesso.')->success();

        return redirect(route('attendance.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show($id)
    {
        if (! Defender::hasPermission('attendance.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $attendance = $this->attendanceRepository->findById($id);

        return view('attendance.show')->with('attendance', $attendance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    /*public function edit($id)
    {
        if (! Defender::hasPermission('attendance.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect('/');
        }
        $attendance = $this->attendanceRepository->findById($id);
        $type = TypesOfAttendance::pluck('name', 'id')->prepend('Selecione..', '');
        $states = $this->statesList();
        $cities = City::where('state', '=', $states[1])->pluck('name', 'id');
        return view('attendance.edit', compact('states', 'cities', 'type'))->with('attendance', $attendance);
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttendanceRequest $request
     * @param  int  $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    /*public function update(UpdateAttendanceRequest $request, $id)
    {
        if (! Defender::hasPermission('attendance.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect('/');
        }
        $attendance = $this->attendanceRepository->findById($id);
        $this->attendanceRepository->update($attendance, $request->all());
        return redirect(route('attendance.index'));
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        if (! Defender::hasPermission('attendance.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/');
        }

        $attendance = $this->attendanceRepository->findById($id);

        $this->attendanceRepository->delete($attendance);

        return redirect(route('attendance.index'));
    }
}