@extends('layouts.app')

@php
    $urlFieldNames = [
        'id' => 'ID',
        'name' => 'Имя',
        'created_at' => 'Дата создания',
        'updated_at' => 'Дата обновления'
    ];
@endphp

@section('content')
    <div class="container">
        <h1 class="my-3">Сайт: {{ $url->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                     @foreach ($url as $key => $value)
                        @isset($urlFieldNames[$key])
                            <tr>
                                <td>{{ $urlFieldNames[$key] }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endisset
                    @endforeach
                </tbody>
            </table>
        </div>
        <h2>Проверки</h2>
        @include('checks.create')
        @isset($urlChecks)
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap">
                    <tbody>
                        <tr>
                            <td>ID</td>
                            <td>Код ответа</td>
                            <td>h1</td>
                            <td>Ключевые слова</td>
                            <td>Описание</td>
                            <td>Дата создания</td>
                        </tr>
                        @foreach($urlChecks as $check)
                            <tr>
                                <td>{{ $check->id }}</td>
                                <td>{{ $check->status_code }}</td>
                                <td>{{ $check->h1 }}</td>
                                <td>{{ $check->keywords }}</td>
                                <td>{{ $check->description }}</td>
                                <td>{{ $check->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endisset
    </div>
@endsection
