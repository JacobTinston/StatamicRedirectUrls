@extends('statamic::layout')
@section('title', 'Redirect Urls')

@section('content')

    <header style="display:flex;align-items:center;justify-content:space-between;">
        <h1>Redirect Urls</h1>
        <a href="{{ cp_route('redirect-urls.import') }}">
            <button class="btn-primary">Import CSV</button>
        </a>
    </header>

    <div style="background-color:#fff;padding:30px;border-radius:5px;margin: 20px 0;">
        <h2 style="text-align:center;margin-bottom: 40px;">Active Urls</h2>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;">
            <h3 style="text-align:center;border-bottom:2px solid #000;padding-bottom:10px"><b>From</b></h3>
            <h3 style="text-align:center;border-bottom:2px solid #000;padding-bottom:10px"><b>To</b></h3>
            <h3 style="text-align:center;border-bottom:2px solid #000;padding-bottom:10px"><b>Type</b></h3>

            @if (count($redirects) > 1)
                @foreach ($redirects as $redirect)
                    <p style="display:flex:align-items:center;padding:10px;">{{ $redirect[0] }}</p>
                    <p style="display:flex:align-items:center;padding:10px;border-left: 2px solid #000;border-right: 2px solid #000">{{ $redirect[1] }}</p>
                    <p style="display:flex:align-items:center;padding:10px;text-align:center;">{{ $redirect[2] }}</p>
                @endforeach
            @endif
        </div>
    </div>
@endsection
