<div class="the-box rounded">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <ul class="list-group success">
                    @foreach($parameters as $key => $parameter)
                        <dic class="list-group-item col-md-6">
                            <div class="col-md-9">
                                <i class="fa fa-check-square-o"></i> {{$parameter->name}}
                            </div>
                            <div class="col-md-3 form-group">
                                @if($parameter->type == 1)
                                    {!! Form::select($parameter->id, [0 => 'Não', 1 => 'Sim'], $parameter->value, ['class' => 'form-control parameter']) !!}
                                @else
                                    <input type="text" value="{{$parameter->value}}" name='{{ $parameter->id }}' class="form-control" onchange="updateValue(this.name, this.value)">
                                @endif
                            </div>
                        </dic>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.parameter').change( function () {
            var id = this.name;
            var value = this.value;
            updateAjax(id, value);
        })
    });

    function updateValue(id, value) {
        updateAjax(id, value);
    }

    function updateAjax(id, value) {
        $.ajax({
            url: "{{ url('config/companies/change-parameter') }}/" + id + '/' + value,
            type: 'GET',
            dataType: 'json'
        }).done(function (result) {
            if(result == true){
                toastr.info("Parâmetro alterado com sucesso.");
            }
        });
    }
</script>
