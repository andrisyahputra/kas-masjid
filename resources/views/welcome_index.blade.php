@extends('layouts.app_front')
@section('content')
    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <img class="me-3" src="{{ asset('images/logo.svg') }}" alt="" width="50" height="50" />
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1">e-Masjid</h1>
                <small>Aplikasi Pengolaan Keuangan Masjid</small>
            </div>
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0">Masjid Ter-Daftar</h6>
            @foreach ($masjids as $item)
                <div class="d-flex text-body-secondary pt-3">
                    <img class="me-3" src="{{ asset('images/masjid1.svg') }}" alt="" width="50"
                        height="50" />
                    <p class="pb-3 mb-0 small lh-sm border-bottom">
                        <a href="{{ route('data-masjid.show', $item->slug) }}" class="link">
                            <strong class="d-block text-gray-dark">{{ ucwords($item->nama) }}</strong>
                        </a>
                        {{ $item->alamat }}
                    </p>
                </div>
            @endforeach


            <small class="d-block text-end mt-3">
                <a href="{{ route('login') }}">Login Sebagai Pengurus</a>
            </small>
        </div>
    </main>
@endsection
