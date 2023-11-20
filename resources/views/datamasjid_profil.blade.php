@extends('layouts.app_front')
@section('content')
    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <img class="me-3" src="{{ asset('images/logo.svg') }}" alt="" width="50" height="50" />
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1">{{ $masjid->nama }}</h1>
                <small>{{ $masjid->alamat }}</small>
            </div>
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0">{{ strtoupper($profil->judul) }}</h6>
            <div class="d-flex text-muted pt-3">
                <p class="pb-3 mb-0 small lh-sm border-bottom">
                    {!! $profil->konten !!}
                </p>
            </div>
        </div>
    </main>
@endsection
