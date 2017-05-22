@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create a new thread
                </div>

                <div class="panel-body">
                <form action="/threads" method="POST" role="form">

                    {{ csrf_field() }}
                                    
                    <div class="form-group">
                        <label for="channel_id">Channel:</label>
                        <select name="channel_id" id="inputChannel_id" class="form-control" required>
                            <option value="">Select one...</option>
                            @foreach ($channels as $channel)
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                    {{ $channel->slug  }}
                                </option>
                            @endforeach
                        </select>                    
                    </div>

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="inputTitle" class="form-control" value="{{ old('title') }}" required>
                    </div>
                
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea name="body" id="inputBody" class="form-control" rows="10" required>{{ old('body') }}</textarea>
                    </div>                 

                    <div class="form-gro">
                        @if (count($errors))
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                                @endforeach
                            </ul>
                        @endif   
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Publish thread</button>
                    </div>

                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
