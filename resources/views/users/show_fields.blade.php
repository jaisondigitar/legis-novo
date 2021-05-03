<!-- Id Field -->

<!-- Institute Id Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('company_id', 'Filial:') !!}
    <p>{!! $user->company->shortName !!} : {!! $user->company->shortName !!}</p>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Level Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('level', 'Level:') !!}
    <p>1</p>
</div>

<!-- Active Field -->
<div class="form-group col-sm-6 col-lg-4">
    {!! Form::label('active', 'Active:') !!}
    <p>{!! $user->active !!}</p>
</div>


<div class="col-sm-12">
    <div class="panel with-nav-tabs panel-info">
        <div class="panel-heading">
            <div class="right-content">
                <div class="btn-group">
                    <button class="btn btn-info btn-sm btn-rounded-lg dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu info pull-right square margin-list" role="menu">
                        <li><a href="#fakelink">Action</a></li>
                        <li><a href="#fakelink">Another action</a></li>
                        <li class="active"><a href="#fakelink">Active</a></li>
                        <li class="divider"></li>
                        <li><a href="#fakelink">Separated link</a></li>
                    </ul>
                </div>
                <button class="btn btn-info btn-rounded-lg to-collapse" data-toggle="collapse" data-target="#panel-collapse-2"><i class="fa fa-chevron-up"></i></button>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#permissions" data-toggle="tab" aria-expanded="true"><i class="fa fa-newspaper-o"></i> Permissões</a></li>
                <li class=""><a href="#panel-profile-2" data-toggle="tab" aria-expanded="false"><i class="fa fa-dollar"></i> Financeiro</a></li>
            </ul>
        </div>
        <div id="panel-collapse-2" class="collapse in">
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="permissions">
                        @foreach($permCompany as $perm)
                        <div class="col-sm-3">
                            <input  type="checkbox" @if($user->hasPermission($perm->id))checked @endif> {{ $perm->name }}
                        </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="panel-profile-2">
                        <h4>Profile</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.
                        </p>
                    </div>
                </div><!-- /.tab-content -->
            </div><!-- /.panel-body -->
        </div><!-- /.collapse in -->
    </div><!-- /.panel .panel-info -->
</div>
