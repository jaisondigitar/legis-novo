<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdviceAwnserRequest;
use App\Http\Requests\UpdateAdviceAwnserRequest;
use App\Repositories\AdviceAwnserRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class AdviceAwnserController extends AppBaseController
{
    /** @var  AdviceAwnserRepository */
    private $adviceAwnserRepository;

    public function __construct(AdviceAwnserRepository $adviceAwnserRepo)
    {
        $this->adviceAwnserRepository = $adviceAwnserRepo;
    }

    /**
     * Display a listing of the AdviceAwnser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('adviceAwnsers.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->adviceAwnserRepository->pushCriteria(new RequestCriteria($request));
        $adviceAwnsers = $this->adviceAwnserRepository->all();

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.index')
            ->with('adviceAwnsers', $adviceAwnsers);
    }

    /**
     * Show the form for creating a new AdviceAwnser.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('adviceAwnsers.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.create');
    }

    /**
     * Store a newly created AdviceAwnser in storage.
     *
     * @param CreateAdviceAwnserRequest $request
     *
     * @return Response
     */
    public function store(CreateAdviceAwnserRequest $request)
    {
       if(!Defender::hasPermission('adviceAwnsers.create'))
       {
           Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
           return redirect("/");
       }
        $input = $request->all();

        $adviceAwnser = $this->adviceAwnserRepository->create($input);

        Flash::success('AdviceAwnser saved successfully.');

        return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
    }

    /**
     * Display the specified AdviceAwnser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('adviceAwnsers.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            Flash::error('AdviceAwnser not found');

            return redirect(route('adviceAwnsers.index'));
        }

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.show')->with('adviceAwnser', $adviceAwnser);
    }

    /**
     * Show the form for editing the specified AdviceAwnser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('adviceAwnsers.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            Flash::error('AdviceAwnser not found');

            return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
        }

        return view('$ROUTES_AS_PREFIX$adviceAwnsers.edit')->with('adviceAwnser', $adviceAwnser);
    }

    /**
     * Update the specified AdviceAwnser in storage.
     *
     * @param  int              $id
     * @param UpdateAdviceAwnserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdviceAwnserRequest $request)
    {
        if(!Defender::hasPermission('adviceAwnsers.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            Flash::error('AdviceAwnser not found');

            return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
        }

        $adviceAwnser = $this->adviceAwnserRepository->update($request->all(), $id);

        Flash::success('AdviceAwnser updated successfully.');

        return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
    }

    /**
     * Remove the specified AdviceAwnser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(!Defender::hasPermission('adviceAwnsers.delete'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $adviceAwnser = $this->adviceAwnserRepository->findWithoutFail($id);

        if (empty($adviceAwnser)) {
            Flash::error('AdviceAwnser not found');

            return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
        }

        $this->adviceAwnserRepository->delete($id);

        Flash::success('AdviceAwnser deleted successfully.');

        return redirect(route('$ROUTES_AS_PREFIX$adviceAwnsers.index'));
    }

    /**
    	 * Update status of specified AdviceAwnser from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('adviceAwnsers.edit'))
            {
                return json_encode(false);
            }
            $register = $this->adviceAwnserRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }
}
