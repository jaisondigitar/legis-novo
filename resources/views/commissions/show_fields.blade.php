    <style>
        #font-color{
            color: black;
        }
    </style>
    <div class="row mt-3" id="font-color">
        <!-- Id Field -->
        <div class="form-group">
            {!! Form::label('id', 'Id:') !!}
            <p>{!! $commission->id !!}</p>
        </div>

        <!-- Date Start Field -->
        <div class="form-group">
            {!! Form::label('date_start', 'Date Start:') !!}
            <p>{!! $commission->date_start !!}</p>
        </div>

        <!-- Date End Field -->
        <div class="form-group">
            {!! Form::label('date_end', 'Date End:') !!}
            <p>{!! $commission->date_end !!}</p>
        </div>

        <!-- Name Field -->
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            <p>{!! $commission->name !!}</p>
        </div>

        <!-- Description Field -->
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}
            <p>{!! $commission->description !!}</p>
        </div>

        <!-- Created At Field -->
        <div class="form-group">
            {!! Form::label('created_at', 'Created At:') !!}
            <p>{!! $commission->created_at !!}</p>
        </div>

        <!-- Updated At Field -->
        <div class="form-group">
            {!! Form::label('updated_at', 'Updated At:') !!}
            <p>{!! $commission->updated_at !!}</p>
        </div>
    </div>


