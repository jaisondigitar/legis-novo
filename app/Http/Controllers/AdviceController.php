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
use App\Models\Processing;
use App\Repositories\AdviceRepository;
use App\Services\StorageService;
use Artesaos\Defender\Facades\Defender;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdviceController extends AppBaseController
{
    /**
     * @var
     */
    private static $uploadService;

    /** @var AdviceRepository */
    private $adviceRepository;

    public function __construct(AdviceRepository $adviceRepo)
    {
        $this->adviceRepository = $adviceRepo;

        static::$uploadService = new StorageService();
    }

    /**
     * Display a listing of the Advice.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (! Defender::hasPermission('advices.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
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
        if (! Defender::hasPermission('advices.create')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
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

        $date_end = isset($input['date_end']) ? Carbon::createFromFormat('d/m/Y', $input['date_end']) : null;
        $legal_option = isset($input['legal_option']) ? $input['legal_option'] : null;

        $to_id = $input['to_id'];
        $type = $input['type'];

        $flag = 0;

        foreach ($input['to_id'] as $key => $val) {
            $advice = new Advice();
            $advice->date = $input['date'];
            $advice->type = $type[$key];
            $advice->to_id = $to_id[$key];
            $advice->laws_projects_id = $input['laws_projects_id'] ?? 0;
            $advice->document_id = $input['document_id'];
            $advice->legal_option = $legal_option;
            $advice->description = $input['description'];
            $advice->date_end = $date_end;

            if ($advice->save()) {
                $situation = ComissionSituation::first();
                AdviceSituation::create([
                    'advice_id' => $advice->id,
                    'comission_situation_id' => $situation->id,
                ]);

                $processing = new Processing();
                $processing->law_projects_id = $input['laws_projects_id'];
                $processing->advice_publication_id = null;
                $processing->advice_situation_id = 1;
                $processing->status_processing_law_id = 8;
                $processing->processing_date = Carbon::now()->format('d/m/Y');
                $processing->destination_id = 5;
                $processing->date_end = $date_end->format('d/m/Y');
                $processing->save();

                $flag = 1;
            }
        }

        if ($flag) {
            return \GuzzleHttp\json_encode(true);
        } else {
            return json_encode(false);
        }
    }

    public function createAdviceReplica(Request $request)
    {
        $input = $request->all();

        $input['date'] = Carbon::now();
        $date_end = isset($input['date_end']) ? Carbon::createFromFormat('d/m/Y', $input['date_end']) : null;
        $legal_option = isset($input['legal_option']) ? $input['legal_option'] : null;

        $to_id = $input['to_id'];
        $type = $input['type'];

        foreach ($input['to_id'] as $key => $val) {
            $advice = new Advice();
            $advice->date = $input['date'];
            $advice->type = $type[$key];
            $advice->to_id = $to_id[$key];
            $advice->laws_projects_id = $input['laws_projects_id'];
            $advice->document_id = $input['document_id'];
            $advice->legal_option = $legal_option;
            $advice->description = $input['description'];
            $advice->date_end = $date_end;
            $advice->advice_id = $input['id'] ?? null;

            if ($advice->save()) {
                $situation = ComissionSituation::first();
                AdviceSituation::create([
                    'advice_id' => $advice->id,
                    'comission_situation_id' => $situation->id,
                ]);

                $file = $request->file('file');

                if ($file) {
                    // TODO descomentar e remover $filename = 'teste.txt';
//                    $filename = static::$uploadService
//                        ->inAdvicesFolder()
//                        ->sendFile($file)
//                        ->send();

                    $filename = 'teste.txt';
                    $advice->file = $filename;
                    $advice->save();
                }
            }
        }

        return Redirect(route('lawsProjects.legal-option', $input['laws_projects_id']));
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
        if (! Defender::hasPermission('advices.show')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advice = $this->adviceRepository->findWithoutFail($id);

        if (empty($advice)) {
            flash('Aconselhamento não encontrado')->error();

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
        if (! Defender::hasPermission('advices.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }
        $advice = $this->adviceRepository->findWithoutFail($id);

        if (empty($advice)) {
            flash('Aconselhamento não encontrado')->error();

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
        if (! Defender::hasPermission('advices.edit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $advice = $this->adviceRepository->findWithoutFail($id);

        if (empty($advice)) {
            flash('Aconselhamento não encontrado')->error();

            return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
        }

        $advice = $this->adviceRepository->update($request->all(), $id);

        flash('Aconselhamento atualizado com sucesso.')->success();

        return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
    }

    /**
     * Remove the specified Advice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        if (Auth::user()->sector->name == 'Secretaria') {
            $advice = Advice::find($id);

            if (empty($advice) || MeetingPauta::where('advice_id', $advice->id)->get()->count > 0) {
                return json_encode(false);
            }

            if ($this->adviceRepository->delete($id)) {
                AdviceAwnser::where('advice_id', $id)->delete();

                return json_encode($id);
            }
        } else {
            return json_encode(false);
        }

//        if(!Defender::hasPermission('advices.delete'))
//        {
//            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning(;
//            return redirect("/");
//        }

//        $advice = $this->adviceRepository->findWithoutFail($id);
//        $advice = Advice::find($id);
//        dd($advice);
//
//        if (empty($advice)) {
////            flash('Aconselhamento não encontrado')->error(;
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
//        flash('Aconselhamento removido com sucesso.')->success();

//        return redirect(route('$ROUTES_AS_PREFIX$advices.index'));
    }

    /**
     * Update status of specified Advice from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        if (! Defender::hasPermission('advices.edit')) {
            return json_encode(false);
        }
        $register = $this->adviceRepository->findWithoutFail($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }

    public function findAwnser(int $id)
    {
        $obj = Advice::find($id);

        $commissions_situation = ComissionSituation::pluck('name', 'id')->prepend('Selecione', 0);

        return view('advices.advice_awnser', compact('commissions_situation'))->with('advice', $obj);
    }

    public function deleteAwnser($id)
    {
        $awnser = AdviceAwnser::find($id);

        if (! Defender::hasPermission('lawsProject.advicesDelete')) {
            return json_encode(false);
        }

        if ($awnser) {
            if ($awnser->delete()) {
                return json_encode($awnser);
            }
        }

        return json_encode(false);
    }

    public function removerAdvice(Request $request)
    {
        $id = $request->id;

        if (Auth::user()->sector->id == 1) {
            $advice = Advice::find($id);

            if (empty($advice)) {
                return json_encode(false);
            } else {
                if ($advice->awnser->count() == 0) {
                    $advice->delete();

                    return json_encode($id);
                } else {
                    return json_encode(false);
                }
            }
        } else {
            return json_encode(false);
        }
    }

    public function getAwnser($id)
    {
        $advice_awnsers = AdviceAwnser::find($id);
        if (! $advice_awnsers) {
            return json_encode(false);
        }

        return json_encode($advice_awnsers);
    }

    public function awnserUpdate(Request $request)
    {
        if (! Defender::hasPermission('lawsProject.advicesEdit')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();

            return redirect('/admin');
        }

        $input = $request->all();

        $awnser = AdviceAwnser::find($input['id']);

        if ($awnser) {
            $awnser->date = $input['date'];
            $awnser->commission_id = $input['situation_awnser'];
            $awnser->description = $input['description_awnser'];
            if ($awnser->save()) {
                $file = $request->file('Arquivo');

                if ($file) {
                    $filename = static::$uploadService
                        ->inAdvicesFolder()
                        ->sendFile($file)
                        ->send();

                    $awnser->file = $filename;
                    $awnser->save();

                    /*if ($request->file('Arquivo')->move(base_path().'/public/uploads/advice_awnser/', $image_file)) {
                        $awnser->file = $image_file;
                        $awnser->save();
                    }*/
                }
                flash('Aconselhamento atualizado com sucesso.')->success();

                return redirect(route('advices.find', $awnser->advice_id));
            } else {
                flash('Aconselhamento não salvo.')->error();

                return redirect(route('advices.find', $awnser->advice_id));
            }
        } else {
            flash('Aconselhamento não encontrado.')->error();

            return redirect(route('advices.find', $awnser->advice_id));
        }
    }

    public function removeFile($id)
    {
        $awnser = AdviceAwnser::find($id);

        if ($awnser) {
            $file = (base_path().'/public/uploads/advice_awnser/'.$awnser->file);
            $awnser->file = null;
            if ($awnser->save()) {
                if (file_exists($file)) {
                    unlink($file);

                    return json_encode(true);
                }
            }
        }

        return json_encode(false);
    }
}
