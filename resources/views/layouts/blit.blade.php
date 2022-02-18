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
    <title>GPL</title>
    <link rel="shortcut icon" href="/assets/images/logoLegis.ico" type="image/png"/>

    <!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- PLUGINS CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap2/bootstrap-switch.min.css" rel="stylesheet">
    <link href="/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
    <link href="/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
    <link href="/assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
    <link href="/assets/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
    <link href="/assets/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
    <link href="/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
    <link href="/assets/plugins/icheck/skins/all.css" rel="stylesheet">
    <link href="/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
    <link href="/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
    <link href="/assets/plugins/markdown/bootstrap-markdown.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.4/af-2.3.7/datatables.min.css"/>
    <link href="/assets/plugins/morris-chart/morris.min.css" rel="stylesheet">
    <link href="/assets/plugins/c3-chart/c3.min.css" rel="stylesheet">
    <link href="/assets/plugins/slider/slider.min.css" rel="stylesheet">
    <link href="/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
    <link href="/assets/plugins/toastr/toastr.css" rel="stylesheet">
    <link href="/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="/assets/plugins/fullcalendar/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- MAIN CSS (REQUIRED ALL PAGE)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="https://js.pusher.com/3.0/pusher.min.js"></script>
    <script src="/assets/pusher.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .width {
            width: 100%;
        }

        .page-content {
            display: grid;
        }
        a {
            text-decoration: none;
        }
        .form-check-input {
            clear: left;
        }

        .form-check {
            min-height: 0;
        }

        .form-switch.form-switch-sm {
            margin-bottom: 0.5rem; /* JUST FOR STYLING PURPOSE */
        }

        .form-switch.form-switch-sm .form-check-input {
            height: 1rem;
            width: calc(1rem + 0.75rem);
            border-radius: 2rem;
        }

        .form-switch.form-switch-md {
            margin-bottom: 1rem; /* JUST FOR STYLING PURPOSE */
        }

        .form-switch.form-switch-md .form-check-input {
            height: 1.5rem;
            width: calc(2rem + 0.75rem);
            border-radius: 3rem;
        }

        .form-switch.form-switch-lg {
            margin-bottom: 1.5rem; /* JUST FOR STYLING PURPOSE */
        }

        .form-switch.form-switch-lg .form-check-input {
            height: 2rem;
            width: calc(3rem + 0.75rem);
            border-radius: 4rem;
        }

        .form-switch.form-switch-xl {
            margin-bottom: 2rem; /* JUST FOR STYLING PURPOSE */
        }

        .form-switch.form-switch-xl .form-check-input {
            height: 2.5rem;
            width: calc(4rem + 0.75rem);
            border-radius: 5rem;
        }
        .form-check-input:checked {
            background-color: #74AD3B;
            border-color: #74AD3B;
        }
        .log {
            padding: 5px;
            font-size: 12px;
        }
        .created {
            padding: 10px;
            background: #8CC152;
        }
        .updated {
            padding: 10px;
            background: #F6BB42;
        }
        .deleted {
            padding: 10px;
            background: #E9573F;
        }
        .busy * {
            cursor: wait !important;
        }
        body {
            position: relative;
            min-height: 100vh;
            background: #E8E9EE;
        }

        .wrapper {
            height: 100%;
            padding-bottom: 5rem;
        }

        footer {
            position: absolute;
            height: 5rem;
            bottom: 0;
            width: 100%;
            margin-top: 0;
            border-top: 0;
        }

        .dropdown-submenu {
            position: relative;
        }

        .logo-brand img {
            margin-top: 0;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 0 6px 6px 6px;
            -moz-border-radius: 0 6px 6px;
            border-radius: 0 6px 6px 6px;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-submenu>a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
        }

        .dropdown-submenu:hover>a:after {
            border-left-color: #fff;
        }

        .dropdown-submenu.pull-left {
            float: none;
        }

        .dropdown-submenu.pull-left>.dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }
        .required:before {
            content: '*';
            color: red;
            padding-right: 3px;
        }
        .resume {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            margin: 0;
        }
    </style>
    <script type="application/javascript">
        $(document).ready(function() {
            $('.permissionDataTable').DataTable({
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });
        });

        const getDate = (number) => {
            if (number <= 9)
                return "0" + number;
            else
                return number;
        }
        let date = new Date();

        Date.prototype.addDays = function(days) {
            const date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }

        let newDate = date.addDays(10)
        let newDateFive = date.addDays(5)
        let newDateTwenty = date.addDays(20)

        let dateForm = (
            getDate(date.getDate().toString()) + "/"
            + (getDate(date.getMonth()+1).toString()) + "/"
            + date.getFullYear());

        let dateTimeForm = (
            getDate(date.getDate().toString()) + "/"
            + (getDate(date.getMonth()+1).toString()) + "/"
            + date.getFullYear() + " "
            + getDate(date.getHours()) + ":"
            + getDate(date.getMinutes()));

        let someDateForm = (
            getDate(newDate.getDate().toString()) + "/"
            + (getDate(newDate.getMonth()+1).toString()) + "/"
            + newDate.getFullYear());

        let someDateFiveForm = (
            getDate(newDateFive.getDate().toString()) + "/"
            + (getDate(newDateFive.getMonth()+1).toString()) + "/"
            + newDateFive.getFullYear());

        let someDateTwentyForm = (
            getDate(newDateTwenty.getDate().toString()) + "/"
            + (getDate(newDateTwenty.getMonth()+1).toString()) + "/"
            + newDateTwenty.getFullYear());

        let timeForm = (getDate(date.getHours()) + ":" + getDate(date.getMinutes()));

        jQuery.ajaxSetup({
            beforeSend: function() {
                $('body').addClass('busy');
            },
            complete: function() {
                $('body').removeClass('busy');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "8000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        const viaCep = async value => {
            const cep = parseInt(value.normalize('NFD').replace(/([\u0300-\u036f]|[^0-9a-zA-Z])/g, ''));

            const resp = await fetch(
                `http://viacep.com.br/ws/${cep}/json/`, {
                    method: 'GET',
                }
            ).catch(() => new Error(`Estado inválido`))
            return await resp.json();
        }

        const getStates = async (uf) => {
            const resp = await fetch(
                `/get-state?uf=${uf}`, {
                    headers: { 'X-CSRF-Token': '{!! csrf_token() !!}' },
                    method: 'POST',
                }
            ).catch(() => new Error(`Estado inválido`))

            const state = await resp.json();

            return state[0].id;
        }

        const getCities = async function(id, city) {

            const state  = $("#"+id).val() || id;

            $.ajax({
                method: "POST",
                url: `/getcities/${state}`,
                data: {
                    _token: "{!! csrf_token() !!}",
                    state: state
                },
                dataType: "json"
            }).success(function(result) {
                const cities = $('.cities');

                cities.empty();

                $.each(result, function(i, item) {
                    if (item.name.toLowerCase() === city.toLowerCase()) {
                        cities.append('<option value="' + item.id + '" selected>' + item.name + '</option>');
                    } else {
                        cities.append('<option value="' + item.id + '">' + item.name + '</option>');
                    }
                });
            });
        }

        const getPeople = async cpf => {
            if (!cpfVerifier(cpf)) {
                showMessage({
                    title: 'Erro',
                    message: 'CPF inválido!',
                    type: 'error'
                })

                return
            }

            const resp = await fetch(
                `/people/search-by-cpf?cpf=${cpf}`, {
                    headers: { 'X-CSRF-Token': '{!! csrf_token() !!}' },
                    method: 'POST',
                }
            ).catch(() => new Error(`Não possível obter dados do CPF ${cpf}`))

            const data = await resp.json()

            if (data) {
                document.querySelector('.phone1').value = data.celular
                document.querySelector('.name').value = data.name
                document.querySelector('.street').value = data.street
                document.querySelector('.number').value = data.number
                document.querySelector('.cep').value = data.zipcode
                document.querySelector('.states').value = data.state_id
                document.querySelector('.complement').index = data.complement
                document.querySelector('.district').value = data.district
                document.querySelector('.rg').value = data.rg
                document.querySelector('.email').value = data.email
                document.querySelector('.phone2').value = data.telephone

                if (data.image) {
                    document.querySelector('.logo-inst').style.display = 'block'
                    document.querySelector('.upload').style.display = 'none'
                    document.querySelector('.logo-inst img').setAttribute('src', data.image)
                    document.querySelector('.logo-inst img').setAttribute('id', data.id)
                }

                const dataCep = await viaCep(data.zipcode);
                await getCities(data.state_id, dataCep.localidade)
            } else {
                clear_form()
            }
        }

        const cpfVerifier = cpf => {
            if (typeof cpf !== 'string') return false

            cpf = cpf.replace(/[^\d]+/g, '')

            if (cpf.length !== 11 || !!cpf.match(/(\d)\1{10}/)) return false

            cpf = cpf.split('')

            const validator = cpf
                .filter((digit, index, array) => index >= array.length - 2 && digit)
                .map( el => +el )

            const toValidate = pop => cpf
                .filter((digit, index, array) => index < array.length - pop && digit)
                .map(el => +el)

            const rest = (count, pop) => (toValidate(pop)
                .reduce((soma, el, i) => soma + el * (count - i), 0) * 10) % 11 % 10

            return !(rest(10,2) !== validator[0] || rest(11,1) !== validator[1])
        }

        const showMessage = data => {
            toastr[data.type](data.message, data.title);
        }

        const clear_form = () => {
            $("#street").val("");
            $("#district").val("");
            $("#number").val("");
            $(".states").val("");
            $(".cities").val("");
            $(".phone").val("");
            $(".name").val("");
            $(".street").val("");
            $(".complement").val("");
            $(".district").val("");
            $(".number").val("");
            $(".cep").val("");
        }
    </script>
</head>

<body class="tooltips top-navigation">
@include('popper::assets')

<!--
===========================================================
BEGIN PAGE
===========================================================
-->
<div class="wrapper open-loading">
    <!-- BEGIN TOP NAV -->
    <div class="top-navbar dark-color">
        <div class="top-navbar-inner">

            <!-- Begin Logo brand -->
            <a href="/admin">
                <div class="logo-brand" style="padding: 5px 0">
                    <img
                        src="/assets/images/gpl-not-description.png"
                        alt="Logo"
                        style="max-width: 100%;
                        height: 100%;"
                    >
                </div><!-- /.logo-brand -->
            </a>
            <!-- End Logo brand -->

            <div class="top-nav-content main-top-nav-layout">
                <!-- Begin user session nav -->
                <ul class="nav-user navbar-right">
                    <li class="dropdown">
                        <a href="#fakelink" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong>{{ Auth::user()->name }}</strong>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/edit-password"><i class="fa fa-key"></i> Mudar senha </a>
                                <a class="dropdown-item" href="/logout"><i class="fa fa-sign-out"></i> Sair do sistema</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Begin Collapse menu nav -->
                <div style="padding: 5px 15px">
                    <span style="color: #FFFFFF;">{{ Auth::user()->company->shortName }}</span>
                    <br>
                    <span style="color: #CCCCCC;">{{ Auth::user()->company->fullName }} - {{ Auth::user()->company->cnpjCpf }}</span>
                </div>

            </div><!-- /.top-nav-content -->
        </div><!-- /.top-navbar-inner -->
    </div><!-- /.top-navbar -->
    <!-- END TOP NAV -->

    <div class="top-main-navigation" style="border: none;">
            {!! View::make('layouts.navbar') !!}
    </div>

    <!-- BEGIN SIDEBAR RIGHT HEADING -->
    <div class="sidebar-right-heading">
        <ul class="nav nav-tabs square nav-justified">
            <li class="active"><a href="#online-user-sidebar" data-toggle="tab"><i class="fa fa-comments"></i></a></li>
            <li><a href="#notification-sidebar" data-toggle="tab"><i class="fa fa-bell"></i></a></li>
            <li><a href="#task-sidebar" data-toggle="tab"><i class="fa fa-tasks"></i></a></li>
            <li><a href="#setting-sidebar" data-toggle="tab"><i class="fa fa-cogs"></i></a></li>
        </ul>
    </div><!-- /.sidebar-right-heading -->
    <!-- END SIDEBAR RIGHT HEADING -->



    <!-- BEGIN SIDEBAR RIGHT -->
    <div class="sidebar-right sidebar-nicescroller">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="online-user-sidebar">
                <ul class="sidebar-menu online-user">
                    <li class="static">Lista de usuarios</li>
                    @if(isset($users))
                        @foreach($users as $reg)
                        <li><a href="#fakelink">
                                <span class="user-status @if($reg->isOnline()) success @else danger @endif"></span>
                                <img src="/assets/img/avatar/avatar-1.jpg" class="ava-sidebar img-circle" alt="Avatar">
                                {{ $reg->name }}
                                <span class="small-caps">Financeiro</span>
                            </a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="tab-pane fade" id="notification-sidebar">
                <ul class="sidebar-menu sidebar-notification">
                    <li class="static">TODAY</li>
                    <li><a href="#fakelink" data-toggle="tooltip" title="Maria Simpson" data-placement="left">
                            <img src="/assets/img/avatar/avatar.jpg" class="ava-sidebar img-circle" alt="Avatar">
                            <span class="activity">Change her avatar</span>
                            <span class="small-caps">20 hours ago</span>
                        </a></li>
                    <li class="static">YESTERDAY</li>
                    <li><a href="#fakelink" data-toggle="tooltip" title="Jason Crawford" data-placement="left">
                            <img src="/assets/img/avatar/avatar.jpg" class="ava-sidebar img-circle" alt="Avatar">
                            <span class="activity">Posted something on your profile page</span>
                            <span class="small-caps">Yesterday 10:45:12</span>
                        </a></li>
                    <li class="static text-center"><button class="btn btn-primary btn-sm">See all notifications</button></li>
                </ul>
            </div>
            <div class="tab-pane fade" id="task-sidebar">
                <ul class="sidebar-menu sidebar-task">
                    <li class="static">UNCOMPLETED</li>
                    <li><a href="#fakelink" data-toggle="tooltip" title="in progress" data-placement="left">
                            <i class="fa fa-clock-o icon-task-sidebar progress"></i>
                            In progress task
                            <span class="small-caps">Deadline : Next week</span>
                        </a></li>
                    <li><a href="#fakelink" data-toggle="tooltip" title="uncompleted" data-placement="left">
                            <i class="fa fa-exclamation-circle icon-task-sidebar uncompleted"></i>
                            Uncompleted task
                            <span class="small-caps">Deadline : 2 hours ago</span>
                        </a></li>


                    <li class="static">COMPLETED</li>
                    <li><a href="#fakelink" data-toggle="tooltip" title="completed" data-placement="left">
                            <i class="fa fa-check-circle-o icon-task-sidebar completed"></i>
                            Completed task
                            <span class="small-caps">Completed : 10 hours ago</span>
                        </a></li>


                    <li class="static text-center"><button class="btn btn-success btn-sm">See all tasks</button></li>
                </ul>
            </div><!-- /#task-sidebar -->
            <div class="tab-pane fade" id="setting-sidebar">
                <ul class="sidebar-menu">
                    <li class="static">ACCOUNT SETTING</li>
                    <li class="text-content">
                        <div class="switch">
                            <div class="onoffswitch blank">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch3" checked>
                                <label class="onoffswitch-label" for="onoffswitch3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        Example on off switch
                    </li>
                    <li class="text-content">
                        <div class="switch">
                            <div class="onoffswitch blank">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch4">
                                <label class="onoffswitch-label" for="onoffswitch4">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        Example on off switch
                    </li>
                </ul>
            </div><!-- /#setting-sidebar -->
        </div><!-- /.tab-content -->
    </div><!-- /.sidebar-right -->
    <!-- END SIDEBAR RIGHT -->
    @yield('Breadcrumbs')
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content no-left-sidebar">
        <div class="container-fluid" >
            @if (Session::has('flash_notification'))
                <script type="application/javascript">
                    toastr["{{ Session::get('flash_notification')->first()->level }}"]
                    ("{{ Session::get('flash_notification')->first()->message }}");
                </script>
                <div class="alert alert-{{ Session::get('flash_notification')->first()->level }} alert-bold-border square fade in alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('flash_notification')->first()->message }}
                </div>
            @endif
            @yield('content')
        </div><!-- /.container-fluid -->
    </div><!-- /.page-content -->
</div><!-- /.wrapper -->
<!-- END PAGE CONTENT -->

<!-- BEGIN FOOTER -->
<footer>
    &copy; {{Date('Y')}} <a href="https://www.genesis.tec.br/" target="_blank">
        Gênesis Tecnologia e Inovação
    </a>. Todos os Direitos Reservados
</footer>
<!-- END FOOTER -->

{{--<!-- BEGIN BACK TO TOP BUTTON -->
<div id="back-top">
    <a href="#top"><i class="fa fa-chevron-up"></i></a>
</div>
<!-- END BACK TO TOP -->--}}




<!--
===========================================================
END PAGE
===========================================================
-->

<!--
===========================================================
Placed at the end of the document so the pages load faster
===========================================================
-->
<!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->

<script src="/assets/plugins/retina/retina.min.js"></script>
<script src="/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
<script src="/assets/plugins/ckeditor/ckeditor.js"></script>
<script src="/assets/plugins/ckeditor/config.js"></script>
<script src="/assets/plugins/ckeditor/lang/pt-br.js"></script>

<!-- PLUGINS -->
<script src="/assets/plugins/skycons/skycons.js"></script>
<script src="/assets/plugins/prettify/prettify.js"></script>
<script src="/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
<script src="/assets/plugins/chosen/chosen.jquery.min.js"></script>
<script src="/assets/plugins/icheck/icheck.min.js"></script>
<script src="/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="/assets/plugins/mask/jquery.mask.min.js"></script>
<script src="/assets/plugins/validator/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.4/af-2.3.7/datatables.min.js"></script>
<script src="/assets/plugins/summernote/summernote.min.js"></script>
<script src="/assets/plugins/markdown/markdown.js"></script>
<script src="/assets/plugins/markdown/to-markdown.js"></script>
<script src="/assets/plugins/markdown/bootstrap-markdown.js"></script>
<script src="/assets/plugins/slider/bootstrap-slider.js"></script>
<script src="/assets/plugins/salvattore/salvattore.min.js"></script>


<!-- FULL CALENDAR JS -->
<script src="/assets/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
<script src="/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="/assets/js/full-calendar.js"></script>

<!-- EASY PIE CHART JS -->
<script src="/assets/plugins/easypie-chart/easypiechart.min.js"></script>
<script src="/assets/plugins/easypie-chart/jquery.easypiechart.min.js"></script>

<!-- KNOB JS -->
<!--[if IE]>
<script type="text/javascript" src="/assets/plugins/jquery-knob/excanvas.js"></script>
<![endif]-->
<script src="/assets/plugins/jquery-knob/jquery.knob.js"></script>
<script src="/assets/plugins/jquery-knob/knob.js"></script>

<!-- FLOT CHART JS -->
<script src="/assets/plugins/flot-chart/jquery.flot.js"></script>
<script src="/assets/plugins/flot-chart/jquery.flot.tooltip.js"></script>
<script src="/assets/plugins/flot-chart/jquery.flot.resize.js"></script>
<script src="/assets/plugins/flot-chart/jquery.flot.selection.js"></script>
<script src="/assets/plugins/flot-chart/jquery.flot.stack.js"></script>
<script src="/assets/plugins/flot-chart/jquery.flot.time.js"></script>

<!-- MORRIS JS -->
<script src="/assets/plugins/morris-chart/raphael.min.js"></script>
<script src="/assets/plugins/morris-chart/morris.min.js"></script>

<!-- C3 JS -->
<script src="/assets/plugins/c3-chart/d3.v3.min.js" charset="utf-8"></script>
<script src="/assets/plugins/c3-chart/c3.min.js"></script>

<!-- MAIN APPS JS -->
<script src="/assets/js/apps.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>


<!-- SHRINK NAVBAR JS-->
<script src="/assets/js/shrink-main-navigation.js"></script>

<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js'></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/locales/bootstrap-datepicker.pt-BR.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/locale/pt-br.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>

<script type="application/javascript">
    $( document ).ready(function() {
        const SPMaskBehavior = function (val) {return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';},
                spOptions = {onKeyPress: function(val, e, field, options) {field.mask(SPMaskBehavior.apply({}, arguments), options);}};
        $('.phone').mask(SPMaskBehavior, spOptions);

        /* Mask rg not used */
        /*
        const RGMask = function (val) {return val.replace(/\D/g, '').length === 9 ? '000.000.099' : '0.000.00099';},
                rgOptions = {onKeyPress: function(val, e, field, options) {field.mask(RGMask.apply({}, arguments), options);}};
        $('.rg').mask(RGMask, rgOptions);
        */

        $('.tableData').dataTable();
        $('.currency').maskMoney();


        $('.cep').mask('99999-000');
        $('.cpf').mask('999.999.999-99');
        $('.cnpj').mask('99.999.999/9999-99');

        var SPMaskBehavior2 = function (val) {return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';},
                spOptions2 = {onKeyPress: function(val, e, field, options) {field.mask(SPMaskBehavior2.apply({}, arguments), options);}};
        $('.cpfcnpj').mask(SPMaskBehavior2, spOptions2);

        $('.datetimepicker1').datetimepicker({
            locale: 'pt-BR'
        });

        $('.datepicker').mask('99/99/9999');
        $('.datetimepicker1').mask('99/99/9999 99:99');


        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            autoclose: true
        });


        $('.switch').bootstrapSwitch();
        tinymce.init({
            forced_root_block : '',
            selector: '.editor',
            height: 500,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            content_css: '//www.tinymce.com/css/codepen.min.css'
        });
        $('.cnpjcpf').mask("999.999.999-99?99999").on('keyup', function (e) {
            var query = $(this).val().replace(/[^a-zA-Z 0-9]+/g,'');
            if (query.length <= 11) {
                $('.cnpjcpf').mask("999.999.999-99?99999").val(query);
            }else{
                $('.cnpjcpf').mask("99.999.999/9999-99").val(query);;
            }
        }).focusout(function() {
            var query = $(this).val().replace(/[^a-zA-Z 0-9]+/g,'');
            if(query.length>0) {
                if (query.length <= 11) {
                    if (!validaCpf(query)) {
                        alert("CPF Inválido!");
                        $(this).focus();
                    }
                } else {
                    if (!validaCnpj(query)) {
                        alert("CNPJ Inválido!");
                        $(this).focus();
                    }
                }
            }
        });
    });

    var validaCpf = function(strCPF){
        var Soma;
        var Resto;
        Soma = 0;
        //strCPF  = RetiraCaracteresInvalidos(strCPF,11);
        if (strCPF == "00000000000")
            return false;
        for (i=1; i<=9; i++)
            Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11))
            Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) )
            return false;
        Soma = 0;
        for (i = 1; i <= 10; i++)
            Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11))
            Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) )
            return false;
        return true;
    }

    var validaCnpj = function(cnpj){
        if(cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
                cnpj == "11111111111111" ||
                cnpj == "22222222222222" ||
                cnpj == "33333333333333" ||
                cnpj == "44444444444444" ||
                cnpj == "55555555555555" ||
                cnpj == "66666666666666" ||
                cnpj == "77777777777777" ||
                cnpj == "88888888888888" ||
                cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado !== digitos.charAt(1))
            return false;

        return true;
    }

    $(document).ready(function() {
        $(".states").val(12);
        $(".cities").val(5132);

        $("#zipcode").blur(async function () {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep !== "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    const data = await viaCep(cep);

                    if (!("erro" in data)) {
                        const stateId = await getStates(data.uf)

                        //Atualiza os campos com os valores da consulta.
                        $("#street").val(data.logradouro);
                        $("#district").val(data.bairro);
                        $(".states").val(stateId);

                        await getCities(stateId, data.localidade)

                        $("#number").focus();
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        clear_form();
                        alert("CEP não encontrado.");
                    }
                } //end if.
                else {
                    //cep é inválido.
                    clear_form();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                clear_form();
            }
        });
    });
