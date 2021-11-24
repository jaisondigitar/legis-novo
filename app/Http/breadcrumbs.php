<?php

// home
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', '/');
});

/*
 *  COMPANIES
 */

Breadcrumbs::for('company.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Configurações', null);
    $breadcrumbs->push('Empresas', '/config/companies');
});
Breadcrumbs::for('company.new', function ($breadcrumbs) {
    $breadcrumbs->parent('company.list');
    $breadcrumbs->push('Nova Empresa', null);
});
Breadcrumbs::for('company.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('company.list');
    $breadcrumbs->push('Editar Empresa', null);
});
Breadcrumbs::for('company.show', function ($breadcrumbs) {
    $breadcrumbs->parent('company.list');
    $breadcrumbs->push('Empresa', null);
});

/*
 * USERS
 */

Breadcrumbs::for('users.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Usuários', '/users');
});
Breadcrumbs::for('users.new', function ($breadcrumbs) {
    $breadcrumbs->parent('users.list');
    $breadcrumbs->push('Novo usuário', '/users/create');
});
Breadcrumbs::for('users.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('users.list');
    $breadcrumbs->push('Editar Usuario', null);
});
Breadcrumbs::for('users.show', function ($breadcrumbs) {
    $breadcrumbs->parent('users.list');
    $breadcrumbs->push('Usuario', null);
});

/*
 * LEGISLATURE
 */

Breadcrumbs::for('legislatures.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Legislaturas', '/legislatures');
});
Breadcrumbs::for('legislatures.new', function ($breadcrumbs) {
    $breadcrumbs->parent('legislatures.list');
    $breadcrumbs->push('Nova Legislatura', '/legislatures/create');
});
Breadcrumbs::for('legislatures.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('legislatures.list');
    $breadcrumbs->push('Editar Legislatura', null);
});
Breadcrumbs::for('legislatures.show', function ($breadcrumbs) {
    $breadcrumbs->parent('legislatures.list');
    $breadcrumbs->push('Legislatura', null);
});

/*
 * PARTIES
 */

Breadcrumbs::for('parties.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Partidos', '/parties');
});
Breadcrumbs::for('parties.new', function ($breadcrumbs) {
    $breadcrumbs->parent('parties.list');
    $breadcrumbs->push('Novo partido', '/parties/create');
});
Breadcrumbs::for('parties.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('parties.list');
    $breadcrumbs->push('Editar Partido', null);
});
Breadcrumbs::for('parties.show', function ($breadcrumbs) {
    $breadcrumbs->parent('parties.list');
    $breadcrumbs->push('Partido', null);
});

/*
 * RESPONSIBILITIES
 */

Breadcrumbs::for('responsibilities.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Responsabilidades', '/responsibilities');
});
Breadcrumbs::for('responsibilities.new', function ($breadcrumbs) {
    $breadcrumbs->parent('responsibilities.list');
    $breadcrumbs->push('Novo Responsabilidade', '/responsibilities/create');
});
Breadcrumbs::for('responsibilities.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('responsibilities.list');
    $breadcrumbs->push('Editar Responsabilidade', null);
});
Breadcrumbs::for('responsibilities.show', function ($breadcrumbs) {
    $breadcrumbs->parent('responsibilities.list');
    $breadcrumbs->push('Responsabilidade', null);
});

/*
 * ASSEMBLYMEN
 */

Breadcrumbs::for('assemblymen.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Parlamentares', '/assemblymen');
});
Breadcrumbs::for('assemblymen.new', function ($breadcrumbs) {
    $breadcrumbs->parent('assemblymen.list');
    $breadcrumbs->push('Novo Parlamentar', '/assemblymen/create');
});
Breadcrumbs::for('assemblymen.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('assemblymen.list');
    $breadcrumbs->push('Editar Parlamentar', null);
});
Breadcrumbs::for('assemblymen.show', function ($breadcrumbs) {
    $breadcrumbs->parent('assemblymen.list');
    $breadcrumbs->push('Parlamentar', null);
});

/*
 * SECTOR
 */

Breadcrumbs::for('sectors.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Setores', '/sectors');
});
Breadcrumbs::for('sectors.new', function ($breadcrumbs) {
    $breadcrumbs->parent('sectors.list');
    $breadcrumbs->push('Novo Setor', '/sectors/create');
});
Breadcrumbs::for('sectors.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('sectors.list');
    $breadcrumbs->push('Editar Setor', null);
});
Breadcrumbs::for('sectors.show', function ($breadcrumbs) {
    $breadcrumbs->parent('sectors.list');
    $breadcrumbs->push('Setor', null);
});

/*
 * DOCUMENT MODELS
 */

