<!-- Tag Form Input -->
<div class="form-group {{ $errors->has('tag') ? 'has-error' : '' }}">
    {!! Form::label('tag', 'Tag:', []) !!}
    {!! Form::text('tag', null, ['class' => 'form-control']) !!}
    {!! $errors->first('tag', '<span class="help-block">:message</span>') !!}
</div>