<?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Painel de Votação - GPL</title>
    <link rel="shortcut icon" href="assets/images/logoLegis.ico" type="image/png"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body id="panel">
<div class="container-fluid">
    <div class="py-2">
        <div class="container-FLUID">
            <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <img class="card-img-top img-responsive" id="assemblyman_img" src="/front/assets/img/sem-foto.jpg"  alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase text-center text_reset" id="assemblyman"> </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="bg-dark text-center py-2 my-3 text-white">RESUMO
                        <br>
                    </h1>
                    <div class="row">
                        <div class="col-md-12 bg-light">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>VOTOS
                                        <br>
                                    </td>
                                    <td id="total" class="text_reset">-</td>
                                </tr>
                                <tr>
                                    <td>SIM</td>
                                    <td id="resume_sim" class="text_reset">-</td>
                                </tr>
                                <tr>
                                    <td>NÃO</td>
                                    <td id="resume_nao" class="text_reset">-</td>
                                </tr>
                                <tr>
                                    <td>ABSTENÇÃO</td>
                                    <td id="resume_abstention" class="text_reset">-</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <h1 class="text-center bg-dark text-uppercase py-3 text-white name_voting text_reset">-</h1>
                    <div class="row py-2 container-fluid" style="width: auto;">
                        <div class="col-md-6 border bg-success py-3">
                            <div class="row">
                                <div class="col-md-12 text-white">
                                    <h1 class="text-center">SIM
                                        <br>
                                    </h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-white">
                                    <h1 class="text-center text_reset" id="yes" style="font-size: 150px" >-</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border bg-danger py-3 text-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="text-center">NÃO</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="text-center text_reset" id="no" style="font-size: 150px">-</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        <h1 class="bg-dark text-center py-2 my-3 text-white">LISTA DE VOTOS
                            <br>
                        </h1>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group lista" id="list_impar">

                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group lista" id="list_par">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function ()
    {
        var refresh_time = 1000;
        var url = "/painel-votacao/data";

        setInterval(function (args) {
            getData(url);
        }, 1000);

    });

    var getData = function(url)
    {
        data = {
            _token : '{{csrf_token()}}'
        }
        $.ajax({
            url: url,
            method: "POST",
            data : data
        }).success(function (response) {
            response = JSON.parse(response);
            if(response.status)
            {
                setData(response);
            }else{
                resetPainel();
            }
        });
    };

    var setData = function (data)
    {
        $('.name_voting').html(data.name);

        $('#assemblyman').html(data.assemblyman_active.name);
        if(data.assemblyman_active.image != "") {
            $('#assemblyman_img').prop('src', data.assemblyman_active.image);
        }else{
            $('#assemblyman_img').prop('src', '/front/assets/img/sem-foto.jpg');
        }
        $('#total').html(data.resume.total);
        $('#resume_sim').html(data.resume.yes);
        $('#resume_nao').html(data.resume.no);
        $('#resume_abstention').html(data.resume.abstention);

        $('#yes').html(data.votes.yes);
        $('#no').html(data.votes.no);

        var list_par='';
        var list_impar='';

        $('.lista').empty();

        if(data.list){
            $.each(data.list, function (key, value) {

                if(key % 2 == 0){
                    list_par += '<li class="list-group-item d-flex justify-content-between align-items-center text-uppercase">'+ value.assemblyman;
                    if(value.vote == 'SIM') {
                        list_par += '<span class="pull-right text-success">' + value.vote + '</span>';
                    }
                    if(value.vote == 'NÃO'){
                        list_par += '<span class="pull-right text-danger">' + value.vote + '</span>';
                    }
                    if(value.vote == 'ABSTENÇÃO'){
                        list_par += '<span class="pull-right text-muted">' + value.vote + '</span>';
                    }

                    list_par += '</li>';
                }else{
                    list_impar += '<li class="list-group-item d-flex justify-content-between align-items-center text-uppercase">'+ value.assemblyman;
                    if(value.vote == 'SIM') {
                        list_impar += '<span class="pull-right text-success">' + value.vote + '</span>';
                    }
                    if(value.vote == 'NÃO'){
                        list_impar += '<span class="pull-right text-danger">' + value.vote + '</span>';
                    }
                    if(value.vote == 'ABSTENÇÃO'){
                        list_impar += '<span class="pull-right text-muted">' + value.vote + '</span>';
                    }
                }

            })
        }
        $('#list_par').append(list_par);
        $('#list_impar').append(list_impar);

    };


    var resetPainel = function () {
        $('.text_reset').html("-");
        $('.lista').empty();
        $('#assemblyman_img').prop('src', '/front/assets/img/sem-foto.jpg');
    };
</script>
</html>
