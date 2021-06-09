@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-8">
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
                      @forelse($meeting as $meetings)
                            <div class="comment-box">
                              <span class="commenter-time text-muted">
                                <p>Date:&nbsp;&nbsp;<i style="text-decoration: underline; ">{{ date('F d, Y', strtotime($meetings->date)) }} {{ date('h:i a', strtotime($meetings->time)) }} </i> &nbsp;&nbsp;
                                
                                
                                @if(auth::user()->role == 'Secretariat')
                                <span style="float: right;">
                                    <button data-id="{{ $meetings->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>
                                    <button data-id="{{ $meetings->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>
                                </span>
                                @endif
                              </p>
                              </span> 
                              <span class="commenter-time text-muted">
                              	<p>Venue: <i style="text-decoration: underline;">{{ $meetings->venue }}</i></p>
                              </span>
                              
                              <p class="comment-txt more"><b style="font-size: 12px; font-family: serif;">{!! $meetings->committee->name !!}
                              </b>
                                
                              </p>
                              <p class="comment-txt more"><b style="font-size: 12px; font-family: serif;">{!! $meetings->particular !!}
                              </b> 
                              </p>
                              <span class="commenter-time text-muted">
                              	<p> Status: <b style="color: blue;">{{ $meetings->status }}</b></p>
                              </span>
                            </div>
                        @empty
                        <div class="comment-box">
                        <p>No Record.</p>
                        </div>
                        @endforelse 
                        
                    </div>
                  
                  </div>
                      {{ $meeting->appends(request()->except('page'))->links() }}
                </div>
                
        </div>
    </div>
</div>

<!--Add-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Committees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="errorss"></span>
              <form method="post" action="#" id="upload_meeting" role="form" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                     <label for="committee">Committee Name<i style="color: red">*</i></label>
                     <select class="form-control committee_name"  name="committee_id">
                        <option></option>
                        @foreach($committee as $committees)
                        <option value="{{ $committees->id }}">{{ $committees->name }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group row">
                  	<div class="col-md-6">
                  		<label for="date">Date<i style="color: red">*</i></label>
                  		<input type="date" name="date" class="form-control date" autofocus>
                  	</div>
                  	<div class="col-md-6">
                  		<label for="time">Time<i style="color: red">*</i></label>
                  		<input type="time" name="time" class="form-control time" autofocus>
                  	</div>
                  </div>
                  <div class="form-group">
                  	<label for="venue">Venue<i style="color: red">*</i></label>
                  	<input type="text" name="venue" class="form-control venue" autofocus>
                  </div>
                  <div class="form-group">
                  	<label for="particular">Particular<i style="color: red">*</i></label>
                  	<textarea name="particular" class="form-control particular" rows="5" autofocus></textarea>
                  </div>
                  <div class="form-group">
                     <label for="status">Status<i style="color: red">*</i></label>
                     <select class="form-control status"  name="status">
                        <option selected disabled>choose</option>                       
                        <option value="Pending">Pending</option>
                        <option value="On Process">On Process</option>
                        <option value="Done">Done</option>
                      </select>
                  </div>
                  <div class="form-group"> 
                  	<input type="hidden" name="user_id" value="{{ auth::user()->id }}" class="form-control user_id">
                  </div>
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                             <button type="submit" id="submit" class="btn btn-primary mr-2 btn-sm save">Submit</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Committees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="errorss"></span>
              <form method="post" action="#" id="upload_meeting" role="form" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                     <label for="committee">Committee Name<i style="color: red">*</i></label>
                     <select class="form-control committee_names"  name="committee_id">
                        <option></option>
                        @foreach($committee as $committees)
                        <option value="{{ $committees->id }}">{{ $committees->name }}</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group row">
                  	<div class="col-md-6">
                  		<label for="date">Date<i style="color: red">*</i></label>
                  		<input type="date" name="date" class="form-control dates" autofocus>
                  	</div>
                  	<div class="col-md-6">
                  		<label for="time">Time<i style="color: red">*</i></label>
                  		<input type="time" name="time" class="form-control times" autofocus>
                  	</div>
                  </div>
                  <div class="form-group">
                  	<label for="venue">Venue<i style="color: red">*</i></label>
                  	<input type="text" name="venue" class="form-control venues" autofocus>
                  </div>
                  <div class="form-group">
                  	<label for="particular">Particular<i style="color: red">*</i></label>
                  	<textarea name="particular" class="form-control particulars" rows="5" autofocus></textarea>
                  </div>
                  <div class="form-group">
                     <label for="status">Status<i style="color: red">*</i></label>
                     <select class="form-control statuss"  name="status">
                        <option selected disabled>choose</option>                       
                        <option value="Pending">Pending</option>
                        <option value="On Process">On Process</option>
                        <option value="Done">Done</option>
                      </select>
                  </div>
                  <div class="form-group"> 
                  	<input type="hidden" name="user_id" value="{{ auth::user()->id }}" class="form-control user_ids">
                  	<input type="hidden" name="id"  class="form-control ids">
                  </div>
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                             <button type="submit" id="submit" class="btn btn-primary mr-2 btn-sm save_edit">Submit</button>
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
$('.save').click(function() {
            $.post('{{ route("meeting.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        committee_name: $('.committee_name').val(),
                        date: $('.date').val(),
                        time: $('.time').val(),
                        venue: $('.venue').val(),
                        particular: $('.particular').val(),
                        status: $('.status').val(),
                        user_id: $('.user_id').val(),
                        id: $('.id').val(),
                    })
                    .done(function (response) {
                        $.notify("Done", "success");
                        $('#myModal').modal('hide')
                        setTimeout( function()
                        {
                            location.reload();
                        }, 500);
                }).fail(function (response) {
                    var errors = _.map(response.responseJSON.errors)
                        $.notify(errors[0], "error");
                });
        })

$(document).on('click', '.btn_edit', function() {
            var id = $(this).data('id')
            console.log(id);
            $('#editModal').modal('show');

            $.post('/meeting/meeting_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.dates').val(response.date)
                $('.times').val(response.time)
                $('.venues').val(response.venue)
                $('.particulars').val(response.particular)
                $('.statuss').val(response.status)
                $('.committee_names').val(response.committee_id)
                $('.ids').val(id)
                
            })

})

$('.save_edit').click(function(){

            $.post('{{ route("meetingupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        committee_name: $('.committee_names').val(),
                        id: $('.ids').val(),
                        date: $('.dates').val(),
                        time: $('.times').val(),
                        venue: $('.venues').val(),
                        particular: $('.particulars').val(),
                        status: $('.statuss').val(),
                    })
                    .done(function (response) {
                        $('#editModal').modal('hide');
                        $.notify("Update Success", "success");
                        setTimeout( function()
                        {
                            location.reload();
                        }, 500);
                        
                    }).fail(function (response) {
                    var errors = _.map(response.responseJSON.errors)
                        $.notify(errors[0], "error");
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
                        $.post('{{ route("meetingdelete") }}', {
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
</script>
@endsection