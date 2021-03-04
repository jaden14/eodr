@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">List of Employees
                	<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    </span>
                </div>

                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-12">
                            <form action="{{ route('search')}}" method="GET" role="search">
                                <div class="form-group">    
                                    <div class="input-group-prepend">
                                 
                                        <input type="text" class="form-control" placeholder="search..."   name="search" >
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button> 
                                    </div>
                                </div>
                            </form>
                        </div>      
                    </div> 

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Cats No.</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Last Name</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">First Name</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Middle Name</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Division</th>
                                <th class="text-center sorting" style="width: 10%; cursor: pointer;">Action</th>
                                </tr>
                            </thead>
                            @forelse($user as $users)
                            <tbody>
                                <tr>
                                    <td>{{ $users->cats }}</td>
                                    <td>{{ $users->FLAST }}</td>
                                    <td>{{ $users->FFIRST }}</td>
                                    <td>{{ $users->FMI }}</td>
                                    <td>{{ $users->division }}</td>
                                   	<td>
                                    <div role="group" class="btn-group">
                                        <button data-id="{{ $users->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>

                                        <button data-id="{{ $users->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>

                                    </div>
                                    </td>     
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="6">No records found.</td>
                           	@endforelse
                        </table>
                        	{{ $user->appends(request()->except('page'))->links() }}
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                        <label for="cats">Cats Number<i style="color: red">*</i></label>
                        <input type="text"placeholder="Cats Number" class="form-control cats" autofocus oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                  </div>
            
                  <div class="form-group">
                        <label for="FLAST">Last Name<i style="color: red">*</i></label>
                        <input type="text"placeholder="Last Name" class="form-control lname" autofocus>
                  </div>
           
                  <div class="form-group">
                        <label for="FFIRST">First Fame<i style="color: red">*</i></label>
                        <input type="text"placeholder="First Name" class="form-control fname" autofocus>
                  </div>
            
            
                  <div class="form-group">
                        <label for="FMI">Middle Name<i style="color: red">*</i></label>
                        <input type="text"placeholder="Middle Name" class="form-control mname" autofocus>
                  </div>
            
                  <div class="form-group">
                        <label for="producers_id">Division<i style="color: red">*</i></label>
                        <select class="form-control division" autofocus>
                        	<option selected="true" disabled>Choose</option>
                        	<option value="ADMIN">ADMIN</option>
                        	<option value="APRD">APRD</option>
                        	<option value="L & D">L & D</option>
                        	<option value="PQMRR">PQMRR</option>
                        	<option value="PBD">PBD</option>
                        	<option value="PESD">PESD</option>
                        </select>
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

<!--Add-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                  <div class="form-group">
                        <label for="cats">Cats Number<i style="color: red">*</i></label>
                        <input type="text"placeholder="Cats Number" class="form-control catss" autofocus oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        <input type="hidden" name="id" readonly class="form-control id" autofocus style="border:none;">
                  </div>
            
                  <div class="form-group">
                        <label for="FLAST">Last Name<i style="color: red">*</i></label>
                        <input type="text"placeholder="Last Name" class="form-control llname" autofocus>
                  </div>
           
                  <div class="form-group">
                        <label for="FFIRST">First Fame<i style="color: red">*</i></label>
                        <input type="text"placeholder="First Name" class="form-control ffname" autofocus>
                  </div>
            
            
                  <div class="form-group">
                        <label for="FMI">Middle Name<i style="color: red">*</i></label>
                        <input type="text"placeholder="Middle Name" class="form-control mmname" autofocus>
                  </div>
            
                  <div class="form-group">
                        <label for="producers_id">Division<i style="color: red">*</i></label>
                        <select class="form-control ddivision" autofocus>
                        	<option selected="true" disabled>Choose</option>
                        	<option value="ADMIN">ADMIN</option>
                        	<option value="APRD">APRD</option>
                        	<option value="L & D">L & D</option>
                        	<option value="PQMRR">PQMRR</option>
                        	<option value="PBD">PBD</option>
                        	<option value="PESD">PESD</option>
                        </select>
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
            $.post('{{ route("employees.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        cats: $('.cats').val(),
                        FLAST: $('.lname').val(),
                        FFIRST: $('.fname').val(),
                        FMI: $('.mname').val(),
                        division: $('.division').val(),
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

            $.post('/employees/user_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.id').val(id)
                $('.catss').val(response.cats)
                $('.llname').val(response.FLAST)
                $('.ffname').val(response.FFIRST)
                $('.mmname').val(response.FMI)
                $('.ddivision').val(response.division)
            })

          })
	  })

	$('.save_edit').click(function(){

            $.post('{{ route("userupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('input[name=id').val(),
                        cats: $('.catss').val(),
                        FLAST: $('.llname').val(),
                        FFIRST: $('.ffname').val(),
                        FMI: $('.mmname').val(),
                        division: $('.ddivision').val(),
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
                        $.post('{{ route("userdelete") }}', {
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