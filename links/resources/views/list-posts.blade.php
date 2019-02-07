@extends('layouts.app')

@section('content')
<div class="container box">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Hírek</div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Cím</th>
                                <th>Téma</th>
                                <th>Tartalom</th>
                                <th>Lehetőségek</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->topic }}</td>
                                    <td>{{ substr($post->description, 0, 50) }}</td>
                                    <td>
                                        <form method="post" action="/read-one" accept-charset="UTF-8">
                                        <input type="hidden" value="{{$post->id}}" id="{{$post->id}}" name="id"/>
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-primary">Szerkesztés</button>
                                                
                                        </form>
                                        
                                        <form method="post" action='/delete-post' accept-charset="UTF-8">
                                        <input type="hidden" value="{{$post->id}}" id="{{$post->id}}" name="id" />
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-danger delete-object delete">Törlés</button>
                                            
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection