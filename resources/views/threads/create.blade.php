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
                    <legend>Form title</legend>
                
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="inputTitle" class="form-control" value="" required="required">
                    </div>
                
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea name="body" id="inputBody" class="form-control" rows="10" required="required"></textarea>
                    </div>                    
                
                    <button type="submit" class="btn btn-primary">Publish thread</button>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
