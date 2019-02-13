@extends('layouts.app')

@section('content')
<div class="container box">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Albumok</div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Cím</th>
                                <th>Lehetőségek</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($albums as $album)
                                <tr>
                                    <td>{{ $album }}</td>
                                    <td>
                                        <form method="post" action="/read-album" accept-charset="UTF-8">
                                        <input type="hidden" value="{{$album}}" id="" name="albumName"/>
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-primary">Szerkesztés</button>
                                                
                                        </form>
                                        
                                        <form method="post" action='/delete-album' accept-charset="UTF-8">
                                        <input type="hidden" value="{{$album}}" id="albumName" name="albumName" />
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