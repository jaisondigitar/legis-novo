<style>
    .log{
        padding: 5px;
        font-size: 12px;
    }
</style>
@foreach($logs as $key => $log)
    <div class="col-lg-12 log" @if($key%2==0) style="border: 1px solid #ddd; background-color: #ddd;" @else style="border: 1px solid #ddd; background-color: #fff;" @endif>
            <?php

            echo date("d/m/Y H:i:s",strtotime($log->created_at)) . "<br><br>";

            switch ($log->type){
                case "created": echo " <label class='badge badge-success'>CRIOU</label>";break;
                case "updated": echo " <label class='badge badge-warning'>EDITOU</label>";break;
                case "deleted": echo " <label class='badge badge-danger'>DELETOU</label>";break;
            }

            $model = explode("\\",$log->owner_type);
            echo "<br><b>MODEL: </b>" . strtoupper($model[2]) . " <br><b>ID:</b> " . strtoupper($log->owner_id) . "<br><br>";
            echo "<b>Rota:</b> " . $log->route . "<br>";
            echo "<b>IP:</b> " .  $log->ip . "<br>";

            if($log->type == "updated")
            {
                echo "<br><p><strong>VALOR ANTIGO</strong></p>" . filter_var($log->old_value, FILTER_SANITIZE_STRING);
            }

            if($log->type == "updated" || $log->type ==  "created")
            {
                echo "<br><br><p><strong>NOVO VALOR</strong></p>" . filter_var($log->new_value, FILTER_SANITIZE_STRING);
            }


            ?>

    </div>
@endforeach


{!! $logs->render() !!}


