<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLogRequest;
use App\Http\Requests\UpdateLogRequest;
use App\Models\Log;
use App\Repositories\LogRepository;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class LogController extends AppBaseController
{
    /** @var  LogRepository */
    private $logRepository;

    public function __construct(LogRepository $logRepo)
    {
        $this->logRepository = $logRepo;
    }

    /**
     * Display a listing of the Log.
     *
     * @param $path
     * @return array|string[]
     */
    function getModels($path){
        $out = [0 => 'Selecione'];
        $results = scandir($path);

        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename =  $result;

            if (is_dir($filename)) {
                $out = array_merge($out, getModels($filename));
            }else{
                $out[] = substr($filename,0,-4);
            }
        }
        return $out;
    }

    public function index(Request $request)
    {
        if(!Defender::hasPermission('logs.index')) {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $path = app_path() . "/Models";
        $models = $this->getModels($path);
        $type = ['Selecione', 'created', 'updated', 'deleted'];

        $logs = Log::orderBy('created_at');

        if(count($request->all())){
            $model = str_replace(' ', '', 'App\Models\ '.$models[$request->owner_type]);

            !empty($request->user_id)    ?  $logs->where('user_id', $request->user_id) : null;
            !empty($request->owner_type)  ?  $logs->where('owner_type', $model ) : null;
            !empty($request->type)        ?  $logs->where('type', $type[$request->type] ) : null;
            !empty($request->year)        ?  $logs->where('created_at','like',$request->year."%") : null;
        }

        $logs = $logs->paginate(20);
        $path = app_path() . "/Models";
        $models = $this->getModels($path);


        return view('logs.index', compact('models', 'type'))
            ->with('form', $request)
            ->with('logs', $logs);
    }

    /**
     * Show the form for creating a new Log.
     *
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        if(!Defender::hasPermission('logs.create'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        return view('logs.create');
    }

    /**
     * Store a newly created Log in storage.
     *
     * @param CreateLogRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function store(CreateLogRequest $request)
    {
       if(!Defender::hasPermission('logs.create'))
       {
           flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
           return redirect("/");
       }
        $input = $request->all();

        $this->logRepository->create($input);

        flash('Registo salvo com sucesso.')->success();

        return redirect(route('logs.index'));
    }

    /**
     * Display the specified Log.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function show(int $id)
    {
        if(!Defender::hasPermission('logs.show'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $log = $this->logRepository->findByID($id);

        if (empty($log)) {
            flash('Registo não encontrado')->error();

            return redirect(route('logs.index'));
        }

        return view('logs.show')->with('log', $log);
    }

    /**
     * Show the form for editing the specified Log.
     *
     * @param int $id
     *
     * @return Application|Factory|Redirector|RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function edit(int $id)
    {
        if(!Defender::hasPermission('logs.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }
        $log = $this->logRepository->findByID($id);

        if (empty($log)) {
            flash('Registo não encontrado')->error();

            return redirect(route('logs.index'));
        }

        return view('logs.edit')->with('log', $log);
    }

    /**
     * Update the specified Log in storage.
     *
     * @param int $id
     * @param UpdateLogRequest $request
     *
     * @return Application|Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function update(int $id, UpdateLogRequest $request)
    {
        if(!Defender::hasPermission('logs.edit'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $log = $this->logRepository->findByID($id);

        if (empty($log)) {
            flash('Registo não encontrado')->error();

            return redirect(route('logs.index'));
        }

        $log = $this->logRepository->update($request->all(), $id);

        flash('Registo atualizado com sucesso.')->success();

        return redirect(route('logs.index'));
    }

    /**
     * Remove the specified Log from storage.
     *
     * @param int $id
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        if(!Defender::hasPermission('logs.delete'))
        {
            flash('Ops! Desculpe, você não possui permissão para esta ação.')->warning();
            return redirect("/");
        }

        $log = $this->logRepository->findByID($id);

        if (empty($log)) {
            flash('Registo não encontrado')->error();

            return redirect(route('logs.index'));
        }

        $this->logRepository->delete($id);

        flash('Registo removido com sucesso.')->success();

        return redirect(route('logs.index'));
    }

    /**
     * Update status of specified Log from storage.
     *
     * @param int $id
     * @throws BindingResolutionException
     */
    public function toggle(int $id){
        if(!Defender::hasPermission('logs.edit'))
        {
            return json_encode(false);
        }
        $register = $this->logRepository->findByID($id);
        $register->active = $register->active>0 ? 0 : 1;
        $register->save();
        return json_encode(true);
    }
}
