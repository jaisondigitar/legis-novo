<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\City;
use App\Models\People;
use App\Models\Sector;
use App\Models\State;
use App\Models\TypesOfAttendance;
use App\Repositories\AttendanceRepository;
use App\Services\StorageService;
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
    private static $storageService;

    /** @var AttendanceRepository */
    private $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepo)
    {
        $this->attendanceRepository = $attendanceRepo;

        static::$storageService = new StorageService();
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
        $input = $request->all();
        $attendance_query = Attendance::ByDateDesc();

        if (count($request->all())) {
            if ($request->date) {
                if ($input['date']) {
                    $d1 = explode('/', $input['date']);
                    $request->date = $d1[2].'-'.$d1[1].'-'.$d1[0];
                }
            }
            ! empty($request->date) ? $attendance_query->where('date', 'like', $request->date) : null;
            ! empty($request->type_id) ? $attendance_query->where('type_id', $request->type_id) : null;
            ! empty($request->people_id) ? $attendance_query->where('people_id', $request->people_id) : null;
            ! empty($request->sector_id) ? $attendance_query->where('sector_id', $request->sector_id) : null;
        }

        if (! Defender::hasPermission('attendance.index')) {
            flash('Ops! Desculpe, voc?? n??o possui permiss??o para esta a????o.')->warning();

            return redirect('/admin');
        }

        $attendance_query->parecer = $request->parecer;

        $attendance = $attendance_query
            ->orderByDesc('created_at')
            ->paginate(20);

        $type = TypesOfAttendance::pluck('name', 'id')->prepend('Selecione..', '');
        $sector = Sector::pluck('name', 'id')->prepend('Selecione..', '');
        $people = People::pluck('name', 'id')->prepend('Selecione..', '');

        return view('attendance.index', compact('type', 'sector', 'people'))
            ->with('form', $request)
            ->with('attendance', $attendance);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     */
    public function create()
    {
        if (! Defender::hasPermission('attendance.create')) {
            flash('Ops! Desculpe, voc?? n??o possui permiss??o para esta a????o.')->warning();

            return redirect('/admin');
        }
        $type = TypesOfAttendance::where('active', 1)->orderBy('name')->pluck('name', 'id')->prepend('Selecione..', '');

        $sector = Sector::pluck('name', 'id')->prepend('Selecione..', '');

        $states = $this->statesList();
        $state = State::find(12);
        $cities = City::where('state', '=', $state->uf)->pluck('name', 'id');

        return view('attendance.create', compact('states', 'cities', 'type', 'sector'));
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
            flash('Ops! Desculpe, voc?? n??o possui permiss??o para esta a????o.')->warning();

            return redirect('/admin');
        }

        $image = $request->file('image');
        $attendance_data = $request->only(['date', 'time', 'sector_id', 'description', 'type_id']);

        $people = People::firstOrCreate(
            ['name' => $request->name],
            [
                'cpf' => $request->cpf,
                'rg' => $request->rg,
                'name' => $request->name,
                'celular' => $request->celular,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'zipcode' => $request->zipcode,
                'street' => $request->street,
                'number' => $request->number,
                'complement' => $request->complement,
                'district' => $request->district,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
            ]
        );

        if ($image) {
            $filename = static::$storageService
                ->inPeopleFolder()
                ->sendFile($image)
                ->send();

            $people->image = $filename;
            $people->save();
        }

        $attendance_data['people_id'] = $people->id;

        $this->attendanceRepository->create($attendance_data);

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
            flash('Ops! Desculpe, voc?? n??o possui permiss??o para esta a????o.')->warning();

            return redirect('/admin');
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
    public function edit($id)
    {
        if (! Defender::hasPermission('attendance.edit')) {
            flash('Ops! Desculpe, voc?? n??o possui permiss??o para esta a????o.')->warning();

            return redirect('/');
        }
        $attendance = $this->attendanceRepository->findById($id);

        $people = People::find($attendance->people_id);

        $type = TypesOfAttendance::where('active', 1)->orderBy('name')->pluck('name', 'id')->prepend('Selecione..', '');

        $sector = Sector::pluck('name', 'id')->prepend('Selecione..', '');

        $states = $this->statesList();
        $state = State::find(12);
        $cities = City::where('state', '=', $state->uf)->pluck('name', 'id');

        return view('attendance.edit', compact('states', 'cities', 'type', 'sector'))
            ->with('attendance', $attendance)
            ->with('people', $people);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAttendanceRequest $request
     * @param  int  $id
     *
     * @return false|Application|RedirectResponse|Redirector|string
     * @throws BindingResolutionException
     */
    public function update(UpdateAttendanceRequest $request, $id)
    {
//        dd($request->all());

        if (! Defender::hasPermission('attendance.edit')) {
            flash('Ops! Desculpe, voc?? n??o possui permiss??o para esta a????o.')->warning();

            return redirect('/');
        }

        People::where('celular', $request->get('celular'))
            ->update($request->only([
                'cpf',
                'rg',
                'name',
                'celular',
                'telephone',
                'email',
                'zipcode',
                'street',
                'number',
                'complement',
                'district',
                'state_id',
                'city_id',
            ]));

        $attendance = $this->attendanceRepository->findById($id);

        $this->attendanceRepository->update($attendance, $request->all());

        if ($request->ajax()) {
            return json_encode(['success' => true]);
        }

        return redirect(route('attendance.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy($id, Request $request)
    {
        if (! Defender::hasPermission('attendance.delete')) {
            flash('Ops! Desculpe, voc?? n??o possui permiss??o para esta a????o.')->warning();

            return redirect('/admin');
        }

        $attendance = $this->attendanceRepository->findById($id);

        $this->attendanceRepository->delete($attendance);

        if ($request->ajax()) {
            return 'success';
        }

        return redirect(route('attendance.index'));
    }
}
