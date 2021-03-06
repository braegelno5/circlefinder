@if(isset($item))
    {!! Form::model($item, ['route' => ['admin.users.update', 'id' => $item->id], 'method' => 'put']) !!}
@else
    {!! Form::open(['route' => 'admin.users.store']) !!}
@endif

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'E-Mail') }}
        {{ Form::email('email', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('about', 'About') }}
        {{ Form::textarea('about', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('timezone', 'Timezone', ['class' => 'required']) }}
        {!! Timezonelist::create('timezone', old('timezone', isset($item) ? $item->timezone : null), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {{ Form::label('twitter_profile', 'Twitter account') }}
        {{ Form::text('twitter_profile', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('facebook_profile', 'Facebook account') }}
        {{ Form::text('facebook_profile', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('xing_profile', 'Xing URL') }}
        {{ Form::text('xing_profile', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('linkedin_profile', 'Linkedin URL') }}
        {{ Form::text('linkedin_profile', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password', ['class' => 'form-control']) }}
    </div>

    @if(\App\Role::count())
    <h2>Roles</h2>
    <ul class="form-check">
        @foreach(\App\Role::all() as $role)
        <li>
            {{ Form::checkbox('roles[]', $role->id, isset($item) && $item->roles->contains($role), ['class' => 'form-check-input', 'id' => 'role-' . $role->id]) }} 
            {{ Form::label('role-' . $role->id, $role->title) }}
        </li>
        @endforeach
    </ul>
    @endif

    
    @if(isset($item))
        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
    @else
        {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
    @endif

@if(isset($item) && $item->trashed())
    <a href="{{ route('admin.users.trash') }}" class="btn btn-light">Cancel</a>
@else
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
@endif

{!! Form::close() !!}