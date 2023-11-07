@extends('layouts.app_adminkit')

@section('content')
    <h1 class="h3 mb-3">Ubah Data User Profile</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::model(auth()->user(), [
                        'route' => ['userprofile.update', 0],
                        'method' => 'PUT',
                    ]) !!}

                    <div class="mb-3 form-group">
                        <label for="name" class="form-label">Nama</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Masukkan name']) !!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="email" class="form-label">Email</label>
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Masukkan email']) !!}
                        <span class="text-danger">{!! $errors->first('email') !!}</span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="password" class="form-label">Password</label>
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan Password Baru']) !!}
                        <span class="text-danger">{!! $errors->first('password') !!}</span>
                    </div>



                    {!! Form::submit('Simpan Perubahan', ['class' => 'btn btn-primary']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
