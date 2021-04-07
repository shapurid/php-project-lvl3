{{ Form::open(['route' => ['urls.checks.store', $url->id], 'class' => 'form-inline']) }}
    {{ Form::submit('Проверить', ['class' => 'btn btn-lg btn-primary ml-3 text-uppercase'])}}
{{ Form::close() }}
