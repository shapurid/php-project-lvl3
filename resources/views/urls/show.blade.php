@extends('layouts.app')

@php
    $fieldNames = [
        'id' => 'ID',
        'name' => 'Имя',
        'created_at' => 'Дата создания',
        'updated_at' => 'Дата обновления'
    ];
@endphp

@section('content')
    <div class="container">
            <div class="table-responsive">
                <h1 class="my-3">Сайт: {{ $url->name }}</h1>
                <table class="table table-bordered table-hover text-nowrap">
                    <tbody>
                        @foreach ($url as $key => $value)
                            @isset($fieldNames[$key])
                                <tr>
                                    <td>{{ $fieldNames[$key] }}</td>
                                    <td>{{ $value }}</td>
                                </tr>    
                            @endisset
                        @endforeach
                    </tbody>
                </table>
            </div>    
    </div>
@endsection