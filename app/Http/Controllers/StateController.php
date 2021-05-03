<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Libraries\Repositories\StateRepository;
use Flash;
use Response;

class StateController extends AppBaseController
{

	/** @var  StateRepository */
	private $stateRepository;

	function __construct(StateRepository $stateRepo)
	{
		$this->stateRepository = $stateRepo;
	}

	/**
	 * Display a listing of the State.
	 *
	 * @return Response
	 */
	public function index()
	{
		$states = $this->stateRepository->paginate(10);

		return view('states.index')
			->with('states', $states);
	}

	/**
	 * Show the form for creating a new State.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('states.create');
	}

	/**
	 * Store a newly created State in storage.
	 *
	 * @param CreateStateRequest $request
	 *
	 * @return Response
	 */
	public function store(CreateStateRequest $request)
	{
		$input = $request->all();

		$state = $this->stateRepository->create($input);

		Flash::success('Registro salvo com sucesso!');

		return redirect(route('states.index'));
	}

	/**
	 * Display the specified State.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$state = $this->stateRepository->find($id);

		if(empty($state))
		{
			Flash::error('Registro não existe.');

			return redirect(route('states.index'));
		}

		return view('states.show')->with('state', $state);
	}

	/**
	 * Show the form for editing the specified State.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$state = $this->stateRepository->find($id);

		if(empty($state))
		{
			Flash::error('Registro não existe.');

			return redirect(route('states.index'));
		}

		return view('states.edit')->with('state', $state);
	}

	/**
	 * Update the specified State in storage.
	 *
	 * @param  int              $id
	 * @param UpdateStateRequest $request
	 *
	 * @return Response
	 */
	public function update($id, UpdateStateRequest $request)
	{
		$state = $this->stateRepository->find($id);

		if(empty($state))
		{
			Flash::error('Registro não existe.');

			return redirect(route('states.index'));
		}

		$state = $this->stateRepository->updateRich($request->all(), $id);

		Flash::success('Registro editado com sucesso!');

		return redirect(route('states.index'));
	}

	/**
	 * Remove the specified State from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$state = $this->stateRepository->find($id);

		if(empty($state))
		{
			Flash::error('Registro não existe.');

			return redirect(route('states.index'));
		}

		$this->stateRepository->delete($id);

		Flash::success('Registro deletado com sucesso!');

		return redirect(route('states.index'));
	}

    /**
	 * Update status of specified State from storage.
	 *
	 * @param  int $id
	 *
	 * @return Json
	 */
	public function toggle($id){
            $register = $this->stateRepository->find($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }

    public function statesList(){
        return State::lists('name','id');
    }
}
