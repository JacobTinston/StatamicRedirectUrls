@extends('statamic::layout')
@section('title', 'Import Redirects')

@section('content')
    <form action="{{ cp_route('redirect-urls.import.submit') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <header>
            <h1>Redirects Import</h1>
        </header>

        <article>
            <p style="margin: 20px 0;">
                Define URL redirects by importing a CSV/Excel file with <span>From</span>, <span>To</span> and <span>Type</span> fields. <br>
                *NOTE: Please ensure the CSV file includes a header.
            </p>
        </article>

        <div style="background-color:#fff;padding:30px;border-radius:5px;">
            <div>
                <label for="file" style="font-weight:600;">CSV</label>
                <input id="file" name="file" type="file" tabindex="1" class="input-text" accept="text/csv" style="margin:10px 0;">
            </div>

            <div>
                <button class="btn-primary">Import</button>
            </div>
        </div>
    </form>
@endsection
