<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Assemblyman;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\LawsProject;
use App\Models\Meeting;
use App\Models\Parameters;
use App\Models\PartiesAssemblyman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $parameter = Parameters::where('slug', 'exibe-apenas-documentos-lidos-no-portal')->first();
        $download = Parameters::where('slug', 'mostra-anexo-de-documentos-no-front')->first();
        $atas = Parameters::where('slug', 'mostra-atas-no-front')->first()->value;
        $pautas = Parameters::where('slug', 'mostra-pautas-no-front')->first()->value;

        $frontParams = [
          'showAtas' => $atas,
          'showPautas' => $pautas,
        ];

        $docTypes = $this->getDocumentTypes();

        if (count($request->all())) {
            if ($request->documents) {
                $documents = Document::byDateDesc();

                ! empty($request->number) ? $documents->where('number', $request->number) : null;
                ! empty($request->year) ? $documents->where('date', 'like', $request->year.'%') : null;
                ! empty($request->owner) ? $documents->where('owner_id', $request->owner) : null;

                if (! empty($request->text)) {
                    $key_word = explode(' ', $request->text);

                    $frase = isset($request->frase);

                    $documents->where(function ($query) use ($key_word, $frase, $request) {
                        if ($frase) {
                            $query->where('content', 'like', '%'.$request->text.'%');
                        } else {
                            foreach ($key_word as $key => $value) {
                                $key == 0 ? $query->where('content', 'like', '%'.$value.'%') : $query->orWhere('content', 'like', '%'.$value.'%');
                            }
                        }
                    });
                }

                if (! empty($request->type)) {
                    $type = DocumentType::find($request->type);

                    if ($type->hasChilds()) {
                        $documents->whereIN('document_type_id', $type->getChildsIds());
                    } else {
                        $documents->where('document_type_id', $request->type);
                    }
                }

                if ($parameter->value == 1) {
                    $documents->where('read', 1);
                }

                $documents = $documents->paginate(20);
            }

            if ($request->projects) {
                $documents = LawsProject::byDateDesc();
                ! empty($request->reg) ? $documents->where('updated_at', date('Y-m-d H:i:s', $request->reg)) : null;
                ! empty($request->type) ? $documents->where('law_type_id', $request->type) : null;
                ! empty($request->number) ? $documents->where('project_number', $request->number) : null;
                ! empty($request->year) ? $documents->where('law_date', 'like', $request->year.'%') : null;
                ! empty($request->owner) ? $documents->where('assemblyman_id', $request->owner) : null;

                if (! empty($request->text)) {
                    $key_word = explode(' ', $request->text);

                    $frase = isset($request->frase);

                    $documents->where(function ($query) use ($key_word, $frase, $request) {
                        if ($frase) {
                            $query->where('title', 'like', '%'.$request->text.'%')
                                  ->orWhere('sub_title', 'like', '%'.$request->text.'%')
                                  ->orWhere('sufix', 'like', '%'.$request->text.'%')
                                  ->orWhere('justify', 'like', '%'.$request->text.'%');
                        } else {
                            foreach ($key_word as $key => $value) {
                                $key == 0 ?
                                    $query->where('title', 'like', '%'.$value.'%')
                                        ->orWhere('sub_title', 'like', '%'.$key_word[$key].'%')
                                        ->orWhere('sufix', 'like', '%'.$key_word[$key].'%')
                                        ->orWhere('justify', 'like', '%'.$key_word[$key].'%') :
                                    $query->orWhere('title', 'like', '%'.$value.'%')
                                        ->orWhere('sub_title', 'like', '%'.$key_word[$key].'%')
                                        ->orWhere('sufix', 'like', '%'.$key_word[$key].'%')
                                        ->orWhere('justify', 'like', '%'.$key_word[$key].'%');
                            }
                        }
                    });
                }

                if ($parameter->value == 1) {
                    $documents->where('is_read', 1);
                }

                $documents = $documents->paginate(20);
            }

            if ($request->atas) {
                $documents = Meeting::byDateDesc();

                ! empty($request->data) ? $documents
                        ->whereDay('date_start', '=', date('d', strtotime(Carbon::createFromFormat('d/m/Y', $request->data))))
                        ->whereMonth('date_start', '=', date('m', strtotime(Carbon::createFromFormat('d/m/Y', $request->data))))
                        ->whereYear('date_start', '=', date('Y', strtotime(Carbon::createFromFormat('d/m/Y', $request->data))))
                         : null;
                ! empty($request->type) ? $documents->where('session_type_id', $request->type) : null;

                $documents = $documents->paginate(10);
            }
        } else {
            $documents = Document::byDateDesc();

            if ($parameter->value == 1) {
                $documents->where('read', 1);
            }

            $documents = $documents->paginate(20);
        }

        $assemblymensList = $this->getAssemblymenList();

        return view('site.index', compact('download'))
            ->with('assemblymensList', $assemblymensList[1])
            ->with('documents', $documents)
            ->with('form', $request)
            ->with('params', $frontParams)
            ->with('doctypes', $docTypes);
    }

    public function getDocumentTypes()
    {
        $documentType = DocumentType::where('parent_id', 0)->pluck('name', 'id')->prepend('Selecione...', 0);

        $novo = [];
        foreach ($documentType as $key => $doc) {
            $novo[$key] = $doc;
            if ($key > 0) {
                $obj = DocumentType::find($key);
                if (count($obj->childs)) {
                    foreach ($obj->childs as $ch) {
                        $novo[$ch->id] = $doc.' :: '.$ch->name;
                    }
                }
            }
        }

        return $novo;
    }

    public function getAssemblymenList()
    {
        $assemblymens = Assemblyman::where('active', 1)->get();

        $assemblymen = [];
        $assemblymensList = [null => 'Selecione...'];
        foreach ($assemblymens as $assemblyman) {
            $parties = PartiesAssemblyman::where('assemblyman_id', $assemblyman->id)->orderBy('date', 'DESC')->first();
            $assemblymen[$assemblyman->id] = $assemblyman->short_name.' - '.$parties->party->prefix ?? '';
            $assemblymensList[$assemblyman->id] = $assemblyman->short_name.' - '.$parties->party->prefix ?? '';
        }

        return [$assemblymen, $assemblymensList];
    }

    public function downloadDocument($filename)
    {
        $file = public_path('uploads/documents/files').'/'.$filename;

        return response()->download($file);
    }

    public function downloadLaw($filename, $id)
    {
        $file = public_path('uploads/law_projects/'.$id.'/files').'/'.$filename;

        return response()->download($file);
    }

    public function downloadNeeting($filename)
    {
        $file = public_path('uploads/meeetings/files').'/'.$filename;

        return response()->download($file);
    }
}
