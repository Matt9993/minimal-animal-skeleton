
@extends('layouts.app')
@section('content')
  <div class="container">

    <h3 class="jumbotron">Galéria feltöltése</h3>
<form method="post" action="{{url('form')}}" enctype="multipart/form-data">
  {{csrf_field()}}

    <div class="form-group">
        <label for="title">Cím</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Cím" value="{{ old('title') }}">
    </div>

    <div class="form-group">
        <label for="albumPic">Borítókép</label>
        <input type="file" name="filename[]" class="form-control" id="albumPic">
    </div>

        <label for="pics">Galéria képek</label>
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

        <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>

  </form>        
  </div>


<script type="text/javascript">

    $(document).ready(function() {

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