@extends('layouts.supervisor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-8">
                <div class="card">
                  <div class="card-body">
                  	<div class="mb-3">
                      <span>Committees</span>
                      @if(auth::user()->role == 'Secretariat')
                  		<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add_committees"><i class="fa fa-plus-circle"></i> add</button> 
                    	</span>
                      @endif
                  	</div>
                     
                    <div class="comments">
                      @forelse($committe as $committes)
                            <div class="comment-box">
                              <span class="commenter-time text-muted">
                                <p>EXECUTIVE ORDER NO.&nbsp;&nbsp;<i style="text-decoration: underline; ">{{ $committes->eo_number }}</i> &nbsp;&nbsp;
                                <span class="comment-time text-muted"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                                &nbsp;&nbsp;
                                
                                @if(auth::user()->role == 'Secretariat')
                                <span style="float: right;">
                                    <button data-id="{{ $committes->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>
                                    <button data-id="{{ $committes->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>
                                </span>
                                @endif
                              </p>
                              </span> 
                              
                              <p class="comment-txt more"><b style="font-size: 12px; font-family: serif;">{!! $committes->name !!}
                              </b>

                              <br>
                              <p><b>Chairperson:</b>
                                @foreach($committes->member as $members)
                                  @if($members->committee_id == $committes->id && $members->position =='Chairperson')
                                  <table class="table table-sm">
                                    <tbody>
                                     <tr>
                                       <td class="text-left sorting" style="width: 50%; font-size: 12px;">{{ $members->user->FFIRST }} {{ $members->user->FMI }} {{ $members->user->FLAST }}<b>
                                       <td><button data-id="{{ $members->id }}" class="btn btn-link text-primary btn-sm btn_edit_chair" style="float: right;"><span class="fa fa-edit"></span></button></td> 
  
                                     </tr>
                                    <tbody>
                                  </table>
                                  @endif
                                @endforeach
                              </p>
                              
                              <p><b>Co-Chair:</b>
                                @foreach($committes->member as $members)
                                  @if($members->committee_id == $committes->id && $members->position =='Co-Chair')
                                  <table class="table table-sm">
                                    <tbody>
                                     <tr>
                                       <td class="text-left sorting" style="width: 50%; font-size: 12px;">{{ $members->user->FFIRST }} {{ $members->user->FMI }} {{ $members->user->FLAST }}<b>
                                       <td><button data-id="{{ $members->id }}" class="btn btn-link text-primary btn-sm btn_edit_chair" style="float: right;"><span class="fa fa-edit"></span></button></td> 
  
                                     </tr>
                                    <tbody>
                                  </table>
                                  @endif
                                @endforeach
                              </p>
                              <p><b>Member:</b>
                                @foreach($committes->member as $members)
                                  @if($members->committee_id == $committes->id && $members->position =='Member')
                                  <table class="table table-sm">
                                    <tbody>
                                     <tr>
                                       <td class="text-left sorting" style="width: 50%; font-size: 12px;">{{ $members->user->FFIRST }} {{ $members->user->FMI }} {{ $members->user->FLAST }}<b> 
                                       <td><button data-id="{{ $members->id }}" class="btn btn-link text-danger btn-sm btn_deleted" style="float: right;"><span class="fa fa-trash"></span></button></td>
                                     </tr>
                                    <tbody>
                                  </table>
                                  @endif
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

<!--Add Committees-->
<div class="modal fade" id="myModalcommittees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <form method="post" action="#" id="upload_committees" role="form" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                        <label for="eo_number">EO Number<i style="color: red">*</i></label>
                        <input type="text" placeholder="EO Number" class="form-control eo_number" name="eo_number" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="name">Committee Name<i style="color: red">*</i></label>
                        <textarea class="form-control name" rows="5" name="name" autofocus></textarea>
                  </div>
                  <div class="form-group">
                      <label for="chairperson">Chairperson<i style="color: red">*</i></label>
                      <select class="form-control selectpicker" data-live-search="true"  name="chairperson">
                        <option></option>
                        @foreach($user as $users)
                        <option value="{{ $users->id }}">{{ $users->FLAST }}, {{ $users->FFIRST }} ({{ $users->cats }})</option>
                        @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="co-chair">Co-Chair<i style="color: red">*</i></label>
                      <select class="form-control selectpicker" data-live-search="true"  name="cochair">
                        <option></option>
                        @foreach($user as $users)
                        <option value="{{ $users->id }}">{{ $users->FLAST }}, {{ $users->FFIRST }} ({{ $users->cats }})</option>
                        @endforeach
                      </select>
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
                             <button type="submit" id="submit" class="btn btn-primary mr-2 btn-sm">Submit</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Committee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="error"></span>
              <form method="post" action="#" id="upload_forms" role="form" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                        <label for="eo_number">EO Number<i style="color: red">*</i></label>
                        <input type="text" placeholder="EO Number" class="form-control eo_numbers" name="eo_number" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="name">Committee Name<i style="color: red">*</i></label>
                        <textarea class="form-control names" rows="5" name="name" autofocus></textarea>
                  </div>  
                  <div class="form-group">
                      <label for="members">Add Members</label>
                      <select class="form-control members" id="members" multiple data-live-search="true"  name="user_id[]">
                        @foreach($user as $users)
                        <option value="{{ $users->id }}">{{ $users->FLAST }}, {{ $users->FFIRST }} ({{ $users->cats }})</option>
                        @endforeach
                      </select>
                  </div>

                    <input type="hidden" class="form-control id" name="id">
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                             <button type="submit" id="submit" class="btn btn-primary mr-2 btn-sm">Submit</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div> 

<!--Edit Chairperson-->
<div class="modal fade" id="editchairperson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chairperson / Co-Chair</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="error"></span>
              <form method="post" action="#" id="upload_chair" role="form" enctype="multipart/form-data">
                @csrf 
                  <div class="form-group">
                      <label for="members">Update Chairperson / Co-Chair</label>
                      <select class="form-control selectpicker chairpersons" id="members" data-live-search="true" name="user_id">
                        <option></option>
                        @foreach($user as $users)
                        <option value="{{ $users->id }}">{{ $users->FLAST }}, {{ $users->FFIRST }} ({{ $users->cats }})</option>
                        @endforeach
                      </select>
                  </div>

                    <input type="hidden" class="form-control id" name="id">
            </div>  
            <div class="modal-footer">
                  <span class="text-warning"> 
                             <button type="submit" id="submit" class="btn btn-primary mr-2 btn-sm">Submit</button>
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
        $('.add_committees').click(function(){
            $('#myModalcommittees').modal('show')
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
    $('#upload_committees').submit(function(e) {
        e.preventDefault();
      var formData = new FormData(this);

    $.ajax({
      type:'POST',
      url: "{{ route('committeadd')}}",
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
            $("#errorss").append("<li class='alert alert-danger'>"+item+"</li>")

              setTimeout(function () {
                $("#errorss").fadeTo(2000, 500).slideUp(500, function () {
                    $("#errorss").remove();
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
                $('.id').val(id)
            })

          })

  $(document).on('click', '.btn_edit_chair', function() {
            var id = $(this).data('id')
            console.log(id);
            $('#editchairperson').modal('show');

            $.post('/committe/committe_editperson', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.chairpersons').val(response.user_id)
                $('.id').val(id)
            })

          })

  $(document).ready(function (e) {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $('#upload_chair').submit(function(e) {
        e.preventDefault();
      var formData = new FormData(this);

    $.ajax({
      type:'POST',
      url: "{{ route('committeupdateperson')}}",
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