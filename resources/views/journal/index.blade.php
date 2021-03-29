@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-9">
                <div class="card">
                  <div class="card-body">
                  	<div class="mb-3">
                      <span>Journal</span>
                  		<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    	</span>
                  	</div>
                    <br>
                    <div class="row ">
                        <div class="col-md-4">
                                @if(auth::user()->user_type == 'User' || auth::user()->user_type == null || auth::user()->user_type == 'administrator')
                              <form action="{{ route('searchsss') }}" method="GET" role="search">
                                <div class="form-group">    
                                    <div class="input-group-prepend">
                                 
                                        <input type="date" class="form-control"  name="search" >
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button> 
                                    </div>
                                </div>
                              </form>
                               @endif
                               @if(auth::user()->user_type == 'Supervisor')
                               <form action="{{ route('searchsss') }}" method="GET" role="search">
                                <div class="form-group">    
                                    <div class="input-group-prepend">
                                 
                                    <select name="name" class="form-control btn btn-sm" style="background: transparent; border: 1px solid #CCC;"  onchange='this.form.submit()'>
                                    <option disabled selected>choose</option>
                                    @foreach($users as $use)
                                    <option value="{{ $use->id }}">{{ $use->FLAST }}, {{ $use->FFIRST }}</option>
                                    @endforeach
                                </select> 
                                    </div>
                                </div>
                                @endif
                             </form>
                        </div>      
                    </div> 
                   <div class="comments">
                      @forelse($journal as $journals)
                            <div class="comment-box">
                              <span class="commenter-time text-muted">
                                <p>{{ $journals->user->FLAST }}, {{ $journals->user->FFIRST }}&nbsp;&nbsp;
                            
                                <span class="comment-time text-muted"> Posted on {{ $journals->date }} {{ date("g:i a", strtotime($journals->time)) }}</span>
                                &nbsp;&nbsp;
                                @if(auth::user()->user_type == 'administrator')
                                {{ $journals->user->cats }}
                                @endif
                                <span style="float: right;">
                                  
                                    <button data-id="{{ $journals->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>
                                    <button data-id="{{ $journals->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>
                                </span>
                              </p>
                              </span> 
                                  
                              <p class="comment-txt more"><b style="font-size: 12px; font-family: serif;">Where About: <br>
                              </b>{{ $journals->whereto }}
                            </p>
                            </div>
                      @empty
                        <div class="comment-box">
                        <p>No Record.</p>
                        </div>
                      @endforelse 
                        
                    </div>
                  </div>
                   {{ $journal->appends(request()->except('page'))->links() }}
                </div>
                
        </div>
    </div>
</div>

<!--Add-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">add Where To</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  
                   <input type="hidden" name="id" value="{{ $user->id }}" readonly class="form-control id" autofocus style="border:none;">
                  <div class="form-group">
                        <label for="date">Date<i style="color: red">*</i></label>
                        <input type="date" value="{{ $date->format('Y-m-d') }}" class="form-control date" autofocus>
                  </div>

                  <div class="form-group">
                        <label for="date">Time<i style="color: red">*</i></label>
                        <input type="time" class="form-control time" autofocus>
                  </div>
            
                  <div class="form-group">
                        <label for="accomplishment">Where About<i style="color: red">*</i></label>
                        <textarea class="form-control whereto" autofocus rows="5"></textarea>

                  </div>
            </div>   
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save"><i class="fa fa-save"></i> save</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Edit-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Where To</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  
                   <input type="hidden" name="id" value="{{ $user->id }}" readonly class="form-control ids" autofocus style="border:none;">
                  <div class="form-group">
                        <label for="date">Date<i style="color: red">*</i></label>
                        <input type="date" value="{{ $date->format('Y-m-d') }}" class="form-control dates" autofocus>
                  </div>

                  <div class="form-group">
                        <label for="date">Time<i style="color: red">*</i></label>
                        <input type="time" class="form-control times" autofocus>
                  </div>
            
                  <div class="form-group">
                        <label for="accomplishment">Where About<i style="color: red">*</i></label>
                        <textarea class="form-control wheretos" autofocus rows="5"></textarea>

                  </div>
            </div>   
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save_edit"><i class="fa fa-edit"></i> Update</button>
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

        $('.save').click(function() {
            $.post('{{ route("journal.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        date: $('.date').val(),
                        time: $('.time').val(),
                        whereto: $('.whereto').val(),
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

            $.post('/journal/journal_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.dates').val(response.date)
                $('.times').val(response.time)
                $('.wheretos').val(response.whereto)
                $('.ids').val(id)
                
            })

          })
    })

    $('.save_edit').click(function(){

            $.post('{{ route("journalupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('.ids').val(),
                        date: $('.dates').val(),
                        time: $('.times').val(),
                        whereto: $('.wheretos').val(),
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
                        $.post('{{ route("journaldelete") }}', {
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