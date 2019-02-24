<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>About</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <h1>Halo</h1>
  Selamat datang di webapp saya.<br>
  Laravel, emang keren banget!
  <br>
  {!! Form::open(['url' => 'post/save']) !!}
  {!! Form::text('username') !!}
  {!! Form::label('email', 'E-mail address', ['class' => 'awesome']) !!}
  {!! Form::close() !!}
</body>
</html>