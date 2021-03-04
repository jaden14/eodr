@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-9">
                <div class="card">
                  <div class="card-body">
                  	<div class="mb-3">
                  		<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    	</span>
                  	</div>
                    <br>
                    <div class="row ">
                        <div class="col-md-4">
                            <form action="{{ route('searchs') }}" method="GET" role="search">
                                <div class="form-group">    
                                    <div class="input-group-prepend">
                                 
                                        <input type="date" class="form-control"  name="search" >
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button> 
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div> 
                   <div class="comments">
                      @forelse($accomplishment as $accomp)
                            <div class="comment-box">
                              <span class="commenter-time text-muted">
                                <p>{{ $accomp->natur_accomp }}&nbsp;&nbsp;
                            
                                <span class="comment-time text-muted"> Posted on {{ $accomp->date }}</span>
                                &nbsp;&nbsp;
                                @if(auth::user()->user_type == 'administrator')
                                {{ $accomp->user->cats }}
                                @endif
                                <span style="float: right;">
                                  
                                    <button data-id="{{ $accomp->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>
                                    <button data-id="{{ $accomp->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>
                                </span>
                              </p>
                              </span> 
                                  
                              <p class="comment-txt more"><b style="font-size: 12px; font-family: serif;">Accomplishment <br>
                              </b>{{ $accomp->accomplishment }}
                            </p>
                            </div>
                      @empty
                        <div class="comment-box">
                        <p>No Record.</p>
                        </div>
                      @endforelse 
                        
                    </div>
                  </div>
                   {{ $accomplishment->appends(request()->except('page'))->links() }}
                </div>
                
        </div>
    </div>
</div>

<!--Add-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">add accomplishment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  @if($user->division == null)
                  <div class="form-group">
                        <label for="division">Division<i style="color: red">*</i></label>
                        <select class="form-control division" autofocus @if($user->division != null)disabled @endif>
                          <option selected="true" disabled>Choose</option>
                          <option value="ADMIN">ADMIN</option>
                          <option value="APRD">APRD</option>
                          <option value="L & D">L & D</option>
                          <option value="PQMRR">PQMRR</option>
                          <option value="PBD">PBD</option>
                          <option value="PESD">PESD</option>
                        </select>
                  </div>
                  @endif
                   <input type="hidden" name="id" value="{{ $user->id }}" readonly class="form-control id" autofocus style="border:none;">
                  <div class="form-group">
                        <label for="date">Date<i style="color: red">*</i></label>
                        <input type="date" value="{{ $date->format('Y-m-d') }}" class="form-control date" autofocus>
                  </div>
            
                  <div class="form-group">
                        <label for="nature_accomp">Nature of Accomplishment<i style="color: red">*</i></label>
                        <select class="form-control natur_accomp" autofocus>
                          <option selected disabled>Choose</option>
                          <option value="ON DUTY">ON DUTY</option>
                          <option value="WORK FROM HOME">WORK FROM HOME</option>
                        </select>
                        
                  </div>
            
                  <div class="form-group">
                        <label for="accomplishment">Accomplishment<i style="color: red">*</i></label>
                        <textarea class="form-control accomplishment" autofocus rows="5"></textarea>

                  </div>
            
                  <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text"placeholder="Your Answer" class="form-control quantity" autofocus>
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

<!--edit-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">add accomplishment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                   <input type="hidden" name="id" readonly class="form-control ids" autofocus style="border:none;">
                  <div class="form-group">
                        <label for="date">Date<i style="color: red">*</i></label>
                        <input type="date"  class="form-control dates" autofocus>
                  </div>
            
                  <div class="form-group">
                        <label for="nature_accomp">Nature of Accomplishment<i style="color: red">*</i></label>
                        <select class="form-control natur_accomps" autofocus>
                          <option selected disabled>Choose</option>
                          <option value="ON DUTY">ON DUTY</option>
                          <option value="WORK FROM HOME">WORK FROM HOME</option>
                        </select>
                        
                  </div>
            
                  <div class="form-group">
                        <label for="accomplishment">Accomplishment<i style="color: red">*</i></label>
                        <textarea class="form-control accomplishments" autofocus rows="5"></textarea>

                  </div>
            
                  <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text"placeholder="Your Answer" class="form-control quantities" autofocus>
                  </div>
            </div>   
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save_edit"><i class="fa fa-edit"></i> update</button>
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
            $.post('{{ route("accomplishment.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        division: $('.division').val(),
                        date: $('.date').val(),
                        natur_accomp: $('.natur_accomp').val(),
                        accomplishment: $('.accomplishment').val(),
                        quantity: $('.quantity').val(),
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

            $.post('/accomplishment/acc_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.dates').val(response.date)
                $('.natur_accomps').val(response.natur_accomp)
                $('.accomplishments').val(response.accomplishment)
                $('.quantities').val(response.quantity)
                $('.ids').val(id)
                
            })

          })
	  })

    $('.save_edit').click(function(){

            $.post('{{ route("accupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('.ids').val(),
                        date: $('.dates').val(),
                        natur_accomp: $('.natur_accomps').val(),
                        accomplishment: $('.accomplishments').val(),
                        quantity: $('.quantities').val(),
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
                        $.post('{{ route("accdelete") }}', {
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