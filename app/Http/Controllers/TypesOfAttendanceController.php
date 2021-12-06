<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTypesOfAttendanceRequest;
use App\Http\Requests\UpdateTypesOfAttendanceRequest;
use App\Repositories\TypesOfAttendanceRepository;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;

class TypesOfAttendanceController extends Controller
{
    private $typesOfAttendanceRepository;

    public function __construct(TypesOfAttendanceRepository $typesOfAttendanceRepo)
    {
        $this->typesOfAttendanceRepository = $typesOfAttendanceRepo;
    }

    public function index()
    {
        if (! Defender::hasPermission('typesOfAttendance.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $typesOfAttendance = $this->typesOfAttendanceRepository->getAll(0);

        return view('typesOfAttendance.index')->with('typesOfAttendance', $typesOfAttendance);
    }

    public function create()
    {
        if (! Defender::hasPermission('typesOfAttendance.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        return view('typesOfAttendance.create');
    }

    public function store(CreateTypesOfAttendanceRequest $request)
    {
        if (! Defender::hasPermission('typesOfAttendance.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $input = $request->all();

        $types_of_attendance = $this->typesOfAttendanceRepository->create($input);

        flash('Tipo de atendimento salvo com sucesso.')->success();

        return redirect(route('typesOfAttendance.index'));
    }

    public function show($id)
    {
        if (! Defender::hasPermission('typesOfAttendance.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $types_of_attendance = $this->typesOfAttendanceRepository->findById($id);

        return view('typesOfAttendance.show')->with('types_of_attendance', $types_of_attendance);
    }

    public function edit($id)
    {
        if (! Defender::hasPermission('parties.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $types_of_attendance = $this->typesOfAttendanceRepository->findById($id);

        return view('typesOfAttendance.edit')->with('types_of_attendance', $types_of_attendance);
    }

    public function update(CreateTypesOfAttendanceRequest $request, $id)
    {
        if (! Defender::hasPermission('parties.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $types_of_attendance = $this->typesOfAttendanceRepository->findById($id);

        $this->typesOfAttendanceRepository->update($types_of_attendance, $request->all());

        return redirect(route('typesOfAttendance.index'));
    }

    public function destroy($id)
    {
        if (! Defender::hasPermission('parties.delete')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $types_of_attendance = $this->typesOfAttendanceRepository->findById($id);

        $this->typesOfAttendanceRepository->delete($types_of_attendance);

        return redirect(route('typesOfAttendance.index'));
    }
}
