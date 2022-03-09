@foreach($logs as $key => $log)
    <div class="row">
        <div class="<?php echo $log->event; ?>"></div>
            <div
                @if($key%2==0)
                style="border: 1px solid #ddd; background-color: #ddd;"
                @else
                style="border: 1px solid #ddd; background-color: #fff;"
                @endif
            >
                <div>
                    <?php
                    $model = explode('\\', $log->auditable_type);
                    $table = strtoupper($model[2]);
                    $title = $translationNews[$table][$table] ?? $table;

                    switch ($log->event) {
                        case 'created':
                            echo "<label class='badge badge-success'>CRIOU</label>";
                            break;
                        case 'updated':
                            echo "<label class='badge badge-warning'>EDITOU</label>";
                            break;
                        case 'deleted':
                            echo "<label class='badge badge-danger'>DELETOU</label>";
                            break;
                    }
                    echo '<br><div class="col-sm-12"><b>MODEL: </b>'.$title.'</div><br><br>';
                    echo '<p style="border: 1px solid #adadad"></p>';
                    echo '<div class="col-sm-3"><b>ID:</b> '.strtoupper($log->auditable_id).'</div>';
                    echo '<div class="col-sm-3"><b>Data</b>: '.date('d/m/Y H:i:s', strtotime($log->created_at)).'</div>';
                    echo '<div class="col-sm-5"><b>Rota:</b> '.$log->url.'</div>';
                    echo '<div class="col-sm-1"><b>IP:</b> '.$log->ip_address.'</div>';
                    echo '<p style="border: 1px solid #adadad; margin-top: 40px;"></p>';
                    if ($log->event == 'updated') {
                        echo '<div class="col-sm-6">';
                        echo '<strong>VALOR ANTIGO</strong><br><br>';
                        $object = json_decode($log->old_values);
                        foreach ($object as $key => $value) {
                            $columns = $translationNews[$table][$key] ?? $key;
                            if (
                                $key == 'date' ||
                                $key == 'date_start' ||
                                $key == 'date_end' ||
                                $key == 'from' ||
                                $key == 'to' ||
                                $key == 'law_date'
                            ) {
                                $newDate = date('d/m/Y', strtotime($value));
                                echo '<strong>'.$columns.'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                            } else {
                                echo '<strong>'.$columns.'</strong>: '.(is_object($value) ? '' : $value).'<br style="margin-bottom: 3px">';
                            }
                        }
                        echo '</div>';
                    }
                    if ($log->event == 'updated' || $log->event == 'created') {
                        echo '<div class="col-sm-6">';
                        echo '<strong>NOVO VALOR</strong><br><br>';
                        $object = json_decode($log->new_values);
                        foreach ($object as $key => $value) {
                            $columns = $translationNews[$table][$key] ?? $key;
                            if (
                                $key == 'date' ||
                                $key == 'date_start' ||
                                $key == 'date_end' ||
                                $key == 'start_date' ||
                                $key == 'end_date' ||
                                $key == 'from' ||
                                $key == 'to' ||
                                $key == 'law_date'
                            ) {
                                $newDate = date('d/m/Y', strtotime($value));
                                echo '<strong>'.$columns.'</strong>: '.$newDate.'<br style="margin-bottom: 3px">';
                            } else {
                                echo '<strong>'.$columns.'</strong>: '.(is_object($value) ? '' : $value).'<br style="margin-bottom: 3px">';
                            }
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>


@endforeach

{!! $logs->render() !!}
