<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomainOrSubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Authentication routes...
    Auth::routes();

    Route::get('logout', 'Auth\LoginController@logout');

    /*
     *  ROTAS DE FRONT-END DE CONSULTAS PÚBLICAS
     */
    Route::get('/arquivo', 'SiteController@index');
    Route::get('/documentPdf/{id}', 'DocumentController@show');
    Route::get('/lawPdf/{id}', 'LawsProjectController@show');

    Route::get('meeting/ata/{id}/pdf', 'MeetingController@ataPDF');
    Route::get('meeting/pauta/{id}/pdf', 'MeetingController@pautaPDF');

    Route::get('getMeetingDates', 'MeetingController@getDates');

    Route::get('download-document/{filename}', 'SiteController@downloadDocument');
    Route::get('download-law/{filename}/id/{id}', 'SiteController@downloadLaw');

    Route::get('download-meeting/{filename}', 'SiteController@downloadMeeting');

    /* --------------------------------------------------
     *  ----| GRUPO CONFIG
     *  -------------------------------------------------*/
    Route::group(['prefix' => 'config', ['middleware' => 'needsRole', 'is' => 'root']], function () {
        Route::resource('/companies', 'CompanyController');
        Route::get('/companies/{id}/toggle', 'CompanyController@toggle');
        Route::get('/companies/{id}/delete', [
            'as' => 'config.companies.delete',
            'uses' => 'CompanyController@destroy',
        ]);

        Route::get('/companies/removeImage/{id}', 'CompanyController@removeImage');
        Route::get('/companies/change-parameter/{id}/{value}', 'CompanyController@changeParamater');

        Route::resource('permissions', 'PermissionController');
        Route::get('/permissions/{id}/toggle', 'PermissionController@toggle');
        Route::get('/permissions/{id}/delete', [
            'as' => 'config.permissions.delete',
            'uses' => 'PermissionController@destroy',
        ]);

        Route::resource('modules', 'ModuleController');
        Route::get('/modules/{id}/toggle', 'ModuleController@toggle');
        Route::get('/modules/{id}/delete', [
            'as' => 'config.modules.delete',
            'uses' => 'ModuleController@destroy',
        ]);

        Route::resource('parameters', 'ParametersController');

        Route::get('/importNumber', 'DocumentController@importNumber')->name('documents.importNumber');
        Route::get('/importNumberLaw', 'LawsProjectController@importNumberLaw')->name('lawsProjects.importNumberLaw');

        Route::get('/export/files', 'AdminController@exportFiles')->name('export.files');
        Route::get('/export/files/documents', 'AdminController@exportFilesDocuments')->name('export.files.documents');
        Route::get('/export/files/zip', 'AdminController@exportFilesZip')->name('export.files.zip');

        Route::get('/export/files', 'AdminController@exportFiles')->name('export.files');
        Route::get('/export/files/laws', 'AdminController@exportFilesLaws')->name('export.files.laws');
        Route::get('/export/files/laws/zip', 'AdminController@exportFilesLawsZip')->name('export.files.laws.zip');
    });

    /* --------------------------------------------------
     *  ----| GRUPO GERAL
     *  -------------------------------------------------*/
    Route::group(['prefix' => '', 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'messages'], function () {
            Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
            Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
            Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
            Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
            Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
        });

        Route::group(['prefix' => '', ['middleware' => 'needsRole', 'is' => 'root']], function () {
            Route::resource('states', 'StateController');
            Route::post('get-state', 'StateController@stateByUf');
            Route::get('states/{id}/delete', [
                'as' => 'states.delete',
                'uses' => 'StateController@destroy',
            ]);

            Route::resource('cities', 'CityController');
            Route::post('/getcities/{uf}', 'CityController@getByUf');
            Route::get('cities/{id}/delete', [
                'as' => 'cities.delete',
                'uses' => 'CityController@destroy',
            ]);
        });

        Route::get('/', 'AdminController@dashboard');
        Route::post('/admin/findAdvice', 'AdminController@findAdvice');
        Route::post('/admin/saveAdvice', 'AdminController@saveAdvice');
        Route::get('/admin/commissions', 'AdminController@commissions');
        Route::get('/admin/commissions/{id}/showLaw', 'AdminController@showLaw')->name('admin.showLaw');
        Route::get('/admin/commissions/{id}/showDocument', 'AdminController@showDocument')->name('admin.showDocument');
        Route::get('/admin/commissions/{id}/showClose', 'AdminController@showClose')->name('admin.showClose');

        Route::get('get-updates', 'TelegramController@getUpdates');
        Route::get('send-message', 'TelegramController@getSendMessage');
        Route::post('send-message', 'TelegramController@postSendMessage');

        Route::get('/report/documents', 'ReportController@document');
        Route::get('/report/documents/noFiles', 'ReportController@noFiles');
        Route::get('/report/pdf/noFiles', 'ReportController@pdfNoFiles');
        Route::get('/report/pdf/noFilesLaw', 'ReportController@pdfNoFilesLaw');
        Route::get('/report/pdf/noFilesMeeting', 'ReportController@pdfNoFilesMeeting');

        Route::get('/report/lawsProject', 'ReportController@lawsProject');
        Route::get('/report/lawsProject/noFiles', 'ReportController@noFilesLaw');
        Route::get('/report/meeting/noFiles', 'ReportController@noFilesMeeting');
        Route::get('/report/pdf', 'ReportController@pdf');
        Route::post('/report/getData', 'ReportController@getData');
        Route::get('/report/getTramitacao', 'ReportController@getTramitacao');
        Route::get('/report/tamitacao/pdf', 'ReportController@getTramitacaoPdf');

        Route::resource('logs', 'LogController');

        Route::get('importer/protocols', 'ImporterSGLController@importProtocol');

        Route::get('importer/sgl', 'ImporterSGLController@index');
        Route::post('importer/sgl/import', 'ImporterSGLController@store');

        Route::get('importer/projects', 'ImporterSGLController@projects');
        Route::post('importer/projects/import', 'ImporterSGLController@projectsImport');

        Route::get('legislatures/deleteAssemblyman/{legislature_id}/{assemblyman_id}', ['as' => 'legislatures.deleteAssemblyman', 'uses' => 'LegislatureController@deleteAssemblyman']);
        Route::post('legislatures/saveAssemblyman/{id}', ['as' => 'legislatures.saveAssemblyman', 'uses' => 'LegislatureController@saveAssemblyman']);
        Route::resource('legislatures', 'LegislatureController');
        Route::resource('parties', 'PartyController');
        Route::resource('responsibilities', 'ResponsibilityController');


        Route::resource('people', 'PeopleController');

        Route::post('people/search-by-cpf', 'PeopleController@searchByCpf');

        Route::resource('attendance', 'AttendanceController');

        Route::resource('types-of-attendance', 'TypesOfAttendanceController', [
            'names' => [
                'index' => 'typesOfAttendance.index',
                'create' => 'typesOfAttendance.create',
                'show' => 'typesOfAttendance.show',
                'edit' => 'typesOfAttendance.edit',
                'store' => 'typesOfAttendance.store',
                'destroy' => 'typesOfAttendance.destroy',
                'update' => 'typesOfAttendance.update',
            ],
        ]);

        Route::resource('profiles', 'ProfileController');
        Route::get('/profiles/{id}/toggle', 'ProfileController@toggle');
        Route::get('profiles/{id}/delete', [
            'as' => 'profiles.delete',
            'uses' => 'ProfileController@destroy',
        ]);

        Route::resource('users', 'UserController');
        Route::get('/users/{id}/toggle', 'UserController@toggle');
        Route::get('/users/{id}/auditing', 'UserController@auditing');
        Route::get('users/{id}/delete', [
            'as' => 'users.delete',
            'uses' => 'UserController@destroy',
        ]);

        Route::post('/advice/create', 'AdviceController@store');
        Route::post('/advice/delete', 'AdviceController@removerAdvice');

        Route::get('/advice/findAwnser/{id?}', 'AdviceController@findAwnser')->name('advices.find');
        Route::post('/advice/findAwnser/{id?}/delete', 'AdviceController@deleteAwnser');
        Route::get('/advice/findAwnser/{id}/getAwnser', 'AdviceController@getAwnser');
        Route::post('/advice/awnserUpdate', 'AdviceController@awnserUpdate');
        Route::get('/advice/awnser/{id}/removeFile', 'AdviceController@removeFile');

        Route::resource('comissionSituations', 'ComissionSituationController');
        Route::get('/comissionSituations/{id}/toggle', 'ComissionSituationController@toggle');

        Route::get('assemblymen/listLegislatures/{assemblyman_id}', ['as' => 'legislatures.listlegislatures', 'uses' => 'AssemblymanController@listLegislatures']);
        Route::get('assemblymen/listParties/{assemblyman_id}', ['as' => 'legislatures.listparties', 'uses' => 'AssemblymanController@listParties']);
        Route::get('assemblymen/listResponsibilities/{assemblyman_id}', ['as' => 'legislatures.listresponsibilities', 'uses' => 'AssemblymanController@listResponsibilities']);
        Route::get('/assemblymen/{id}/toggle', 'AssemblymanController@toggle');
        Route::post('assemblymen/addLegislatures', ['as' => 'assemblymen.addLegislatures', 'uses' => 'AssemblymanController@addLegislatures']);
        Route::post('assemblymen/addParties', ['as' => 'assemblymen.addParties', 'uses' => 'AssemblymanController@addParties']);
        Route::get('assemblymen/removeParty/{party_id}/{assemblyman_id}', ['as' => 'assemblymen.removeParties', 'uses' => 'AssemblymanController@removeParties']);
        Route::get('assemblymen/removeLegislatures/{legislature_id}/{assemblyman_id}', ['as' => 'assemblymen.removeLegislatures', 'uses' => 'AssemblymanController@removeLegislatures']);
        Route::post('assemblymen/addResponsibilities', ['as' => 'assemblymen.addResponsibilities', 'uses' => 'AssemblymanController@addResponsibilities']);
        Route::get('assemblymen/removeResponsibility/{responsibility_id}/{assemblyman_id}', ['as' => 'assemblymen.removeResponsibilities', 'uses' => 'AssemblymanController@removeResponsibilities']);
        Route::resource('assemblymen', 'AssemblymanController');
        Route::get('/assemblymen/{id}/delimage', 'AssemblymanController@delimage');

        Route::resource('sectors', 'SectorController');

        Route::resource('documentTypes', 'DocumentTypeController');

        Route::resource('documentModels', 'DocumentModelsController');

        Route::resource('documentSituations', 'DocumentSituationController');
        Route::get('/documentSituations/{id}/toggle', 'DocumentSituationController@toggle');

        Route::resource('protocolTypes', 'ProtocolTypeController');

        Route::get('/documents-approved/{id}/toggle', 'DocumentController@toggleApproved');
        Route::get('/documents-read/{id}/toggle', 'DocumentController@toggleRead');
        Route::get('/documents/{id}/attachament', ['as' => 'documents.attachament', 'uses' => 'DocumentController@attachament']);
        Route::post('/documents/{id}/attachament-upload', ['as' => 'documents.attachament.upload', 'uses' => 'DocumentController@attachamentUpload']);
        Route::get('document-file-delete/{id}', 'DocumentController@attachamentDelete');
        Route::post('/documents/deleteBash', 'DocumentController@deleteBash');

        Route::post('/documents/findTextInitial', 'DocumentController@findTextInitial');
        Route::post('/protocolo/altera-protocolo', 'DocumentController@alteraProtocolo');
        Route::post('/protocolo/altera-numero', 'DocumentController@alteraNumero');

        Route::get('document-protocol/{id}', 'DocumentController@documentProtocol');
        Route::post('document-protocol-save', 'DocumentController@documentProtocolSave');
        Route::resource('documents', 'DocumentController');

        Route::get('commission-assemblymen/{id}', 'CommissionController@commissionAssemblymen');
        Route::resource('commissions', 'CommissionController');

        Route::resource('officeCommissions', 'OfficeCommissionController');

        Route::resource('sessionTypes', 'SessionTypeController');

        Route::resource('sessionPlaces', 'SessionPlaceController');
        Route::resource('structurepautas', 'StructurepautaController');
        Route::get('structurepauta/toggle/{field}/{id}', 'StructurepautaController@toggleField');
        Route::get('structurepauta/deleta/{id}', 'StructurepautaController@destroy');

        Route::resource('/version_pauta', 'VersionPautaController');
        Route::get('/version_pauta/{id}/structurepautas/create', 'VersionPautaController@createStructure')->name('version_pauta.createStructure');
        Route::get('/version_pauta/{id}/structurepauta/deleta/{structure_id}', 'VersionPautaController@destroyStructure')->name('version_pauta.destroyStructure');

        Route::resource('meetings', 'MeetingController');
        Route::get('meetings/can_number/{number}/{session_type_id}', 'MeetingController@meetingsCanNumber');
        Route::get('meetings/next_number/{session_type_id}', 'MeetingController@meetingsNextNumber');

        Route::post('meetings/ata', 'MeetingController@atasave');
        Route::get('meetings/{meeting_id}/ata', [
            'as' => 'meetings.newata',
            'uses' => 'MeetingController@newata',
        ]);

        Route::post('meetings/pauta', 'MeetingController@pautaSave');
        Route::get('meetings/{meeting_id}/pauta', [
            'as' => 'meetings.newpauta',
            'uses' => 'MeetingController@newpauta',
        ]);

        Route::post('meetings/addDocument', 'MeetingController@addDocument');
        Route::get('meetings/removeDocument/{id}', 'MeetingController@removeDocument');

        Route::get('/meetings/{id}/attachament', ['as' => 'meetings.attachament', 'uses' => 'MeetingController@attachament']);
        Route::post('/meetings/{id}/attachament-upload', ['as' => 'meetings.attachament.upload', 'uses' => 'MeetingController@attachamentUpload']);
        Route::get('meetings-file-delete/{id}', 'MeetingController@attachamentDelete');

        Route::get('/meetings/{id}/presences', 'MeetingController@presence')->name('meetings.presence');
        Route::post('/meetings/presences/save', 'MeetingController@presenceSave')->name('meetings.presenceSave');
        Route::get('/meetings/presences/{id}/pdf', 'MeetingController@presencePDF')->name('meetings.presencePDF');
        Route::get('/meetings/{meeting}/voting', 'MeetingController@voting')->name('meetings.voting');
        Route::post('/meetings/{id}/voting/create', 'MeetingController@votingCreate')->name('meetings.votingCreate');
        Route::get('/meetings/{id}/voting/{voting_id}/document/{document_id}', 'MeetingController@votingDocument')->name('meetings.votingDocument');
        Route::get('/meetings/{id}/voting/{voting_id}/law/{law_id}', 'MeetingController@votingLaw')->name('meetings.votingLaw');
        Route::get('/meetings/{id}/voting/{voting_id}/ata/{ata_id}', 'MeetingController@votingAta')->name('meetings.votingAta');
        Route::get('/meetings/{id}/voting/{voting_id}/advice/{advice_id}', 'MeetingController@votingAdvice')->name('meetings.votingAdvice');

        Route::post('/meetings/{id}/voting/{voting_id}/updateAssemblyman', 'MeetingController@updateAssemblyman')->name('meetings.updateAssemblyman');
        Route::get('/meetings/{id}/voting/{voting_id}/closeVoting', 'MeetingController@closeVoting')->name('meetings.closeVoting');
        Route::get('/meetings/{id}/voting/{voting_id}/cancelVoting', 'MeetingController@cancelVoting')->name('meetings.cancelVoting');

        Route::post('/meetings/voting/registerVote', 'MeetingController@registerVote')->name('meetings.registerVote');

        Route::resource('typeVotings', 'TypeVotingController');

        Route::resource('lawsTypes', 'LawsTypeController');
        Route::get('/lawsTypes-active/{id}/toggle', 'LawsTypeController@toggleActive');

        Route::resource('lawsPlaces', 'LawsPlaceController');
        Route::resource('lawsStructures', 'LawsStructureController');
        Route::resource('lawsTags', 'LawsTagController');

        Route::resource('lawSituations', 'LawSituationController');

        Route::resource('structureLaws', 'StructureLawController');
        Route::get('/structureLaws/{id}/delete', [
            'as' => 'structureLaws.delete',
            'uses' => 'StructureLawController@destroy',
        ]);

        Route::resource('lawsProjects', 'LawsProjectController');
        Route::get('lawProlawProjectNextNumber/{law_type}', 'LawsProjectController@lawProjectNextNumber');
        Route::get('/lawsProjects-approved/{id}/toggle', 'LawsProjectController@toggleApproved');
        Route::get('/lawsProjects-read/{id}/toggle', 'LawsProjectController@toggleRead');
        Route::get('/lawProjectProtocol/{id}', 'LawsProjectController@lawProjectProtocol');
        Route::get('/lawProjectApproved/{id}', 'LawsProjectController@lawProjectApproved');
        Route::post('/lawsProjectApprovedSave', 'LawsProjectController@lawsProjectApprovedSave');
        Route::post('/lawsProjectProtocolSave', 'LawsProjectController@lawsProjectProtocolSave');
        Route::post('/lawProjects/deleteBash', 'LawsProjectController@deleteBash');
        Route::post('/lawsProject/getNumProt', 'LawsProjectController@getNumProt');
        Route::post('/lawsProject/saveProtocolNumber', 'LawsProjectController@saveProtocolNumber');
        Route::get('/lawsProjects/structure/{id}', ['as' => 'lawsProjects.structure', 'uses' => 'LawsProjectController@lawsProjectStructure']);
        Route::get('/lawsProjects/advices/{id}', [
            'as' => 'lawsProjects.advices',
            'uses' => 'LawsProjectController@advices',
        ]);

        Route::get('law-file-delete/{id}', 'LawsProjectController@attachamentDelete');
        Route::post('/lawsProjects/{id}/attachament-upload', ['as' => 'lawsProjects.attachament.upload', 'uses' => 'LawsProjectController@attachamentUpload']);

        Route::post('/lawproject/{id}/toogleApproved', 'LawsProjectController@toogleApproved');
        Route::get('/lawproject/{id}/addFiles', 'LawsProjectController@addFiles')->name('lawsProjects.addFiles');
        Route::post('/lawproject/{id}/addFiles', 'LawsProjectController@addFilesSave')->name('lawsProjects.addFilesSave');

        Route::get('/documents/advices/{id}', [
            'as' => 'documents.advices',
            'uses' => 'DocumentController@advices',
        ]);

        Route::resource('processings', 'ProcessingController');

        Route::resource('processingDocuments', 'ProcessingDocumentController');

        Route::post('lawProject-approvedGet', 'LawsProjectController@numberGetApproved');
        Route::post('lawProject-approvedEdit', ['as' => 'lawProject.approvedEdit', 'uses' => 'LawsProjectController@numberEditApproved']);

        Route::resource('/adviceSituationLaws', 'AdviceSituationLawController');
        Route::get('/adviceSituationLaws/{id}/toggle', 'AdviceSituationLawController@toggle');

        Route::resource('advicePublicationLaws', 'AdvicePublicationLawController');
        Route::get('/advicePublicationLaws/{id}/toggle', 'AdvicePublicationLawController@toggle');

        Route::resource('statusProcessingLaws', 'StatusProcessingLawController');
        Route::get('/statusProcessingLaws/{id}/toggle', 'StatusProcessingLawController@toggle');

        Route::resource('statusProcessingDocuments', 'StatusProcessingDocumentController');
        Route::get('/statusProcessingDocuments/{id}/toggle', 'StatusProcessingDocumentController@toggle');

        Route::resource('adviceSituationDocuments', 'AdviceSituationDocumentsController');
        Route::get('/adviceSituationDocuments/{id}/toggle', 'AdviceSituationDocumentsController@toggle');

        Route::resource('advicePublicationDocuments', 'AdvicePublicationDocumentsController');
        Route::get('/advicePublicationDocuments/{id}/toggle', 'AdvicePublicationDocumentsController@toggle');

        Route::get('/painel-votacao', 'MeetingController@painel')->name('voting.panel');
        Route::get('/painel-votacao/default', 'MeetingController@panelDefault')->name('voting.default');
        Route::get('/painel-votacao/voting', 'MeetingController@painelVoting')->name('voting.voting');
        Route::get('/painel-votacao/resume', 'MeetingController@painelResume')->name('voting.resume');
        Route::get('/painel-votacao/discourse', 'MeetingController@painelDiscourse')->name('voting.discourse');

        Route::post('/painel-votacao/data', 'MeetingController@painelData');
        Route::get('/painel-votacao-parlamentar/{id}/data', 'MeetingController@painelParlamentarData');

        Route::get('voting/assemblyman/{id}', 'MeetingController@assemblymanVoting')->name('assemblyman.voting');
        Route::post('voting/assemblyman/computeVoting', 'MeetingController@computeVoting')->name('assemblyman.computeVoting');

        Route::get('voting/getVotes', 'MeetingController@getVotes')->name('assemblyman.getVotes');

        Route::get('/meetings/{id}/panel-stage', 'MeetingController@panelStage')->name('voting.panelStage');
        Route::post('/set-stage-panel', 'CompanyController@setStagePanel');
        Route::get('/get-stage-panel', 'CompanyController@getstagePanel');
        Route::get('/meetings/{id}/discourse', 'MeetingController@discourse')->name('meetings.discourse');

        Route::post('/setAssemblyman', 'MeetingController@setAssemblyman')->name('meetings.setAssemblyman');

        Route::post('/pulpito/info', 'MeetingController@painelDiscourseData');

        Route::get('/generate-charts', 'MeetingController@generateCharts');
        Route::get('/generate-charts/voting/{id}', 'MeetingController@generateChartsResume');

        Route::get('/resume/voting/{id}', 'MeetingController@showResume');

        /* --------------------------------------------------
         *  ----| GRUPO GERENCIAL
         *  -------------------------------------------------*/
        Route::group(['prefix' => 'gerencial'], function () {
            Route::resource('roles', 'RoleController');
            Route::get('/roles/toggle/permission/{role}/{permission}', 'RoleController@togglePermission');
            Route::get('/roles/{id}/permission', [
                'as' => 'gerencial.roles.permission',
                'uses' => 'RoleController@permission',
            ]);
            Route::get('/roles/{id}/delete', [
                'as' => 'gerencial.roles.delete',
                'uses' => 'RoleController@destroy',
            ]);
        });

        Route::resource('profiles', 'ProfileController');
        Route::get('/profiles/{id}/toggle', 'ProfileController@toggle');
        Route::get('profiles/{id}/delete', [
            'as' => 'profiles.delete',
            'uses' => 'ProfileController@destroy',
        ]);

        Route::resource('users', 'UserController');
        Route::get('/users/{id}/toggle', 'UserController@toggle');
        Route::get('/users/{id}/auditing', 'UserController@auditing');
        Route::get('users/{id}/delete', [
            'as' => 'users.delete',
            'uses' => 'UserController@destroy',
        ]);

        Route::post('/advice/create', 'AdviceController@store');
        Route::post('/advice/delete', 'AdviceController@removerAdvice');

        Route::get('/advice/findAwnser/{id?}', 'AdviceController@findAwnser')->name('advices.find');
        Route::post('/advice/findAwnser/{id?}/delete', 'AdviceController@deleteAwnser');
        Route::get('/advice/findAwnser/{id}/getAwnser', 'AdviceController@getAwnser');
        Route::post('/advice/awnserUpdate', 'AdviceController@awnserUpdate');
        Route::get('/advice/awnser/{id}/removeFile', 'AdviceController@removeFile');

        Route::resource('comissionSituations', 'ComissionSituationController');
        Route::get('/comissionSituations/{id}/toggle', 'ComissionSituationController@toggle');
    });
});