Breadcrumbs::for('documentModels.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Modelos de Documentos', '/documentModels');
});
Breadcrumbs::for('documentModels.new', function ($breadcrumbs) {
    $breadcrumbs->parent('documentModels.list');
    $breadcrumbs->push('Novo Modelo de Documentos', '/documentModels/create');
});
Breadcrumbs::for('documentModels.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('documentModels.list');
    $breadcrumbs->push('Editar Modelo de Documentos', null);
});
Breadcrumbs::for('documentModels.show', function ($breadcrumbs) {
    $breadcrumbs->parent('documentModels.list');
    $breadcrumbs->push('Modelo de Documentos', null);
});

/*
 * DOCUMENT TYPE
 */

Breadcrumbs::for('documentTypes.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de Documentos', '/documentTypes');
});
Breadcrumbs::for('documentTypes.new', function ($breadcrumbs) {
    $breadcrumbs->parent('documentTypes.list');
    $breadcrumbs->push('Novo Tipo de Documento', '/documentTypes/create');
});
Breadcrumbs::for('documentTypes.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('documentTypes.list');
    $breadcrumbs->push('Editar Tipo de Documento', null);
});
Breadcrumbs::for('documentTypes.show', function ($breadcrumbs) {
    $breadcrumbs->parent('documentTypes.list');
    $breadcrumbs->push('Tipo de Documentos', null);
});

/*
 * DOCUMENT SITUATION
 */
Breadcrumbs::for('documentSituations.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Situação do Documentos', '/documentSituations');
});
Breadcrumbs::for('documentSituations.new', function ($breadcrumbs) {
    $breadcrumbs->parent('documentSituations.list');
    $breadcrumbs->push('Nova Situação do Documentos', '/documentSituations/create');
});
Breadcrumbs::for('documentSituations.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('documentSituations.list');
    $breadcrumbs->push('Editar Situação do Documentos', null);
});
Breadcrumbs::for('documentSituations.show', function ($breadcrumbs) {
    $breadcrumbs->parent('documentSituations.list');
    $breadcrumbs->push('Situação de Documentos', null);
});

/*
 * PROTOCOL TYPE
 */

Breadcrumbs::for('protocolTypes.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de Protocolos', '/protocolTypes');
});
Breadcrumbs::for('protocolTypes.new', function ($breadcrumbs) {
    $breadcrumbs->parent('protocolTypes.list');
    $breadcrumbs->push('Novo Tipo de Protocolo', '/protocolTypes/create');
});
Breadcrumbs::for('protocolTypes.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('protocolTypes.list');
    $breadcrumbs->push('Editar Tipo de Protocolo', null);
});
Breadcrumbs::for('protocolTypes.show', function ($breadcrumbs) {
    $breadcrumbs->parent('protocolTypes.list');
    $breadcrumbs->push('Tipo de Protocolo', null);
});

/*
 * DOCUMENT
 */

Breadcrumbs::for('documents.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Documentos', '/documents');
});
Breadcrumbs::for('documents.new', function ($breadcrumbs) {
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Novo Documento', '/documents/create');
});
Breadcrumbs::for('documents.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Editar Documento', null);
});
Breadcrumbs::for('documents.show', function ($breadcrumbs) {
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Documento', null);
});

Breadcrumbs::for('documents.attachment', function ($breadcrumbs) {
    $breadcrumbs->parent('documents.list');
    $breadcrumbs->push('Anexos documento', null);
});

/*
 * COMMISSION
 */

Breadcrumbs::for('commissions.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Comissões', '/commissions');
});
Breadcrumbs::for('commissions.new', function ($breadcrumbs) {
    $breadcrumbs->parent('commissions.list');
    $breadcrumbs->push('Nova Comissão', '/commissions/create');
});
Breadcrumbs::for('commissions.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('commissions.list');
    $breadcrumbs->push('Editar Comissão', null);
});
Breadcrumbs::for('commissions.show', function ($breadcrumbs) {
    $breadcrumbs->parent('commissions.list');
    $breadcrumbs->push('Comissão', null);
});

/*
 * OFFICE COMMISSION
 */

Breadcrumbs::for('officeCommission.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Cargos de Comissão', '/officeCommissions');
});
Breadcrumbs::for('officeCommission.new', function ($breadcrumbs) {
    $breadcrumbs->parent('officeCommission.list');
    $breadcrumbs->push('Novo Cargo de Comissão', '/officeCommissions/create');
});
Breadcrumbs::for('officeCommission.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('officeCommission.list');
    $breadcrumbs->push('Editar Cargo de Comissão', null);
});
Breadcrumbs::for('officeCommission.show', function ($breadcrumbs) {
    $breadcrumbs->parent('officeCommission.list');
    $breadcrumbs->push('Cargo de Comissão', null);
});

