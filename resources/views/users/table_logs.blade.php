<style>
    .log {
        padding: 5px;
        font-size: 12px;
    }
</style>
@foreach($logs as $key => $log)
    <div
        class="col-lg-12 log"
        @if($key%2==0)
            style="border: 1px solid #ddd; background-color: #ddd;"
        @else
            style="border: 1px solid #ddd; background-color: #fff;"
        @endif
    >
        <?php
            echo date('d/m/Y H:i:s', strtotime($log->created_at)).'<br><br>';

            switch ($log->event) {
                case 'created':
                    echo " <label class='badge badge-success'>CRIOU</label>";
                    break;
                case 'updated':
                    echo " <label class='badge badge-warning'>EDITOU</label>";
                    break;
                case 'deleted':
                    echo " <label class='badge badge-danger'>DELETOU</label>";
                    break;
            }

            $model = explode('\\', $log->auditable_type);
            echo '<br><b>MODEL: </b>'.strtoupper($model[2]).' <br><b>ID:</b> '.strtoupper($log->auditable_id).'<br><br>';
            echo '<b>Rota:</b> '.$log->url.'<br>';
            echo '<b>IP:</b> '.$log->ip_address.'<br>';

            if ($log->event == 'updated') {
                echo '<br><p><strong>VALOR ANTIGO</strong></p>';
                $object = json_decode($log->old_values);

                foreach ($object as $key=>$value) {
                    if ($key == 'date' || $key == 'date_start' || $key == 'date_end' || $key == 'law_date') {
                        $newDate = date('d/m/Y', strtotime($value));
                        echo '<strong>'.$key.'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                    } else {
                        echo '<strong>'.$key.'</strong>: '.$value.'<br style="margin-bottom: 3px">';
                    }
                }
            }

            if ($log->event == 'create' || $log->event == 'created') {
                echo '<br><p><strong>NOVO VALOR</strong></p>';
                $object = json_decode($log->new_values);

                foreach ($object as $key=>$value) {
                    if ($key == 'date' || $key == 'date_start' || $key == 'date_end' || $key == 'law_date') {
                        $newDate = date('d/m/Y', strtotime($value));
                        echo '<strong>'.$key.'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                    } else {
                        echo '<strong>'.$key.'</strong>: '.$value.'<br style="margin-bottom: 3px">';
                    }
                }
            }
        ?>
    </div>
@endforeach

{!! $logs->render() !!}
