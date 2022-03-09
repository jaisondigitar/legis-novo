    <style>
        #font-color{
            color: black;
        }
    </style>
    <div class="row mt-3" id="font-color">
        <!-- Id Field -->
        <div class="form-group">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $comissionSituation->id !!}</p>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            <p>{!! $comissionSituation->name !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Created At:') !!}
            <p>{!! $comissionSituation->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Updated At:') !!}
            <p>{!! $comissionSituation->updated_at !!}</p>
        </div>
    </div>

