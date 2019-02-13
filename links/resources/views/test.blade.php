@extends('layouts.app')

@section('content')
<div class="container box">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Album szerkesztés</h2></div>

                <div class="panel-body">
                    <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Borító kép</th>
                                    <th>Kép</th>
                                    <th>Név</th>
                                    <th>Lehetőségek</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="radio" name="main" value="{{ $mainPic }}" /></td>

                                        <td><img id="{{ $mainPic }}" src="{{ URL::asset($coverPath . '/' . $mainPic) }}" width="336" height="69"></td>
                                        <td> {{ $mainPic }} </td>
                                        <td>
                                            
                                            <form method="post" action='/delete-pics' accept-charset="UTF-8">
                                                <input type="hidden" value="{{$mainPic}}" id="picName" name="mainPicName" />
                                                <input type="hidden" value="{{$title}}" id="albumName" name="albumName" />
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-danger delete-object delete">Törlés</button>
                                                
                                            </form>
                                        </td>
                                    </tr>
                                    @foreach ($album as $pics)
                                    <tr>
                                        <td><input type="radio" name="main" value="{{ $pics }}" /></td>

                                        <td><img id="{{ $pics }}" src="{{ URL::asset($path . '/' . $pics) }}" width="336" height="69"></td>
                                        <td> {{ $pics }} </td>
                                        <td>
                                            
                                            <form method="post" action='/delete-pics' accept-charset="UTF-8">
                                                <input type="hidden" value="{{$pics}}" id="picName" name="picName" />
                                                <input type="hidden" value="{{$title}}" id="albumName" name="albumName" />
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-danger delete-object delete">Törlés</button>
                                                
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <br>
                            <button id='saveImages'  class="btn btn-primary save" style="margin-top:10px">Submit</button>
                        
                        <form method="post" action="{{url('form-add')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                            <h2>Új kép hozzáadása az albumhoz</h2>
                            <div class="input-group control-group increment" >
                                <input type="file" name="filename[]" class="form-control" id="pics">
                            <div class="input-group-btn"> 
                                <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                            </div>
                            </div>
                            <div class="clone hide">
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="file" name="filename[]" class="form-control">
                                <div class="input-group-btn"> 
                                <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                </div>
                            </div>
                            </div>
                            <input type="hidden" value="{{$title}}" id="title" name="title" />
                            <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {

        $(".save").click(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('[name="_token"]').val()
                }
            });
            let radioButtons = jQuery('td').children();
            let reqInfo = [];
            for(let i = 0; i < radioButtons.length; i+=3){
                 reqInfo.push(radioButtons[i]);
            }
           
            let title = jQuery('#title').val();
            let mainPic;
            let files = [];
            for(let j = 0; j < reqInfo.length; j++){
                if(reqInfo[j].checked == true){
                    mainPic = reqInfo[j].value;
                    let index = reqInfo.indexOf(reqInfo[j]);
                    reqInfo.splice(index, 1);
                } else {
                    files.push(reqInfo[j].value);
                }
            }
            for(let k = 0; k < files.length; k++){
                console.log(files[k]);
            }
            
            jQuery.ajax({
                url: "{{ url ('/edit-album') }}",
                method: 'post',
                data: {
                    title: title,
                    main: mainPic,
                    pics: files,
                },
                dataType: 'JSON',
                success: function(result){
                     console.log(result);
            }});
        });

      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });

</script>
@endsection