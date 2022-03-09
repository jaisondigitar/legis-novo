<style>
    #font-color{
        color: black;
    }
</style>

    <div class="row" id="font-color">
        <!-- Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Nome:') !!}
            <p>{!! $destination->name !!}</p>
        </div>

        <!-- Email Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('email', 'Email:') !!}
            <p>{!! $destination->fullName !!}</p>
        </div>
    </div>


