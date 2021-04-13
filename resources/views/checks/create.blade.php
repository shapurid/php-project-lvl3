{{ Form::open(['route' => ['urls.checks.store', $url->id], 'class' => 'form-inline my-2']) }}
    {{ Form::submit('Проверить', ['class' => 'btn btn-lg btn-primary text-uppercase'])}}
{{ Form::close() }}
