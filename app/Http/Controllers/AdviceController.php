<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateAdviceRequest;
use App\Http\Requests\UpdateAdviceRequest;
use App\Models\Advice;
use App\Models\AdviceAwnser;
use App\Models\AdviceSituation;
use App\Models\ComissionSituation;
use App\Models\MeetingPauta;
use App\Repositories\AdviceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;
use Artesaos\Defender\Facades\Defender;

class AdviceController extends AppBaseController
{
    /** @var  AdviceRepository */
    private $adviceRepository;

    public function __construct(AdviceRepository $adviceRepo)
    {
        $this->adviceRepository = $adviceRepo;
    }

    /**
     * Display a listing of the Advice.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if(!Defender::hasPermission('advices.index')) {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $this->adviceRepository->pushCriteria(new RequestCriteria($request));
        $advices = $this->adviceRepository->all();

        return view('$ROUTES_AS_PREFIX$advices.index')
            ->with('advices', $advices);
    }

    /**
     * Show the form for creating a new Advice.
     *
     * @return Response
     */
    public function create()
    {
        if(!Defender::hasPermission('advices.create'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        return view('$ROUTES_AS_PREFIX$advices.create');
    }

    /**
     * Store a newly created Advice in storage.
     *
     * @param CreateAdviceRequest $request
     *
     * @return Response
     */
    public function store(CreateAdviceRequest $request)
    {
        $input = $request->all();

        $input['date'] = Carbon::now();

        $to_id = $input['to_id'];
        $type = $input['type'];

        $flag = 0;

        foreach($input['to_id'] as $key => $val){
            $advice = new Advice();
            $advice->date = $input['date'];
            $advice->type = $type[$key];
            $advice->to_id = $to_id[$key];
            $advice->laws_projects_id = isset($input['laws_projects_id']) ? $input['laws_projects_id'] : 0 ;
            $advice->document_id = $input['document_id'];
            $advice->description = $input['description'];

            if($advice->save()){
                $situation = ComissionSituation::first();
                AdviceSituation::create([
                    'advice_id' => $advice->id,
                    'comission_situation_id' => $situation->id
                ]);
                $flag = 1;
            }
        }

        if($flag) {
            return \GuzzleHttp\json_encode(true);
        }else{
            return json_encode(false);
        }

    }

    /**
     * Display the specified Advice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(!Defender::hasPermission('advices.show'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $advice = $this->adviceRepository->findWithoutFail($id);

        if (empty($advice)) {
            Flash::error('Advice not found');

            return redirect(route('advices.index'));
        }

        return view('$ROUTES_AS_PREFIX$advices.show')->with('advice', $advice);
    }

    /**
     * Show the form for editing the specified Advice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if(!Defender::hasPermission('advices.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }
        $advice = $this->adviceRepository->findWithoutFail($id);

        if (empty($advice)) {
            Flash::error('Advice not found');

            return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
        }

        return view('$ROUTES_AS_PREFIX$advices.edit')->with('advice', $advice);
    }

    /**
     * Update the specified Advice in storage.
     *
     * @param  int              $id
     * @param UpdateAdviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdviceRequest $request)
    {
        if(!Defender::hasPermission('advices.edit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

        $advice = $this->adviceRepository->findWithoutFail($id);

        if (empty($advice)) {
            Flash::error('Advice not found');

            return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
        }

        $advice = $this->adviceRepository->update($request->all(), $id);

        Flash::success('Advice updated successfully.');

        return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
    }

    /**
     * Remove the specified Advice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request )
    {
        $id = $request->id;

        if(Auth::user()->sector->name == 'Secretaria'){

            $advice = Advice::find($id);

            if (empty($advice) || MeetingPauta::where('advice_id', $advice->id)->get()->count > 0) {
                return json_encode(false);
            }

            if($this->adviceRepository->delete($id)){
                AdviceAwnser::where('advice_id', $id)->delete();
                return json_encode($id);
            }
        }else{
            return json_encode(false);
        }

//        if(!Defender::hasPermission('advices.delete'))
//        {
//            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
//            return redirect("/");
//        }

//        $advice = $this->adviceRepository->findWithoutFail($id);
//        $advice = Advice::find($id);
//        dd($advice);
//
//        if (empty($advice)) {
////            Flash::error('Advice not found');
////
////            return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
//            return json_encode(false);
//        }
//
//        if($this->adviceRepository->delete($id)){
//            return json_encode(true);
//        }
//
//        return json_encode(false);
//        Flash::success('Advice deleted successfully.');

//        return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
    }

    /**
    	 * Update status of specified Advice from storage.
    	 *
    	 * @param  int $id
    	 *
    	 * @return Json
    	 */
    	public function toggle($id){
            if(!Defender::hasPermission('advices.edit'))
            {
                return json_encode(false);
            }
            $register = $this->adviceRepository->findWithoutFail($id);
            $register->active = $register->active>0 ? 0 : 1;
            $register->save();
            return json_encode(true);
        }

    public function findAwnser(Request $request, $id){

        $obj = Advice::find($id);
        $commissions_situation = ComissionSituation::lists('name', 'id')->prepend('Selecione', 0);
//        dd($obj->project);

        return view('advices.advice_awnser', compact('commissions_situation'))->with('advice', $obj);
    }

    public function deleteAwnser($id)
    {
        $awnser = AdviceAwnser::find($id);

        if(!Defender::hasPermission('lawsProject.advicesDelete'))
        {
            return json_encode(false);
        }

        if($awnser){
            if($awnser->delete()){
                return json_encode($awnser);
            }
        }

        return json_encode(false);
    }

    public function removerAdvice(Request $request)
    {
        $id = $request->id;

        if(Auth::user()->sector->id == 1){

            $advice = Advice::find($id);

            if (empty($advice)) {
                return json_encode(false);
            }else{
                if($advice->awnser->count() == 0 ) {
                    $advice->delete();
                    return json_encode($id);
                }else{
                    return json_encode(false);
                }
            }
        }else{
            return json_encode(false);
        }

    }

    public function getAwnser($id)
    {
        $advice_awnsers = AdviceAwnser::find($id);
        if(!$advice_awnsers){
            return json_encode(false);
        }

        return json_encode($advice_awnsers);
    }

    public function awnserUpdate(Request $request)
    {
        if(!Defender::hasPermission('lawsProject.advicesEdit'))
        {
            Flash::warning('Ops! Desculpe, você não possui permissão para esta ação.');
            return redirect("/");
        }

       $input = $request->all();

       $awnser = AdviceAwnser::find($input['id']);

       if($awnser){
           $awnser->date = $input['date'];
           $awnser->commission_id = $input['situation_awnser'];
           $awnser->description = $input['description_awnser'];
           if($awnser->save()){
               if($request->file('Arquivo')) {
                   $file = $request['Arquivo'];
                   $extesion_img = strtolower($file->getClientOriginalExtension());
                   $image_file = uniqid() . time() . '.' . $extesion_img;

                   if($request->file('Arquivo')->move(base_path() . '/public/uploads/advice_awnser/', $image_file)) {
                       $awnser->file = $image_file;
                       $awnser->save();
                   }
               }
               Flash::success('Advice updated successfully.');
               return redirect(route('advices.find', $awnser->advice_id));
           }else{
               Flash::error('Advice not save.');
               return redirect(route('advices.find', $awnser->advice_id));
           }
       }else{
           Flash::error('Advice not found.');
           return redirect(route('advices.find', $awnser->advice_id));
       }

    }

    public function removeFile($id)
    {
        $awnser = AdviceAwnser::find($id);

        if($awnser){
            $file = (base_path() . '/public/uploads/advice_awnser/' . $awnser->file);
            $awnser->file = null;
            if($awnser->save()) {
                if (file_exists($file)) {
                    unlink($file);
                    return json_encode(true);
                }
            }
        }
        return json_encode(false);
    }
}
