@extends('layouts.app')
@section('content')
<!-- Post Section -->
<div class="container">
    <div class="row">
        <h3 class="jumbotron">Szerkesztés</h3>

            <div class="form-group">
                <label for="title">Cím</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Cím" value="{{ $title }}">
            </div>
            <label for="div1">Borító kép</label>
            <div id="div1" name="mainPic" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            <br>
            <label for="div2">Galéria képek</label>
            <div id="div2" name="file[]" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            <br>
        
            @foreach ($album as $pics)
                <img name="images" id="{{ $pics }}" src="{{ URL::asset($path . '/' . $pics) }}" draggable="true" ondragstart="drag(event)" width="336" height="69">
            @endforeach    
            <br>
            <button id='saveImages'  class="btn btn-primary save" style="margin-top:10px">Submit</button>      
        </form><br>  

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
        
        <br>
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
            let title = jQuery('#title').val();
            let mainPic = jQuery('#div1').children()[0].id;
            let albumPics = jQuery('#div2').children();
            let files = [];
            for (let i = 0; i < albumPics.length; i++){
                files.push(albumPics[i].id);
            } 
            jQuery.ajax({
                url: "{{ url ('/edit-album') }}",
                method: 'post',
                data: {
                    title: title,
                    main: mainPic,
                    files: files,
                },
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