/*
 * PARAMETERS
 */

Breadcrumbs::for('parameters.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Parâmetro', '/parameters');
});
Breadcrumbs::for('parameters.new', function ($breadcrumbs) {
    $breadcrumbs->parent('parameters.list');
    $breadcrumbs->push('Novo Parâmetro', '/parameters/create');
});
Breadcrumbs::for('parameters.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('parameters.list');
    $breadcrumbs->push('Editar Parâmetro', null);
});
Breadcrumbs::for('parameters.show', function ($breadcrumbs) {
    $breadcrumbs->parent('parameters.list');
    $breadcrumbs->push('Parâmetro', null);
});

/*
 * SESSION_TYPES
 */

Breadcrumbs::for('sessionTypes.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipo de Sessão', '/sessionTypes');
});
Breadcrumbs::for('sessionTypes.new', function ($breadcrumbs) {
    $breadcrumbs->parent('sessionTypes.list');
    $breadcrumbs->push('Novo Tipo de Sessão', '/sessionTypes/create');
});
Breadcrumbs::for('sessionTypes.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('sessionTypes.list');
    $breadcrumbs->push('Editar Tipo de Sessão', null);
});
Breadcrumbs::for('sessionTypes.show', function ($breadcrumbs) {
    $breadcrumbs->parent('sessionTypes.list');
    $breadcrumbs->push('Tipo de Sessão', null);
});

/*
 * SESSION_PLACES
 */

Breadcrumbs::for('sessionPlaces.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Locais de Sessão', '/sessionPlaces');
});
Breadcrumbs::for('sessionPlaces.new', function ($breadcrumbs) {
    $breadcrumbs->parent('sessionPlaces.list');
    $breadcrumbs->push('Novo Local de Sessão', '/sessionPlaces/create');
});
Breadcrumbs::for('sessionPlaces.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('sessionPlaces.list');
    $breadcrumbs->push('Editar Local de Sessão', null);
});
Breadcrumbs::for('sessionPlaces.show', function ($breadcrumbs) {
    $breadcrumbs->parent('sessionPlaces.list');
    $breadcrumbs->push('Local de Sessão', null);
});

/*
 * MEETINGS
 */

Breadcrumbs::for('meetings.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Sessões', '/meetings');
});
Breadcrumbs::for('meetings.new', function ($breadcrumbs) {
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Nova Sessão', '/meetings/create');
});
Breadcrumbs::for('meetings.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Editar Sessão', null);
});
Breadcrumbs::for('meetings.show', function ($breadcrumbs) {
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Sessão', null);
});
Breadcrumbs::for('meetings.attachment', function ($breadcrumbs) {
    $breadcrumbs->parent('meetings.list');
    $breadcrumbs->push('Anexos documento', null);
});

/*
 * LAWS TYPES
 */

Breadcrumbs::for('lawsTypes.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de lei', '/lawsTypes');
});
Breadcrumbs::for('lawsTypes.new', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsTypes.list');
    $breadcrumbs->push('Novo tipo de lei', '/lawsTypes/create');
});
Breadcrumbs::for('lawsTypes.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsTypes.list');
    $breadcrumbs->push('Editar tipo de lei', null);
});
Breadcrumbs::for('lawsTypes.show', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsTypes.list');
    $breadcrumbs->push('Tipo de lei', null);
});

/*
 * LAWS PLACES
 */

Breadcrumbs::for('lawsPlaces.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Locais de publicação', '/lawsPlaces');
});
Breadcrumbs::for('lawsPlaces.new', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsPlaces.list');
    $breadcrumbs->push('Novo local de publicação', '/lawsPlaces/create');
});
Breadcrumbs::for('lawsPlaces.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsPlaces.list');
    $breadcrumbs->push('Editar local de publicação', null);
});
Breadcrumbs::for('lawsPlaces.show', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsPlaces.list');
    $breadcrumbs->push('Local de publicação', null);
});

/*
 * LAWS Structure
 */

Breadcrumbs::for('lawsStructures.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipos de estrutura', '/lawsStructures');
});
Breadcrumbs::for('lawsStructures.new', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsStructures.list');
    $breadcrumbs->push('Novo tipo de estrutura', '/lawsStructures/create');
});
Breadcrumbs::for('lawsStructures.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsStructures.list');
    $breadcrumbs->push('Editar tipo de estrutura', null);
});
Breadcrumbs::for('lawsStructures.show', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsStructures.list');
    $breadcrumbs->push('Tipo de estrutura', null);
});

/*
 * LAWS TAGS
 */