</script>

@if(Auth::check() && Auth::user()->sector->slug=='gabinete')
    <div class="modal fade" id="select_gabinete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-no-shadow">
                <div class="modal-header bg-dark no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-uppercase">Selecione o gabinete</h4>
                </div>
                <div class="modal-body">

                    {!! Form::select('assemblyman_id', \App\Models\Assemblyman::whereIn('id',
                    \App\Models\UserAssemblyman::where('users_id', Auth::user()->id)->pluck
                    ('assemblyman_id')->toArray())->pluck('short_name', 'id')->prepend('Selecione',
                     0), null,['id'=>'assemblyman_id','class' => 'form-control', 'onchange'=>'select_assemblyman()']) !!}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <a href="javascript:void(0);" id="link_voting" class="btn btn-primary" onclick="open_voting()">Painel de votação</a>
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-content .modal-no-shadow -->
        </div><!-- /.modal-dialog -->
    </div>
    <script>
        $(document).ready(function () {
            $('#assemblyman_id').val(0);
        })

        var select_assemblyman = function ()
        {
            url = '/voting/assemblyman/' + $('#assemblyman_id').val();
            $('#assemblyman_id').val() == 0 ? $('#link_voting').attr('href', 'javascript:void(0)') : $('#link_voting').attr('href', url);
        }

        var open_voting = function ()
        {
            if($('#assemblyman_id').val() == 0){
                toastr.error('Selecione um parlamentar!');
            }
        }

    </script>
@endif

</body>
</html>
