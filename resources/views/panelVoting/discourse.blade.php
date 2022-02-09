@extends('panelVoting.panel')
@section('content')
    <style>
        .child {
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
        }
        .border_radios {
            border-radius: 25px;
            margin: 20px;
            width: 30rem;
        }
        .panel {
            display: flex;
            justify-content: space-evenly;
            align-items: stretch;
            margin-top: 3%;
        }
        .text_panel, .img_panel, .message_panel {
            color: white;
            background: #3ca7ee;
            border-radius: 20px;
        }
        .img_panel {
            margin-right: 30px;
            width: auto;
        }
        .message_panel {
            flex-grow: 2;
        }
    </style>
    <div style="display: flex; justify-content: space-between; align-items: stretch; padding: 20px 50px 0 30px">
        <h1 style="font-weight: 600">
            <img
                src="/assets/images/gpl-not-description.png"
                alt="Logo"
                style="width: 10rem;"
            >
        </h1>
    </div>
    <div class="py-3 container-fluid row">
        <div class="col-md-12">
            <h1 class="py-3 text-center text_panel" id="session_data"> - </h1>
        </div>
        <div class="col-md-12 panel">
            <div class="img_panel">
                <div>
                    <img
                        class="border_radios"
                        id="assemblyman_discourse_img"
                        src="/front/assets/img/sem-foto.jpg"
                        alt="Sem imagem"
                    >
                </div>
            </div>
            <div class="message_panel">
                <div class="child">
                    <h1
                        class="card-title text-center text-uppercase text_reset"
                        id="assemblyman_discourse"
                    > - </h1>
                    <h1
                        class="card-title text-center text_reset"
                        id="assemblyman_responsibilities"
                    > - </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

<script
    src="/assets/js/jquery.min.js"
></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"
></script>
<script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"
></script>

<script>
    const getDate = (number) => {
        if (number <= 9)
            return "0" + number;
        else
            return number;
    }
    let date = new Date();
    let timeForm = (getDate(date.getHours()) + ":" + getDate(date.getMinutes()));


    $(document).ready(() => {
        setInterval(function () {
            $.ajax({
                url: '/get-stage-panel',
                method: 'GET',
                async : false
            }).success((data) => {
                data = JSON.parse(data);

                @if(\App\Models\Parameters::where('slug', 'painel-digital-permitir-multi-sessoes')->first()->value)
                    postDataAssemblyman()
                @else
                    if(data.stage !== 'discourse'){
                        window.location.href = '/painel-votacao/' + data.stage;
                    }else{
                        postDataAssemblyman()
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
                resetPanel();
            }
        });
    };

    const setDataAssemblyman = (data) => {
        let slice = data.meeting.date_start.toString().split(' ');
        slice = slice[0].toString().split('/');
        const html = data.meeting.session_type.name + ' ' + data.meeting.number + '/' + slice[2]

        $('#session_data').html(html);
        $('#assemblyman_discourse').html(data.assemblyman_name);
        $('#assemblyman_responsibilities').html(data.responsibility);

        if (data.image !== "") {
            $('#assemblyman_discourse_img').prop('src', data.image ?? '/front/assets/img/sem-foto.jpg');
        } else {
            $('#assemblyman_discourse_img').prop('src', '/front/assets/img/sem-foto.jpg');
        }
    };

    const resetPanel = () => {
        $('#session_data').html("-");
        $('.text_reset').html("-");
        $('.lista').empty();
        $('#assemblyman_discourse_img').prop('src', '/front/assets/img/sem-foto.jpg');
    };
</script>
