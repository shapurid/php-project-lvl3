@extends('layouts.app')

@section('content')
    <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Последняя проверка</th>
                            <th>Код ответа</th>
                        </tr>
                        <tr>
                            <td>{{ $url->id }}</td>
                            <td>{{ $url->name }}</td>
                            <td>{{ $url->created_at }}</td>
                            <td>{{ $url->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>    
    </div>
@endsection