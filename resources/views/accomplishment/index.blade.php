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
                                @if(auth::user()->user_type == 'User' || auth::user()->user_type == null || auth::user()->user_type == 'administrator')
                              <form action="{{ route('searchs') }}" method="GET" role="search">
                                <div class="form-group">    
                                    <div class="input-group-prepend">
                                 
                                        <input type="date" class="form-control"  name="search" >
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button> 
                                    </div>
                                </div>
                              </form>
                               @endif
                               @if(auth::user()->user_type == 'Supervisor')
                               <form action="{{ route('searchs') }}" method="GET" role="search">
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
                              @if($accomp->quantity != null)
                              <p class="commenter-time text-muted" style="font-size: 11px;">Qty: <b>{{ $accomp->quantity }}</b>
                              </p>
                              @endif
                              </span> 
                                  
                              <p class="comment-txt more"><b style="font-size: 12px; font-family: serif;">Accomplishment <br>
                              </b>{{ $accomp->accomplishment }}
                            </p>
                            @if(auth::user()->user_type == 'Supervisor')
                                <p class="commenter-time text-muted" style="font-size: 10px;">{{ $accomp->user->FLAST }}, {{ $accomp->user->FFIRST }}</p>
                              @endif
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
                  @if($user->office_id == 0)
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
                        <input type="text"placeholder="Your Answer" class="form-control quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
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
                        <input type="text"placeholder="Your Answer" class="form-control quantities" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
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
                        division_id: $('.division').val(),
                        office_id: $('.office').val(),
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

    $(document).ready(function(){
   $(document).on('change','.office',function(){
      // console.log("hmm its change");

      var office_id=$(this).val();
       console.log(office_id);
      var div=$(this).parent();

      var op=" ";

      $.ajax({
        type:'get',
        url:'{!!URL::to('accomplishment_division')!!}',
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
</script>
@endsection