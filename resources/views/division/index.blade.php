@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">List of Division 
                	<span style="float: right;">
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                    </span>
                </div>

                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-12">
                            <form action="{{ route('divisionsearch') }}" method="GET" role="search">
                                <div class="form-group">    
                                    <div class="input-group-prepend">
                                 
                                        <input type="text" class="form-control" placeholder="search..."   name="division_search" >
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
                                <th class="sorting" style="width: 45%; cursor: pointer;">Division</th>
                                <th class="sorting" style="width: 45%; cursor: pointer;">Office</th>
                                <th class="text-center sorting" style="width: 10%; cursor: pointer;">Action</th>
                                </tr>
                            </thead>
                            @forelse($division as $divisions)
                            <tbody>
                                <tr>
                                    <td>{{ $divisions->name }}</td>
                                    <td>{{ $divisions->office->name }}</td>
                                   	<td>
                                    <div role="group" class="btn-group">
                                        <button data-id="{{ $divisions->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>

                                        <button data-id="{{ $divisions->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>

                                    </div>
                                    </td>     
                                </tr>
                            </tbody>
                            @empty
                                <td colspan="3">No records found.</td>
                           	@endforelse
                        </table>
                        	{{ $division->appends(request()->except('page'))->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Division</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                        <label for="cats">Office Name<i style="color: red">*</i></label>
                        <select class="form-control office" autofocus>
                            <option selected disabled>choose</option>
                            @foreach($office as $offices)
                            <option value="{{ $offices->id }}">{{ $offices->name }}</option>
                            @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                        <label for="cats">Division/Section<i style="color: red">*</i></label>
                        <input type="text"placeholder="Divsion / Section" class="form-control division" autofocus >
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
                        <select class="form-control offices" autofocus>
                            <option selected disabled>choose</option>
                            @foreach($office as $offices)
                            <option value="{{ $offices->id }}">{{ $offices->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id" readonly class="form-control id" autofocus style="border:none;">
                  </div>
                  <div class="form-group">
                        <label for="cats">Division/Section<i style="color: red">*</i></label>
                        <input type="text"placeholder="Divsion / Section" class="form-control divisions" autofocus >
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
            $.post('{{ route("division.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        office_id: $('.office').val(),
                        name: $('.division').val(),
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

            $.post('/division/division_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.id').val(id)
                $('.offices').val(response.office_id)
                $('.divisions').val(response.name)
            })

          })
	  })

	$('.save_edit').click(function(){

            $.post('{{ route("divisionupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('input[name=id').val(),
                        office_id: $('.offices').val(),
                        name: $('.divisions').val(),
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
                        $.post('{{ route("divisiondelete") }}', {
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