<div class="pull-left"><a href="{{ route($updateRoute, $model) }}" class="btn_1">Edit</a></div>
@if (!isset($deleteCondition) || (isset($deleteCondition) && $deleteCondition($model)))
    <div class="pull-left btn_delete">
        {!! Form::open(['route' => [$destroyRoute, $model], 'method' => 'DELETE', 'onsubmit' => 'return confirm("Do you want to delete?")']) !!}
        <button class="btn_1">Delete</button>
        {!! Form::close() !!}
    </div>
@endif