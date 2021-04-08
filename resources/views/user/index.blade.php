@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">List of Employees
                	<span style="float: right;">
                        @if(auth::user()->user_type =='administrator')
                       	<button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button>
                        @endif 
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
                                <th class="sorting" style="width: 10%; cursor: pointer;">Middle Name</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Office</th>
                                <th class="sorting" style="width: 20%; cursor: pointer;">Division</th>
                                @if(auth::user()->user_type =='administrator')
                                <th class="text-center sorting" style="width: 10%; cursor: pointer;">Action</th>
                                @endif
                                </tr>
                            </thead>
                            @forelse($user as $users)
                            <tbody>
                                <tr>
                                    <td>{{ $users->cats }}</td>
                                    <td>{{ $users->FLAST }}</td>
                                    <td>{{ $users->FFIRST }}</td>
                                    <td>{{ $users->FMI }}</td>
                                    <td>{{ $users->office['name'] }}</td>
                                    <td>{{ $users->division['name'] }}</td>
                                    @if(auth::user()->user_type =='administrator')
                                   	<td>
                                    <div role="group" class="btn-group">
                                        <button data-id="{{ $users->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>

                                        <button data-id="{{ $users->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>

                                    </div>
                                    </td>
                                     @endif 
                                </tr>
                            </tbody>
                           	@empty
                                <td colspan="7">No records found.</td>
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
                        <label for="email">Email Address</label>
                        <input type="email"placeholder="Email Address" class="form-control email" autofocus>
                  </div>

                  <div class="form-group">
                        <label for="phone_no">Phone Number</label>
                        <input type="text"placeholder="Phone Number" class="form-control phone_no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
                  </div>

                  <div class="form-group">
                        <label for="cats">Office Name<i style="color: red">*</i></label>
                        <select class="form-control office" autofocus>
                            <option selected disabled>choose</option>
                            @foreach($office as $offices)
                            <option value="{{ $offices->id }}">{{ $offices->name }}</option>
                            @endforeach
                        </select>
                        
                        <br>

                        <label for="producers_id">Division<i style="color: red">*</i></label>
                        <select id="division" class="form-control division" autofocus data-selected-division="{{ old('division') }}">
                        	
                        </select>
                  </div>

                  <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text"placeholder="role" class="form-control role" autofocus>
                  </div>

                  <div class="form-group">
                        <label for="user_type">User Type<i style="color: red">*</i></label>
                        <select class="form-control user_type" autofocus>
                            <option selected disabled>choose</option>
                            <option value="Supervisor">SUPERVISOR</option>
                            <option value="User">User</option>
                        </select>
                  </div>

                  <div class="form-group">
                        <label for="password">Password(defualt 12345678)<i style="color: red">*</i></label>
                        <input type="password" placeholder="Password" value="12345678" class="form-control password" autofocus>
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
                        <label for="email">Email Address</label>
                        <input type="email"placeholder="Email Address" class="form-control emails" autofocus>
                  </div>

                  <div class="form-group">
                        <label for="phone_no">Phone Number</label>
                        <input type="text"placeholder="Phone Number" class="form-control phone_nos" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
                  </div>
            
                  <div class="form-group">
                        <label for="cats">Office Name<i style="color: red">*</i></label>
                        <select class="form-control offices" autofocus>
                            <option selected disabled>choose</option>
                            @foreach($office as $offices)
                            <option value="{{ $offices->id }}">{{ $offices->name }}</option>
                            @endforeach
                        </select>
                        
                        <br>

                        <label for="producers_id">Division<i style="color: red">*</i></label>
                        <select id="divisions" class="form-control divisions" autofocus data-selected-divisions="{{ old('division') }}">

                        </select>
                        <input type="hidden" name="id" readonly class="form-control id" autofocus style="border:none;">
                  </div>

                  <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text"placeholder="role" class="form-control roles" autofocus>
                  </div>

                  <div class="form-group">
                        <label for="user_type">User Type<i style="color: red">*</i></label>
                        <select class="form-control user_types" autofocus>
                            <option selected disabled>choose</option>
                            <option value="Supervisor">SUPERVISOR</option>
                            <option value="User">User</option>
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
                        email: $('.email').val(),
                        phone_no: $('.phone_no').val(),
                        office_id: $('.office').val(),
                        division_id: $('.division').val(),
                        role: $('.role').val(),
                        user_type: $('.user_type').val(),
                        password: $('.password').val(),
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
                $('.offices').val(response.office_id)
                $('.emails').val(response.email)
                $('.phone_nos').val(response.phone_no)
                $('.roles').val(response.role)

                
                $('.divisions').append($("<option />").val(response.division_id).text(response.division.name));
               
                $('.user_types').val(response.user_type)
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
                        email: $('.emails').val(),
                        phone_no: $('.phone_nos').val(),
                        office_id: $('.offices').val(),
                        division_id: $('.divisions').val(),
                        role: $('.roles').val(),
                        user_type: $('.user_types').val(),
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

$(document).ready(function(){
   $(document).on('change','.office',function(){
      // console.log("hmm its change");

      var office_id=$(this).val();
       console.log(office_id);
      var div=$(this).parent();

      var op=" ";

      $.ajax({
        type:'get',
        url:'{!!URL::to('employees_division')!!}',
        data:{'id':office_id},
        success:function(data){
          //console.log('success');

          //console.log(data);

          console.log(data.length);
          if(data == '')
          {
            op+='<option selected disabled></option>';
            div.find('.division').val(data.name);
          }
          else {
            op+='<option selected disabled></option>';
            }
          for(var i=0;i<data.length;i++){
          op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
           }

           div.find('.division').html(" ");
           div.find('.division').append(op);

          var division = $("#division").attr("data-selected-division");
          if(division !== '')
          {
          // assign chosen data attribute value to select
           $("#division").val(division);
           $("#division").change(); 
          }
        },
        error:function(){

        }
      });
    });

  });

$(document).ready(function(){
   $(document).on('change','.offices',function(){
      // console.log("hmm its change");

      var office_id=$(this).val();
       console.log(office_id);
      var div=$(this).parent();

      var op=" ";

      $.ajax({
        type:'get',
        url:'{!!URL::to('employees_division')!!}',
        data:{'id':office_id},
        success:function(data){
          //console.log('success');

          //console.log(data);

          console.log(data.length);
          if(data == '')
          {
            op+='<option selected disabled></option>';
            div.find('.divisions').val(data.name);
          }
          else {
            op+='<option selected disabled></option>';
            }
          for(var i=0;i<data.length;i++){
          op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
           }

           div.find('.divisions').html(" ");
           div.find('.divisions').append(op);

          var divisions = $("#divisions").attr("data-selected-divisions");
          if(divisions !== '')
          {
          // assign chosen data attribute value to select
           $("#divisions").val(divisions);
           $("#divisions").change(); 
          }
        },
        error:function(){

        }
      });
    });

  });
</script>

@endsection