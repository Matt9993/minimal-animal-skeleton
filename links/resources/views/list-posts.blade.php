@extends('layouts.app')

@section('content')
<div class="container box">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="jumbotron">Hírek</h3>
                </div>

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
                                    <td style="text-align: center;">
                                        <form method="post" action="/read-one" accept-charset="UTF-8">
                                        <input type="hidden" value="{{$post->id}}" id="{{$post->id}}" name="id"/>
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-primary" style="width: 90%; margin: 0 auto">Szerkesztés</button>
                                                
                                        </form>
                                        
                                        <form method="post" action='/delete-post' accept-charset="UTF-8">
                                        <input type="hidden" value="{{$post->id}}" id="{{$post->id}}" name="id" />
                                            {{ csrf_field() }}

                                            <button type="submit" style="width:90%; margin: 1% auto 0 auto" class="btn btn-danger delete-object delete">Törlés</button>
                                            
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