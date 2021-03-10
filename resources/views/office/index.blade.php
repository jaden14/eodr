@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">List of Offices
                	<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    </span>
                </div>

                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-12">
                            <form action="{{ route('officesearch') }}" method="GET" role="search">
                                <div class="form-group">    
                                    <div class="input-group-prepend">
                                 
                                        <input type="text" class="form-control" placeholder="search..."   name="office_search" >
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
                                <th class="sorting" style="width: 90%; cursor: pointer;">Description</th>
                                <th class="text-center sorting" style="width: 10%; cursor: pointer;">Action</th>
                                </tr>
                            </thead>
                            @forelse($office as $offices)
                            <tbody>
                                <tr>
                                    <td>{{ $offices->name }}</td>
                                   	<td>
                                    <div role="group" class="btn-group">
                                        <button data-id="{{ $offices->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>

                                        <button data-id="{{ $offices->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>

                                    </div>
                                    </td>     
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="2">No records found.</td>
                           	@endforelse
                        </table>
                        	{{ $office->appends(request()->except('page'))->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Office</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                        <label for="cats">Office Name<i style="color: red">*</i></label>
                        <input type="text"placeholder="Office name" class="form-control office" autofocus>
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
                <h5 class="modal-title" id="exampleModalLabel">Office name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                  <div class="form-group">
                        <label for="cats">Office Name<i style="color: red">*</i></label>
                        <input type="text"placeholder="Office Name" class="form-control offices" autofocus >
                        <input type="hidden" name="id" readonly class="form-control id" autofocus style="border:none;">
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
            $.post('{{ route("offices.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        name: $('.office').val(),
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

            $.post('/offices/office_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.id').val(id)
                $('.offices').val(response.name)
            })

          })
	  })

	$('.save_edit').click(function(){

            $.post('{{ route("officeupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('input[name=id').val(),
                        name: $('.offices').val(),
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
                        $.post('{{ route("officedelete") }}', {
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