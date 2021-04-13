@extends('layouts.app')

@php
    $isInvalid = $errors->any() ? ' is-invalid' : '';
@endphp

@section('content')
    <div class="jumbotron text-center" style="background-color: #e3f2fd;">
        <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col-8">
                    <h1>Анализатор страниц</h1>
                    <p>Бесплатно проверяйте сайты на SEO пригодность</p>
                    {{ Form::open(['route' => 'urls.store', 'class' => 'd-flex justify-content-center']) }}
                        {{ Form::text('url[name]', null, [
                            'class' => "form-control form-control-lg{$isInvalid}",
                            'placeholder' => 'https://www.example.com'
                        ]) }}
                        {{ Form::submit('Проверить', ['class' => 'btn btn-lg btn-primary ml-3 text-uppercase'])}}
                    {{ Form::close() }}
                    @if ($errors->any())
                        <div class="text-danger text-left">{{ $errors->first() }}</div>
                    @endif
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
@endsection
