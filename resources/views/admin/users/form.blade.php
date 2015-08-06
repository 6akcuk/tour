<!-- Name Form Input -->
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
  {!! Form::label('name', 'Name:', []) !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
  {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
</div>

<!-- Username Form Input -->
<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
  {!! Form::label('username', 'Username:', []) !!}
  {!! Form::text('username', null, ['class' => 'form-control']) !!}
  {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
</div>

<!-- Email Form Input -->
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
  {!! Form::label('email', 'Email:', []) !!}
  {!! Form::email('email', null, ['class' => 'form-control']) !!}
  {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
</div>

<!-- Password Form Input -->
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
  {!! Form::label('password', 'Password:', []) !!}
  {!! Form::password('password', ['class' => 'form-control']) !!}
  {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
</div>