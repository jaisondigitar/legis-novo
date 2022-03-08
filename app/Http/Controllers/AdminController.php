<?php

namespace App\Http\Controllers;

use App\Jobs\DocumentJob;
use App\Jobs\LawProjectJob;
use App\Models\Advice;
use App\Models\AdviceAwnser;
use App\Models\AdviceSituation;
use App\Models\Assemblyman;
use App\Models\ComissionSituation;
use App\Models\Commission;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\LawsProject;
use App\Models\LawsType;
use App\Models\UserAssemblyman;
use App\Services\StorageService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends AppBaseController
{
    use DispatchesJobs;

    /**
     * @var
     */
    private static $uploadService;

    public function __construct()
    {
        static::$uploadService = new StorageService();
    }

    public function dashboard()
    {
        $law_types = LawsType::where('is_active', true)->pluck('name', 'id');
        $documentType = DocumentType::where('parent_id', 0)->pluck('name', 'id');

        $gabs = UserAssemblyman::where('users_id', Auth::user()->id)->get();

        $gabIds = $this->getAssembbyIds($gabs);

        $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)->get();

        $ids = UserAssemblyman::where('users_id', Auth::user()->id)->pluck('assemblyman_id')
            ->toArray();
        $assemblyman_list = Assemblyman::whereIn('id', $ids)->pluck('short_name', 'id')->prepend('Selecione', 0);

        $tmp = null;
        $commissions = null;

        if (Auth::user()->sector_id == 1) {
            $commissions = Commission::active()->get();
        } else {
            foreach ($assemblymens as $assemblymen) {
                foreach ($assemblymen->assemblyman->commision_assemblyman as $p) {
                    foreach ($p->commissions as $commition) {
                        $commissions[] = $commition;
                    }
                }
            }
        }

        $commissions_situation = ComissionSituation::pluck('name', 'id')->prepend('Selecione', 0);

        $projLeiAll = count(LawsProject::all());
        $projLeiApr = count(LawsProject::approved()->get());
        $projLeiRead = count(LawsProject::unRead()->get());

        $docAll = count(Document::all());
        $docRead = count(Document::where('read', 1)->get());

        $countType = $law_types->mapWithKeys(function ($item, $key) {
            return collect([
                $item => collect([
                    'id' => $key,
                    'count' => LawsProject::where('law_type_id', $key)->count(),
                ]),
            ]);
        });

        $countDoc = $documentType->mapWithKeys(function ($item, $key) {
            return collect([
                $item => collect([
                    'id' => $key,
                    'count' => Document::where('document_type_id', $key)->count(),
                ]),
            ]);
        });

        return view('admin.index', compact(
            'projLeiAll',
            'projLeiApr',
            'projLeiRead',
            'docAll',
            'docRead',
            'commissions',
            'commissions_situation',
            'assemblyman_list',
            'countType',
            'countDoc',
        ));
    }

    public function commissions()
    {
        $gabs = UserAssemblyman::where('users_id', Auth::user()->id)->get();
        $gabIds = $this->getAssembbyIds($gabs);

        $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)->get();

        $ids = UserAssemblyman::where('users_id', Auth::user()->id)->pluck('assemblyman_id')
            ->toArray();
        $assemblyman_list = Assemblyman::whereIn('id', $ids)->plucK('short_name', 'id')->prepend('Selecione', 0);

        $tmp = null;
        $commissions = null;

        if (Auth::user()->sector_id == 1) {
            $commissions = Commission::active()->get();
        } else {
            foreach ($assemblymens as $assemblymen) {
                foreach ($assemblymen->assemblyman->commision_assemblyman as $p) {
                    foreach ($p->commissions as $commition) {
                        $commissions[] = $commition;
                    }
                }
            }
        }

        $commissions_situation = ComissionSituation::pluck('name', 'id')->prepend('Selecione', 0);

        return view('admin.commissions', compact(
            'commissions',
            'commissions_situation',
            'assemblyman_list'
        ));
    }

    public function showLaw($id)
    {
        $gabs = UserAssemblyman::where('users_id', Auth::user()->id)->get();
        $gabIds = $this->getAssembbyIds($gabs);

        $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)->get();

        $ids = UserAssemblyman::where('users_id', Auth::user()->id)->pluck('assemblyman_id')
            ->toArray();
        $assemblyman_list = Assemblyman::whereIn('id', $ids)->pluck('short_name', 'id')->prepend('Selecione', 0);

        $commissions_situation = ComissionSituation::pluck('name', 'id')->prepend('Selecione', 0);

        $commissions = Commission::find($id);
        $commissions->type = 'Projeto de lei';

        $advices = Advice::where('to_id', $id)->where('closed', 1)
            ->whereNotNull('laws_projects_id')
            ->where('document_id', 0)
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.show', compact(
            'commissions',
            'commissions_situation',
            'assemblyman_list',
            'advices'
        ));
    }

    public function showDocument($id)
    {
        $gabs = UserAssemblyman::where('users_id', Auth::user()->id)->get();
        $gabIds = $this->getAssembbyIds($gabs);

        $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)->get();

        $ids = UserAssemblyman::where('users_id', Auth::user()->id)->pluck('assemblyman_id')
            ->toArray();
        $assemblyman_list = Assemblyman::whereIn('id', $ids)->pluck('short_name', 'id')->prepend('Selecione', 0);

        $commissions_situation = ComissionSituation::pluck('name', 'id')->prepend('Selecione', 0);

        $commissions = Commission::find($id);
        $commissions->type = 'Documentos';

        $advices = Advice::where('to_id', $id)->where('closed', 1)->whereNotNull('document_id')->where('laws_projects_id', 0)->get();

        return view('admin.show', compact(
            'commissions',
            'commissions_situation',
            'assemblyman_list',
            'advices'
        ));
    }

    public function showClose($id)
    {
        $gabs = UserAssemblyman::where('users_id', Auth::user()->id)->get();
        $gabIds = $this->getAssembbyIds($gabs);

        $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)->get();

        $ids = UserAssemblyman::where('users_id', Auth::user()->id)->pluck('assemblyman_id')
            ->toArray();
        $assemblyman_list = Assemblyman::whereIn('id', $ids)->pluck('short_name', 'id')->prepend('Selecione', 0);

        $commissions_situation = ComissionSituation::pluck('name', 'id')->prepend('Selecione', 0);

        $commissions = Commission::find($id);
        $commissions->type = 'Documentos';

        $advices = Advice::where('to_id', $id)->where('closed', 0)->whereNotNull('document_id')->whereNotNull('laws_projects_id')->get();

        return view('admin.show', compact(
            'commissions',
            'commissions_situation',
            'assemblyman_list',
            'advices'
        ));
    }

    public function findAdvice(Request $request)
    {
        $data = $request->all();
        $obj = Advice::where('id', $data['id'])->with('document')->with('project')->first();

        $obj1 = AdviceAwnser::find($data['id']);

        if ($obj) {
            return json_encode($obj);
        }

        return json_encode(false);
    }

    public function saveAdvice(Request $request)
    {
        $assemblymens = UserAssemblyman::where('users_id', Auth::user()->id)->get();

        $tmp = null;
        $commissions = null;

        if (Auth::user()->sector_id == 1) {
            $commissions = Commission::active()->get();
            $request->closed = isset($request->closed) ? 0 : 1;

            if ($request->closed == 0) {
                $advice = Advice::find($request->id);
                if ($advice) {
                    $advice->closed = 0;
                    $advice->save();
                }
            }
        } else {
            foreach ($assemblymens as $assemblymen) {
                foreach ($assemblymen->assemblyman->commision_assemblyman as $p) {
                    foreach ($p->commissions as $commition) {
                        $commissions[] = $commition;
                    }
                }
            }
        }
//
//        foreach($assemblymens as $assemblymen){
//            foreach ($assemblymen->assemblyman->commision_assemblyman as $p) {
//                $commissions[] = $p->commissions;
//            }
//        }

        $commissions_situation = ComissionSituation::pluck('name', 'id')->prepend('Selecione', 0);

        $projLeiAll = count(LawsProject::all());
        $projLeiApr = count(LawsProject::approved()->get());
        $projLeiRead = count(LawsProject::unRead()->get());

        $docAll = count(Document::all());
        $docRead = count(Document::where('read', 1)->get());

        $input = $request->all();

        $obj = new AdviceAwnser();

        $obj->advice_id = $input['id'];
        $obj->commission_id = $input['situationP'];

        $obj->date = date('d/m/Y', strtotime($input['date']));
        $obj->description = $input['desc'];
        $obj->file = '';

        if ($obj->save()) {
            $adv = new AdviceSituation();
            $adv->advice_id = $obj->advice_id;
            $adv->comission_situation_id = $obj->commission_id;
            $adv->save();

            $file = $request->file('Arquivo');

            if ($file) {
                $filename = static::$uploadService
                    ->inAdvicesFolder()
                    ->sendFile($file)
                    ->send();

                $obj->file = $filename;
                $obj->save();

                /*if ($request->file('Arquivo')->move(base_path().'/public/uploads/advice_awnser/', $image_file)) {
                    $obj->file = $filename;
                    $obj->save();
                }*/
            }
        }

        flash('Informar parecer salvo com sucesso.')->success();

        return redirect(route('admin.showLaw', $input['commission_id']))->with([
            'projLeiAll',
            'projLeiApr',
            'projLeiRead',
            'docAll',
            'docRead',
            'commissions',
            'commissions_situation',
        ]);
    }

    public function exportFiles()
    {
        return view('admin.exportFiles');
    }

    public function exportFilesDocuments()
    {
        dispatch(new DocumentJob());

        return redirect(route('export.files'));
    }

    public function exportFilesZip()
    {
        $files = glob(public_path('exportacao/documentos'));

        \Chumper\Zipper\Facades\Zipper::make(public_path('exportacao/documentos-compactados.zip'))->add($files)->close();

        return redirect(route('export.files'));
    }

    public function exportFilesLaws()
    {
        dispatch(new LawProjectJob());

        return redirect(route('export.files'));
    }

    public function exportFilesLawsZip()
    {
        $files = glob(public_path('exportacao/projetoLei'));

        \Chumper\Zipper\Facades\Zipper::make(public_path('exportacao/projetoLei-compactados.zip'))->add($files)->close();

        return redirect(route('export.files'));
    }
}
