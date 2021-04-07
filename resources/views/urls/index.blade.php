@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Сайты</h1>
        @if ($urls->isEmpty())
            <p>Список проверок пуст.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Последняя проверка</th>
                            <th>Код ответа</th>
                        </tr>
                        @foreach ($urls as $url)
                        <tr>
                            <td>{{ $url->id }}</td>
                            <td>
                                <a href={{ route('urls.show', ['urlId' => $url->id]) }}>{{ $url->name }}</a>
                            </td>
                            <td>{{ $url->created_at }}</td>
                            <td>{{ $url->updated_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
