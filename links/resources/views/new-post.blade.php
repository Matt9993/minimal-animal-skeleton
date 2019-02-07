@extends('layouts.app')
@section('content')
<!-- Post Section -->
<div class="container">
<h3 class="jumbotron">Új hír létrehozása</h3>
        <div class="row">
            <form action="/submit-post" method="post">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Please fix the following errors
                    </div>
                @endif

                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title">Cím</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Cím" value="{{ old('title') }}">
                    @if($errors->has('title'))
                        <span class="help-block">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('topic') ? ' has-error' : '' }}">
                    <label for="topic">Téma</label>
                    <input type="text" class="form-control" id="topic" name="topic" placeholder="téma" value="{{ old('topic') }}">
                    @if($errors->has('topic'))
                        <span class="help-block">{{ $errors->first('topic') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">Tartalom</label>
                    <textarea class="form-control" id="description" name="description" placeholder="tartalom">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <span class="help-block">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection