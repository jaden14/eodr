@extends('layouts.supervisor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-9">
                <div class="card">
                  <div class="card-body">
                  	<div class="mb-3">
                      <span>Meetings</span>
                      @if(auth::user()->role == 'Secretariat')
                  		<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    	</span>
                      @endif
                  	</div>
                     
                    <div class="comments">
                      @forelse($committe as $committes)
                            <div class="comment-box">
                              <span class="commenter-time text-muted">
                                <p>EXECUTIVE ORDER NO.&nbsp;&nbsp;<i style="text-decoration: underline; ">{{ $committes->eo_number }}</i> &nbsp;&nbsp;
                                <span class="comment-time text-muted">Posted on {{ date('d-m-Y', strtotime($committes->created_at)) }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($committes->meeting->status == 'Done')<i style="color: green;">DONE</i> @endif</span>
                                &nbsp;&nbsp;
                                
                                @if(auth::user()->id == $committes->meeting->user_id)
                                <span style="float: right;">
                                    <button data-id="{{ $committes->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>
                                    <button data-id="{{ $committes->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>
                                </span>
                                @endif
                              </p>
                              </span> 
                              <p>Date and Time:<b> {{ date('F d, Y', strtotime($committes->meeting->date)) }} {{ date('h:i a', strtotime($committes->meeting->time)) }}</b></p>
                              <p>Venue: <b>{{ $committes->meeting->venue }}</b></p>
                              <p class="comment-txt more"><b style="font-size: 12px; font-family: serif;">{!! $committes->name !!}
                              </b>
                              <br>
                              <p style="font-size: 12px;">{!! $committes->meeting->particular !!}</p>
                              <br>
                              <p><b>Members:</b>
                                @foreach($committes->member as $members)
                                  <table class="table table-sm">
                                    <tbody>
                                     <tr>
                                       <td class="text-left sorting" style="width: 50%; font-size: 12px;"><b>{{ $members->user['FFIRST'] }} {{ $members->user['FMI'] }} {{ $members->user['FLAST'] }}</td>
                                       <td style="width: 50%; font-size: 12px;">- {{ $members->user['FPOSITION'] }}, {{ $members->user['office']['name'] }}</td>

                                       @if(auth::user()->id == $committes->meeting->user_id)
                                       <td><button data-id="{{ $members->user_id }}" class="btn btn-link text-danger btn-sm btn_deleted"><span class="fa fa-trash"></span></button></td>
                                       @endif
                                     </tr>
                                    <tbody>
                                  </table>
                                 
                                @endforeach
                              </p>
                            </p>
                            </div>
                        @empty
                        <div class="comment-box">
                        <p>No Record.</p>
                        </div>
                        @endforelse 
                        
                    </div>
                  
                  </div>
                      {{ $committe->appends(request()->except('page'))->links() }}
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

<!--Edit-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">meetings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="error"></span>
              <form method="post" action="#" id="upload_forms" role="form" enctype="multipart/form-data">
                @csrf
                  <div class="form-group row">
                    <div class="col-md-6">
                        <label for="name">Committee Name<i style="color: red">*</i></label>
                        <textarea class="form-control names" rows="5" name="name" autofocus></textarea>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="eo_number">EO Number<i style="color: red">*</i></label>
                        <input type="text" placeholder="EO Number" class="form-control eo_numbers" name="eo_number" autofocus>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label for="date">Date<i style="color: red">*</i></label>
                          <input type="date" class="form-control dates" name="date" autofocus>
                        </div>
                        <div class="col-md-6">
                          <label for="time">Time<i style="color: red">*</i></label>
                          <input type="time" class="form-control times" name="time" autofocus>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="venue">Venue<i style="color: red">*</i></label>
                      <input type="text" class="form-control venues" name="venue" autofocus>
                  </div>
                  <div class="form-group">
                      <label for="particulars">Particulars<i style="color: red">*</i></label>
                      <textarea class="form-control particular" rows="10" name="particulars" autofocus></textarea>
                  </div>
                  <div class="form-group">
                      <label for="members">Add Members</label>
                      <select class="form-control members" id="members" multiple data-live-search="true"  name="user_id[]">
                        @foreach($user as $users)
                        <option value="{{ $users->id }}">{{ $users->FLAST }}, {{ $users->FFIRST }} ({{ $users->cats }})</option>
                        @endforeach
                      </select>
                  </div>

                  <div class="form-group">
                      <label for="status">Status</label>
                      <select class="form-control status" id="status"  name="status">
                        <option value="Pending">Pending</option>
                        <option value="Done">Done</option>
                        
                      </select>
                  </div>

                    <input type="hidden" class="form-control id" name="id">
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

              setTimeout(function () {
                $("#errors").fadeTo(2000, 500).slideUp(500, function () {
                    $("#errors").remove();
                });
              }, 5000);//5000=5 seconds
          });

                
      }
    });
    });
})

  $(document).on('click', '.btn_edit', function() {
            var id = $(this).data('id')
            console.log(id);
            $('#editModal').modal('show');

            $.post('/committe/committe_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.names').val(response.name)
                $('.eo_numbers').val(response.eo_number)
                $('.dates').val(response.meeting.date)
                $('.times').val(response.meeting.time)
                $('.venues').val(response.meeting.venue)
                $('.particular').val(response.meeting.particular)
                $('.status').val(response.meeting.status)
                $('.id').val(id)
            })

          })

  $(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $('#upload_forms').submit(function(e) {
        e.preventDefault();
      var formData = new FormData(this);

    $.ajax({
      type:'POST',
      url: "{{ route('committeupdate')}}",
      data: formData,
      cache:false,
      contentType: false,
      processData: false,
      success: (data) => {
      $.notify("Done", "success");
      setTimeout( function()
                        {
                            location.reload();
                        }, 500);
        },
      error: function(response){
       $.each(response.responseJSON.errors, function (key, item) 
          {
            $("#error").append("<li class='alert alert-danger'>"+item+"</li>")

              setTimeout(function () {
                $("#error").fadeTo(2000, 500).slideUp(500, function () {
                    $("#error").remove();
                });
              }, 5000);//5000=5 seconds
          });
      }
    });
    });

})

   $(document).on('click', '.btn_delete', function() {
            var id = $(this).data('id')

            Swal.fire({
                title: 'Are you sure?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    $('input[name=id').val(id)
                        $.post('{{ route("committedelete") }}', {
                        "_token": "{{ csrf_token() }}",
                    id: id
                    })
                    .done(function (response) {})
                    setTimeout( function()
                        {
                            location.reload();
                        }, 2000)
                    Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success',
                    
                    )
                }
            })

        })

   $(document).on('click', '.btn_deleted', function() {
            var id = $(this).data('id')

            Swal.fire({
                title: 'Are you sure?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    $('input[name=id').val(id)
                        $.post('{{ route("memberdelete") }}', {
                        "_token": "{{ csrf_token() }}",
                    id: id
                    })
                    .done(function (response) {})
                    setTimeout( function()
                        {
                            location.reload();
                        }, 2000)
                    Swal.fire(
                    'Deleted!',
                    'Member has been deleted.',
                    'success',
                    
                    )
                }
            })

        })
</script>
@endsection