<table class="table table-responsive" id="attendance-table">
    <thead>
        <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Setor</th>
            <th>Visitante</th>
            <th>Tipo de Atendimento</th>
            <th>Hora Saída</th>
            <th>Manutenção</th>
        </tr>
    </thead>
    <tbody>
    @foreach($attendance as $attend)
        <tr>
            <td>{!! $attend->date !!}</td>
            <td>{!! $attend->time !!}</td>
            <td>{!! $attend->sector->name !!}</td>
            <td>{!! $attend->people->name !!}</td>
            <td>{!! $attend->type->name !!}</td>
            <td>{!! $attend->time_exit ?? '-' !!}</td>
            <td>
                {!! Form::open(['route' => ['attendance.destroy', $attend->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @shield('attendance.show')
                        <a href="{!! route('attendance.show', [$attend->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @endshield

                    <button
                        type="button"
                        class="btn btn-default btn-xs"
                        onclick="modal_exit({!! $attend->id !!})"
                    >
                        <i class="fa fa-sign-out"></i>
                    </button>

                    @shield('attendance.edit')
                        <a href="{!! route('attendance.edit', [$attend->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    @endshield

                    @shield('attendance.delete')
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endshield
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div
    class="modal fade"
    id="exit_date"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">HORA DE SAÍDA</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Date Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('date_exit', 'Data de Saída:', ['class' => 'required']) !!}
                            {!! Form::text('date_exit', null, ['class' => 'form-control datepicker']) !!}
                        </div>

                        <!-- Time Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('time_exit', 'Hora de Saída:', ['class' => 'required']) !!}
                            {!! Form::time('time_exit', null, ['class' => 'form-control time_default']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                >
                    Fechar
                </button>
                <button
                    type="button"
                    class="btn btn-primary"
                    id="date_modal_exit"
                >
                    SALVAR
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#date_exit').value = dateForm
    document.querySelector('#time_exit').value = timeForm

    const modal_exit = (id) => {
        $(document).ready(function () {
            $('#exit_date').modal('show');

            $('#date_modal_exit').click(function () {
                const url = `/attendance/${id}`;

                const data = {
                    date_exit: $('#date_exit').val(),
                    time_exit: $('#time_exit').val(),
                };

                $.ajax({
                    url: url,
                    data: data,
                    method: 'PUT'
                }).success((data) => {
                    console.log(data);
                    data = JSON.parse(data);

                    if (data) {
                        toastr.success("Pedido salvo com sucesso!!");

                        window.location.reload()
                        $('#exit_date').modal('hide');
                    } else {
                        toastr.error("Erro ao salvar pedido!!");
                    }
                });
            });
        });
    }

</script>
