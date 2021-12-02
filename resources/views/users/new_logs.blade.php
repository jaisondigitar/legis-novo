@extends('users.table_logs')

@section('new_log')
    <?php
//        echo "<br><p><strong>NOVO VALOR</strong></p>" . filter_var($log->new_value, FILTER_SANITIZE_STRING . "<br>");
        switch ($model[2]) {
            case 'USER'
                echo "<br><p>Setor</p>" . $log->new_value->sector_id;
                echo "<br><p>Nome</p>" . $log->new_value->name;
                echo "<br><p>E-Mail</p>" . $log->new_value->email;
                break;
            case 'ASSEMBLYMAN'
                echo "<br><p>Nome</p>" . $log->new_value->short_name;
                echo "<br><p>Nome Completo</p>" . $log->new_value->full_name;
                echo "<br><p>E-Mail</p>" . $log->new_value->email;
                echo "<br><p>Celular</p>" . $log->new_value->phone1;
                echo "<br><p>Telefone</p>" . $log->new_value->phone2;
                echo "<br><p>Documento Oficial</p>" . $log->new_value->official_document;
                echo "<br><p>RG</p>" . $log->new_value->general_register;
                echo "<br><p>CEP</p>" . $log->new_value->zipcode;
                echo "<br><p>Complemento</p>" . $log->new_value->complement;
                echo "<br><p>Número</p>" . $log->new_value->number;
                echo "<br><p>Imagem</p>" . $log->new_value->image;
                break;
            case 'COMMISSIONASSEMBLYMAN'
                echo "<br><p>Comissão</p>" . $log->new_value->commission_id;
                echo "<br><p>Parlamentar</p>" . $log->new_value->assemblyman_id;
                echo "<br><p>Oficial</p>" . $log->new_value->office;
                break;
            case 'COMMISSION'
                echo "<br><p>Nome</p>" . $log->new_value->name;
                echo "<br><p>Descrição</p>" . $log->new_value->description;
                break;
            case 'OFFICECOMMISSION'
                echo "<br><p>Nome</p>" . $log->new_value->name;
                echo "<br><p>Sigla</p>" . $log->new_value->slug;
                break;
            case 'STRUCTURELAWS'
                echo "<br><p>Lei</p>" . $log->new_value->law_id;
                echo "<br><p>Estrutura de Lei</p>" . $log->new_value->law_structure_id;
                echo "<br><p>Número</p>" . $log->new_value->number;
                echo "<br><p>Conteúdo</p>" . $log->new_value->content;
                break;
            case 'COMPANY'
                echo "<br><p>Imagem</p>" . $log->new_value->image;
                echo "<br><p>Nome</p>" . $log->new_value->shortName;
                echo "<br><p>Nome Completo</p>" . $log->new_value->fullName;
                echo "<br><p>E-Mail</p>" . $log->new_value->email;
                echo "<br><p>Celular</p>" . $log->new_value->phone1;
                echo "<br><p>Telefone</p>" . $log->new_value->phone2;
                echo "<br><p>Responsável</p>" . $log->new_value->mayor;
                echo "<br><p>cnpjCpf</p>" . $log->new_value->cnpjCpf;
                echo "<br><p>ieRg</p>" . $log->new_value->ieRg;
                echo "<br><p>Insc. Municipal</p>" . $log->new_value->im;
                echo "<br><p>Endereço</p>" . $log->new_value->address;
                echo "<br><p>Ativo</p>" . $log->new_value->active;
                break;
            case 'DOCUMENTTYPE'
                echo "<br><p>Nome</p>" . $log->new_value->name;
                echo "<br><p>Prefixo</p>" . $log->new_value->prefix;
                echo "<br><p>Situação</p>" . $log->new_value->slug;
                break;
            case 'DOCUMENTNUMBER'
                echo "<br><p>Documento</p>" . $log->new_value->document_id;
                echo "<br><p>Data</p>" . $log->new_value->date;
                break;
            case 'DOCUMENT'
                echo "<br><p>Proprietário</p>" . $log->new_value->owner_id;
                echo "<br><p>Conteúdo</p>" . $log->new_value->content;
                echo "<br><p>Data</p>" . $log->new_value->date;
                break;
            case 'MEETING'
                echo "<br><p>Tipo de Sessão</p>" . $log->new_value->session_type_id;
                echo "<br><p>Local de Sessão</p>" . $log->new_value->session_place_id;
                echo "<br><p>Número</p>" . $log->new_value->number;
                echo "<br><p>Versão da Pauta</p>" . $log->new_value->version_pauta_id;
                break;
            case 'LEGISLATUREASSEMBLYMAN'
                echo "<br><p>Parlamentar</p>" . $log->new_value->assemblyman_id;
                echo "<br><p>Legislaura</p>" . $log->new_value->legislature_id;
                break;
            case 'PARTIESASSEMBLYMAN'
                echo "<br><p>Parlamentar</p>" . $log->new_value->assemblyman_id;
                echo "<br><p>Data</p>" . $log->new_value->date;
                echo "<br><p>Parte</p>" . $log->new_value->party_id;
                break;
            case 'RESPONSIBILITYASSEMBLYMAN'
                echo "<br><p>Parlamentar</p>" . $log->new_value->assemblyman_id;
                echo "<br><p>Data</p>" . $log->new_value->date;
                echo "<br><p>Responsável</p>" . $log->new_value->responsibility_id;
                break;
            case 'PARTY'
                echo "<br><p>Instituição</p>" . $log->new_value->companies_id;
                echo "<br><p>Prefixo</p>" . $log->new_value->prefix;
                echo "<br><p>Nome</p>" . $log->new_value->name;
                break;
            case 'PROFILE'
                echo "<br><p>Ativo</p>" . $log->new_value->active;
                echo "<br><p>Prefixo</p>" . $log->new_value->prefix;
                echo "<br><p>Usuário</p>" . $log->new_value->user_id;
                break;
        }
    ?>
@endsection