Breadcrumbs::for('lawsTags.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tags de lei', '/lawsTags');
});
Breadcrumbs::for('lawsTags.new', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsTags.list');
    $breadcrumbs->push('Nova tag de lei', '/lawsTags/create');
});
Breadcrumbs::for('lawsTags.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsTags.list');
    $breadcrumbs->push('Editar tag de lei', null);
});
Breadcrumbs::for('lawsTags.show', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsTags.list');
    $breadcrumbs->push('Tag de lei', null);
});

/*
 * LAWS PROJECT
 */

Breadcrumbs::for('lawsProjects.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Projetos de Lei', '/lawsProjects');
});
Breadcrumbs::for('lawsProjects.new', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsProjects.list');
    $breadcrumbs->push('Novo projeto de lei', '/lawsProjects/create');
});
Breadcrumbs::for('lawsProjects.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsProjects.list');
    $breadcrumbs->push('Editar projeto de lei', null);
});
Breadcrumbs::for('lawsProjects.show', function ($breadcrumbs) {
    $breadcrumbs->parent('lawsProjects.list');
    $breadcrumbs->push('Projeto de lei', null);
});

/*
 * LAWS PROJECT SITUATION ADVICES
 */

Breadcrumbs::for('adviceSituationLaws.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Situação do parecer da lei', '/adviceSituationLaws');
});
Breadcrumbs::for('adviceSituationLaws.new', function ($breadcrumbs) {
    $breadcrumbs->parent('adviceSituationLaws.list');
    $breadcrumbs->push('Nova situação de parecer da lei', '/adviceSituationLaws/create');
});
Breadcrumbs::for('adviceSituationLaws.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('adviceSituationLaws.list');
    $breadcrumbs->push('Editar situação de parecer da lei', null);
});
Breadcrumbs::for('adviceSituationLaws.show', function ($breadcrumbs) {
    $breadcrumbs->parent('adviceSituationLaws.list');
    $breadcrumbs->push('situação de parecer da lei', null);
});

/*
 * LAWS PROJECT SITUATION ADVICES
 */

Breadcrumbs::for('advicePublicationLaws.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Publicação do parecer da lei', '/advicePublicationLaws');
});
Breadcrumbs::for('advicePublicationLaws.new', function ($breadcrumbs) {
    $breadcrumbs->parent('advicePublicationLaws.list');
    $breadcrumbs->push('Nova publicação de parecer da lei', '/advicePublicationLaws/create');
});
Breadcrumbs::for('advicePublicationLaws.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('advicePublicationLaws.list');
    $breadcrumbs->push('Editar publicação de parecer da lei', null);
});
Breadcrumbs::for('advicePublicationLaws.show', function ($breadcrumbs) {
    $breadcrumbs->parent('advicePublicationLaws.list');
    $breadcrumbs->push('publicação de parecer da lei', null);
});

/*
 * ATTENDANCE
 */

Breadcrumbs::for('attendance.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Atendimento', '/attendance');
});
Breadcrumbs::for('attendance.new', function ($breadcrumbs) {
    $breadcrumbs->parent('attendance.list');
    $breadcrumbs->push('Novo Atendimento', '/attendance/create');
});
Breadcrumbs::for('attendance.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('attendance.list');
    $breadcrumbs->push('Editar Atendimento', null);
});
Breadcrumbs::for('attendance.show', function ($breadcrumbs) {
    $breadcrumbs->parent('attendance.list');
    $breadcrumbs->push('Atendimento', null);
});

/*
 * PEOPLE
 */

Breadcrumbs::for('people.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Pessoa', '/people');
});
Breadcrumbs::for('people.new', function ($breadcrumbs) {
    $breadcrumbs->parent('people.list');
    $breadcrumbs->push('Novo Pessoa', '/people/create');
});
Breadcrumbs::for('people.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('people.list');
    $breadcrumbs->push('Editar Pessoa', null);
});
Breadcrumbs::for('people.show', function ($breadcrumbs) {
    $breadcrumbs->parent('people.list');
    $breadcrumbs->push('Pessoa', null);
});

/*
 * PEOPLE
 */

Breadcrumbs::for('typesOfAttendance.list', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Cadastro', null);
    $breadcrumbs->push('Tipo de Atendimento', '/types-of-attendance');
});
Breadcrumbs::for('typesOfAttendance.new', function ($breadcrumbs) {
    $breadcrumbs->parent('typesOfAttendance.list');
    $breadcrumbs->push('Novo Tipo de Atendimento', '/types-of-attendance/create');
});
Breadcrumbs::for('typesOfAttendance.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('typesOfAttendance.list');
    $breadcrumbs->push('Editar Tipo de Atendimento', null);
});
Breadcrumbs::for('typesOfAttendance.show', function ($breadcrumbs) {
    $breadcrumbs->parent('typesOfAttendance.list');
    $breadcrumbs->push('Tipo de Atendimento', null);
});
