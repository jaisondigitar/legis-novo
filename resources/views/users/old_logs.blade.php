@extends('users.table_logs')

@section('new_log')
    <?php
        echo '<br><p><strong>VALOR ANTIGO</strong></p>'.filter_var($log->old_value, FILTER_SANITIZE_STRING);

        echo filter_var('<br><br><br><p>Nome</p>'.$log->old_value->get('short_name'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>Nome Completo</p>'.$log->old_value->get('full_name'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>E-Mail</p>'.$log->old_value->get('email'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>Celular</p>'.$log->old_value->get('phone1'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>Telefone</p>'.$log->old_value->get('phone2'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>Documento Oficial</p>'.$log->old_value->get('official_document'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>RG</p>'.$log->old_value->get('general_register'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>CEP</p>'.$log->old_value->get('zipcode'), FILTER_SANITIZE_STRING);
        echo filter_var('<br><p>Imagem</p>'.$log->old_value->get('image'), FILTER_SANITIZE_STRING);
    ?>
@endsection
