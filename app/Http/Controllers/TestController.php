<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateTestRequest;
use App\Http\Requests\UpdateTestRequest;
use App\Repositories\TestRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class TestController extends AppBaseController
{
    /** @var  TestRepository */
    private $testRepository;

    public function __construct(TestRepository $testRepo)
    {
        $this->testRepository = $testRepo;
    }

    /**
     * Display a listing of the Test.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('tests.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->testRepository->pushCriteria(new RequestCriteria($request));
        $tests = $this->testRepository->all();

        return view('$ROUTES_AS_PREFIX$tests.index')
            ->with('tests', $tests);
    }

    /**
     * Show the form for creating a new Test.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('tests.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('$ROUTES_AS_PREFIX$tests.create');
    }

    /**
     * Store a newly created Test in storage.
     *
     * @param CreateTestRequest $request
     *
     * @return Response
     */
    public function store(CreateTestRequest $request)
    {
       if(!Defender::hasPermission('tests.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $test = $this->testRepository->create($input);

        Flash::success('Test saved successfully.');

        return redirect(route('$ROUTES_AS_PREFIX$tests.index'));
    }

    /**
     * Display the specified Test.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('tests.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('tests.index'));
        }

        return view('$ROUTES_AS_PREFIX$tests.show')->with('test', $test);
    }

    /**
     * Show the form for editing the specified Test.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('tests.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('$ROUTES_AS_PREFIX$tests.index'));
        }

        return view('$ROUTES_AS_PREFIX$tests.edit')->with('test', $test);
    }

    /**
     * Update the specified Test in storage.
     *
     * @param  int              $id
     * @param UpdateTestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTestRequest $request)
    {
        if(!Defender::hasPermission('tests.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('$ROUTES_AS_PREFIX$tests.index'));
        }

        $test = $this->testRepository->update($request->all(), $id);

        Flash::success('Test updated successfully.');

        return redirect(route('$ROUTES_AS_PREFIX$tests.index'));
    }

    /**
     * Remove the specified Test from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('tests.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $test = $this->testRepository->findWithoutFail($id);

        if (empty($test)) {
            Flash::error('Test not found');

            return redirect(route('$ROUTES_AS_PREFIX$tests.index'));
        }

        $this->testRepository->delete($id);

        Flash::success('Test deleted successfully.');

        return redirect(route('$ROUTES_AS_PREFIX$tests.index'));
    }

    /**
    	 * Update status of specified Test from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('tests.edit'))
            {
                return json_encode(false);
            }
            $register = $this->testRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
