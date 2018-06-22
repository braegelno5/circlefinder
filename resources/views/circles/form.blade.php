@if(isset($item))
    {!! Form::model($item, ['route' => ['circles.update', 'uuid' => $item->uuid], 'method' => 'put']) !!}
@else
    {!! Form::open(['route' => 'circles.store']) !!}
@endif

    <div class="form-group">
        {{ Form::label('type', 'Type') }}
        {{ Form::select('type', array_combine(Config::get('circle.defaults.types'), Config::get('circle.defaults.types')), null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>

    @if(isset($item))
        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
    @else
        {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
    @endif

    <a href="{{ route('circles.show', ['uuid' => $item->uuid]) }}" class="btn btn-light">Cancel</a>

{!! Form::close() !!}