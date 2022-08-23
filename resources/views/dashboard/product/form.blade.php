<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">New Product</h4>
        </div>
        <div class="modal-body">
            {!! Form::label('name','Name') !!}
            {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'write your name product']) !!}
            @error('name')
            <div class="alert alert-danger my-2" role="alert">{{$message}}</div>
            @enderror

        </div>
        <div class="modal-body">
            {!! Form::label('desc','Description') !!}
            {!! Form::text('desc',null,['class'=>'form-control','placeholder'=>'write your Description']) !!}
            @error('desc')
            <div class="alert alert-danger my-2" role="alert">{{$message}}</div>
            @enderror

        </div>
        <div class="modal-body">
            {!! Form::label('price','Price') !!}
            {!! Form::number('price',null,['class'=>'form-control','placeholder'=>'write your price' , 'step'=>'any']) !!}
            @error('name')
            <div class="alert alert-danger my-2" role="alert">{{$message}}</div>
            @enderror

        </div>
        <div class="modal-body">
            {!! Form::label('img','Image') !!}
            {!! Form::file('img',null,['class'=>'form-control','placeholder'=>'upload image']) !!}
            @error('img')
            <div class="alert alert-danger my-2" role="alert">{{$message}}</div>
            @enderror

        </div>



        <div class="modal-footer">
            {!! Form::submit('Save'); !!}

            {!! Form::submit('close',[ 'data-dismiss'=>'modal']); !!}

        </div>

    </div>

</div>
