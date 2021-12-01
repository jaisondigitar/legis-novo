@extends('users.table_logs')

@section('new_log')
    <?php
        echo "<br><p><strong>NOVO VALOR</strong></p>" . filter_var($log->new_value, FILTER_SANITIZE_STRING);
        switch ($model[2]) {
            case 'ASSEMBLYMAN'
                echo "<br><p>Nome</p>" . $log->old_value->short_name;
                echo "<br><p>Nome Completo</p>" . $log->old_value->full_name;
                echo "<br><p>E-Mail</p>" . $log->old_value->email;
                echo "<br><p>Celular</p>" . $log->old_value->phone1;
                echo "<br><p>Telefone</p>" . $log->old_value->phone2;
                echo "<br><p>Documento Oficial</p>" . $log->old_value->official_document;
                echo "<br><p>RG</p>" . $log->old_value->general_register;
                echo "<br><p>CEP</p>" . $log->old_value->zipcode;
                echo "<br><p>Imagem</p>" . $log->old_value->image;
            break;
        }
    ?>
@endsection
