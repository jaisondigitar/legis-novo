@extends('panelVoting.panel')
@section('content')
<div class="container-fluid">
        <div class="py-2 row">
            <div class="col-md-12">
                <h1 class="bg-dark text-uppercase py-3 text-white text-center" id="session_data" > - </span>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top img-responsive" id="assemblyman_discourse_img" src="/front/assets/img/sem-foto.jpg"  alt="Card image cap">
                </div>
            </div>
            <div class="col-md-8">
                <h1 class="card-title text-center text-uppercase text_reset" id="assemblyman_discourse" style="font-size: 60px; color: #ccc"> - </h1>
                <h1 class="card-title text-center text-uppercase text_reset text-info" id="assemblyman_responsibilities" style="font-size: 40px; "> - </h1>
            </div>
        </div>

</div>
@endsection
<script src="/assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>

    var timeDiscource = null;
    $(document).ready(function ()
    {
        setInterval(function () {
            $.ajax({
                url: '/get-stage-panel',
                method: 'GET',
                async : false
            }).success(function (data) {
                data = JSON.parse(data);

                @if(\App\Models\Parameters::where('slug', 'painel-digital-permitir-multi-sessoes')->first()->value)
                    getDataAssemblyman()
                @else
                    if(data.stage != 'discourse'){
                        window.location.href = '/painel-votacao/' + data.stage;
                    }else{
                        getDataAssemblyman()
                    }
                @endif
            });
        }, 3000);
    });


    var getDataAssemblyman = function(url)
    {
        data = {
            _token : '{{csrf_token()}}'
        }
        $.ajax({
            url: "/pulpito/info",
            method: "POST",
            data : data
        }).success(function (response) {
            response = JSON.parse(response);
            if(response.status){
                setDataAssemblyman(response);
            }else{
                resetPainel();
            }
        });
    };


    var setDataAssemblyman = function (data)
    {
        var slice = data.meeting.date_start.toString().split(' ');
        slice = slice[0].toString().split('/');
        var html = data.meeting.session_type.name + ' ' + data.meeting.number + '/' + slice[2]
        $('#session_data').html(html);
        $('#assemblyman_discourse').html(data.assemblyman_name);
        $('#assemblyman_responsibilities').html(data.responsibility);
        if (data.image != "") {
            $('#assemblyman_discourse_img').prop('src', data.image);
        } else {
            $('#assemblyman_discourse_img').prop('src', '/front/assets/img/sem-foto.jpg');
        }
    };

    var resetPainel = function ()
    {
        $('#session_data').html("-");
        $('.text_reset').html("-");
        $('.lista').empty();
        $('#assemblyman_discourse_img').prop('src', '/front/assets/img/sem-foto.jpg');
    };
</script>
