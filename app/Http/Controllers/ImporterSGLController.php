<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentAssemblyman;
use App\Models\DocumentType;
use App\Models\LawsProject;
use App\Models\LawsProjectAssemblyman;
use App\Models\LawsType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use League\Csv\Reader;

class ImporterSGLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $documentType = DocumentType::where('parent_id', 0)->pluck('name', 'id');

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

        $documentType = $novo;

        return view('importer.sgl.index', compact('documentType'));
    }

    public function projects()
    {
        $documentType = LawsType::pluck('name', 'id');

        return view('importer.sgl.projects', compact('documentType'));
    }

    public function importProtocol()
    {
        return '<h1>Uau! Você encontrou uma rota secreta! Parabéns! Fomos notificados, mas nao se preocupe, nada aconteceu, este recurso está desativado.</h1>';

        /*$path = public_path() . "/protocols/";
        $docTypes = [

            COLOCAR AQUIVOS EM PUBLIC/PROTOCOLS



          1 => [
            'slug' =>  'indicacao',
            'file' => 'indicacoes.csv'
          ],
          2 => [
            'slug' => 'requerimento',
            'file' => 'requerimentos.csv'
          ],
          9 => [
            'slug' => 'mocao-de-pesar',
            'file' => 'mocao_pesar.csv'
          ]

        ];

        foreach ($docTypes as $key => $value) {
            $slug = $value['slug'];
            $file = $path . $value['file'];

            $csv = Reader::createFromPath($file);
            $csv->setDelimiter(';');

            foreach ($csv as $index => $row) {
                if($index > 0 )
                {
                  $protocol_number = $row[0];
                  $date     = explode("/",$row[1]);
                  $doc_num  = $row[2];
                  $doc_year = $row[3];
                  $doc_type = $key;

                  if($doc_num && $doc_year && $doc_type){

                    $document = Document::where('number',$doc_num)
                    ->whereYear('date','=',$doc_year)
                    ->where('document_type_id',$doc_type)
                    ->first();

                    if($document){

                      $protocol = $document->document_protocol;
                      if($protocol)
                      {
                        //atualiza protocolo
                        $protocol = DocumentProtocol::find($protocol->id);
                        if($protocol)
                        {
                          $protocol->number = $protocol_number;
                          $protocol->protocol_type_id = 2;
                          $protocol->created_at = $date[2] . "-" . $date[1] . "-" . $date[0] . " 00:00:00";

                          $protocol->save();
                          $this->debug_to_console([$document,$protocol]);
                        }
                      }else{
                        //cria protocolo
                        $data = [
                          'document_id' => $document->id,
                          'protocol_type_id' => 2,
                          'number' => $protocol_number
                        ];

                        $prot = DocumentProtocol::firstOrcreate($data);
                        $prot->created_at = $date[2] . "-" . $date[1] . "-" . $date[0] . " 00:00:00";
                        //$prot->updated_at = $date[2] . "-" . $date[1] . "-" . $date[0] . " 00:00:00";
                        $prot->save();
                        $this->debug_to_console([$document,$prot]);

                      }

                    }

                  }
                }
            }


        }

        return "<h1>Protocolos importados com sucesso</h1>";*/
    }

    public function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script>console.log( 'Debug Objects: ".$output."' );</script>";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['is_approved'] = (isset($input['is_approved']) ? 1 : 0);

        if ($request->file('file')->isValid()) {
            $extension = $request->file('file')->getClientOriginalExtension();

            if ($extension == 'csv') {
                return $this->importDocuments($input, $request->file('file'));
            } else {
                flash('Ops! O Arquivo nao é no formato excel (xls,xlsx).')->error();

                return redirect()->back();
            }
        } else {
            flash('Ops! Arquivo corrompido ou inválido.')->error();

            return redirect()->back();
        }
    }

    public function importDocuments($input, $file)
    {
        $csv = Reader::createFromPath($file);
        $csv->setDelimiter(';');

        $count = 0;

        foreach ($csv as $index => $row) {
            if ($index > 0) {
                $owner_id = explode(',', $row[2]);
                $number = explode('/', $row[1]);
                $date = $row[0];

                $insert = [
            'document_type_id' => $input['type'],
            'date' => empty($date) ? date('d/m/Y', time()) : $date,
            'number' => $number[0],
            'owner_id' => $owner_id[0],
            'session_date' => null,
            'read' => 1,
            'users_id' => 0,
            'approved' => $input['is_approved'],
            'content' => utf8_encode($row[3]),
          ];

                $doc = Document::firstOrCreate($insert);

                if ($doc) {
                    $count = $count + 1;
                }

                if (count($owner_id) > 1) {
                    foreach ($owner_id as $key => $assemblyman) {
                        if ($key > 0) {
                            $data = [
                  'document_id' => $doc->id,
                  'assemblyman_id' => intval($assemblyman),
                ];
                            DocumentAssemblyman::firstOrCreate($data);
                        }
                    }
                }

                sleep(1);
            }
        }

        flash($count.' registros importados com sucesso.')->success();

        return redirect()->back();
    }

    /**
     *  IMPORT OF LAWS.
     */
    public function projectsImport(Request $request)
    {
        $input = $request->all();
        $input['is_approved'] = (isset($input['is_approved']) ? 1 : 0);

        $csv = Reader::createFromPath($request->file('file'));
        $csv->setDelimiter(';');

        $count = 0;

        foreach ($csv as $index => $row) {
            if ($index > 0) {
                $owner_id = explode(',', $row[2]);
                $number = explode('/', $row[1]);
                $date = $row[0];

                $insert = [
              'law_type_id' => $input['type'],
              'law_date' => empty($date) ? date('d/m/Y', time()) : $date,
              'project_number' => empty($number[0]) ? '' : $number[0],
              'title' => utf8_encode(empty($row[3]) ? null : $row[3]),
              'assemblyman_id' => $owner_id[0],
              'is_read' => 1,
              'protocol' => empty($row[5]) ? '' : $row[5],
              'protocoldate' => empty($row[4]) ? null : $row[4],
              'situation_id' => 1,
              'sub_title' => utf8_encode(empty($row[6]) ? '' : $row[6]),
              'sufix' => utf8_encode(empty($row[7]) ? '' : $row[7]),
              'justify' => utf8_encode(empty($row[8]) ? '' : $row[8]),
            ];

                $doc = LawsProject::firstOrCreate($insert);

                if ($doc) {
                    $count = $count + 1;
                }

                if (count($owner_id) > 1 && $doc) {
                    foreach ($owner_id as $key => $assemblyman) {
                        if ($key > 0) {
                            $data = [
                    'law_project_id' => $doc->id,
                    'assemblyman_id' => intval($assemblyman),
                  ];
                            LawsProjectAssemblyman::firstOrCreate($data);
                        }
                    }
                }

                sleep(1);
            }
        }

        flash($count.' registros importados com sucesso.')->success();

        return redirect()->back();
    }

    public function importProjects($input, $file)
    {
        if (is_file(public_path('importador/'.$file))) {
            $excel = App::make('excel');
            $data = $excel->load(public_path('importador/'.$file), function ($reader) {
            })->get();

            if (! empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $owner_id = explode(',', $value->owners);
                    $number = explode('/', $value->numberproject);

                    if (count($owner_id) && count($number)) {
                        $insert[] = [
                  'law_type_id' => $input['type'],
                  'law_date' => $value->date->format('d/m/Y'),
                  'project_number' => $number[0],
                  'assemblyman_id' => $owner_id[0],
                  'owners' => $owner_id,
                  'is_read' => 1,
                  'situation_id' => 1,
                  'is_ready' => $input['is_approved'],
                  'title' => $value->title,

                ];
                    } else {
                    }
                }

                if (! empty($insert)) {
                    foreach ($insert as $value) {
                        $doc = LawsProject::create($value);

                        if (count($value['owners']) > 1) {
                            foreach ($value['owners'] as $key => $assemblyman) {
                                if ($key > 0) {
                                    $document_asseblyman = new LawsProjectAssemblyman();
                                    $document_asseblyman->law_project_id = $doc->id;
                                    $document_asseblyman->assemblyman_id = intval($assemblyman);
                                    $document_asseblyman->save();
                                }
                            }
                        }
                    }

                    flash(count($insert).' registros importados com sucesso.')->success();

                    return redirect()->back();
                }
            }
        } else {
            flash('Ops! Arquivo corrompido ou inválido.')->error();

            return redirect()->back();
        }
    }
}
