@extends('layouts.supervisor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-9">
                <div class="card">
                  <div class="card-body">
                  	<div class="mb-3">
                      @if(auth::user()->role == 'Secretariat')
                  		<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    	</span>
                      @endif
                  	</div>
                  
                  </div>
                   
                </div>
                
        </div>
    </div>
</div>

<!--Add-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">meetings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="errors"></span>
              <form method="post" action="#" id="upload_form" role="form" enctype="multipart/form-data">
                @csrf
                  <div class="form-group row">
                    <div class="col-md-6">
                        <label for="name">Committee Name<i style="color: red">*</i></label>
                        <textarea class="form-control name" rows="5" name="name" autofocus></textarea>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="eo_number">EO Number<i style="color: red">*</i></label>
                        <input type="text" placeholder="EO Number" class="form-control eo_number" name="eo_number" autofocus>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label for="date">Date<i style="color: red">*</i></label>
                          <input type="date" class="form-control date" name="date" autofocus>
                        </div>
                        <div class="col-md-6">
                          <label for="time">Time<i style="color: red">*</i></label>
                          <input type="time" class="form-control time" name="time" autofocus>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="venue">Venue<i style="color: red">*</i></label>
                      <input type="text" class="form-control venue" name="venue" autofocus>
                  </div>
                  <div class="form-group">
                      <label for="particulars">Particulars<i style="color: red">*</i></label>
                      <textarea class="form-control particulars" rows="10" name="particulars" autofocus></textarea>
                  </div>
                  <div class="form-group">
                      <label for="members">Members<i style="color: red">*</i></label>
                      <select class="form-control selectpicker" multiple data-live-search="true"  name="user_id[]">
                        @foreach($user as $users)
                        <option value="{{ $users->id }}">{{ $users->FLAST }}, {{ $users->FFIRST }} ({{ $users->cats }})</option>
                        @endforeach
                      </select>
                  </div>
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                             <button type="submit" id="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div> 

@endsection
@section('scripts')
<script>
  $(function () {
        $('.add').click(function(){
            $('#myModal').modal('show')
        })
    })
  
  $(document).ready(function() {
        $('select').selectpicker();
    });

  $(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $('#upload_form').submit(function(e) {
        e.preventDefault();
      var formData = new FormData(this);

    $.ajax({
      type:'POST',
      url: "{{ route('committe.store')}}",
      data: formData,
      cache:false,
      contentType: false,
      processData: false,
      success: (data) => {
      $.notify("Done", "success");
      setTimeout( function()
                        {
                            location.reload();
                        }, 1000);
        },
      error: function(response){
        $.each(response.responseJSON.errors, function (key, item) 
          {
            $("#errors").append("<li class='alert alert-danger'>"+item+"</li>")
          });

                
      }
    });
    });
})
</script>
@endsection