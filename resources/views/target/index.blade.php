@extends('layouts.apps')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Targets
                        <span style="float: right;">
                        <button  class="btn btn-primary btn-sm add"><i class="fa fa-plus-circle"></i> add</button> 
                        </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <a href="#" class="output">Output</a> 
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Period From</th>
                                <th class="sorting" style="width: 15%; cursor: pointer;">Period To</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Code</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Target</th>
                                <th class="sorting" style="width: 50%; cursor: pointer;">Indicator</th>
                                <th class="text-center sorting" style="width: 10%; cursor: pointer;">Action</th>
                                
                                </tr>
                            </thead>
                            @forelse($target as $targets)
                            <tbody>
                                <tr>
                                    <td>{{ date('F, Y', strtotime($targets->period_from)) }}</td>
                                    <td>{{ date('F, Y', strtotime($targets->period_to)) }}</td>
                                    <td>{{ $targets->code }}</td>
                                    <td>{{ $targets->qty }}</td>
                                    <td>{{ $targets->indicator }}</td>
                                    <td> 
                                    <div role="group" class="btn-group">
                                        <button data-id="{{ $targets->id }}"  class="btn btn-link btn-sm btn_edit"><span class="fa fa-edit"></span></button>

                                        <button data-id="{{ $targets->id }}" class="btn btn-link text-danger btn-sm btn_delete"><span class="fa fa-trash"></span></button>

                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                            @empty
                                <td colspan="6">No records found.</td>
                            @endforelse
                        </table>
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
                <h5 class="modal-title" id="exampleModalLabel">add Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  
                  <div class="form-group">
                        <label for="date">Period from<i style="color: red">*</i></label>
                        <input type="date" value="" class="form-control period_from" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="date">Period to<i style="color: red">*</i></label>
                        <input type="date" value="" class="form-control period_to" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="code">IPCR Code<i style="color: red">*</i></label>
                        <input type="text"placeholder="Your Code" class="form-control code" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="indicator">Indicator<i style="color: red">*</i></label>
                        <textarea class="form-control indicator" autofocus rows="5"></textarea>
                  </div>
                  <div class="form-group">
                        <label for="Quantity">Quantity<i style="color: red">*</i></label>
                        <input type="text"placeholder="Your Answer" class="form-control qty" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
                  </div>
                  <div class="form-group">
                       
                        <input type="hidden" class="form-control position" value="{{ $user->FPOSITION }}" autofocus >
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
                <h5 class="modal-title" id="exampleModalLabel">update Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  
                  <div class="form-group">
                        <label for="date">Period from<i style="color: red">*</i></label>
                        <input type="date" value="" class="form-control period_froms" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="date">Period to<i style="color: red">*</i></label>
                        <input type="date" value="" class="form-control period_tos" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="code">IPCR Code<i style="color: red">*</i></label>
                        <input type="text"placeholder="Your Code" class="form-control codes" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
                  </div>
                  <div class="form-group">
                        <label for="indicator">Indicator<i style="color: red">*</i></label>
                        <textarea class="form-control indicators" autofocus rows="5"></textarea>
                  </div>
                  <div class="form-group">
                        <label for="Quantity">Quantity<i style="color: red">*</i></label>
                        <input type="text"placeholder="Your Answer" class="form-control qtys" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autofocus>
                  </div>
                  <div class="form-group">
                        <input type="hidden" class="form-control positions" value="{{ $user->FPOSITION }}" autofocus >
                  </div>
                  <input type="hidden" name="id"  class="form-control id" autofocus style="border:none;">
            </div>   
            <div class="modal-footer">
                  <span class="text-warning"> 
                            <button class="btn btn-primary btn-sm save_edit"><i class="fa fa-edit"></i> save</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>

<!--output-->
<div class="modal fade" id="output" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static"  data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Output Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                                <tr>
                                <th  rowspan="2" class="sorting" style="width: 30%; cursor: pointer;">Date</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Code</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Target</th>
                                <th class="sorting" style="width: 40%; cursor: pointer;">Indicator</th>
                                <th class="sorting" style="width: 10%; cursor: pointer;">Acquired</th>
                                
                                </tr>
                            </thead>
                         @forelse($output as $outputs)
                         <tbody>
                                <tr>
                                    <td rowspan="2">{{ date('F, Y', strtotime($outputs->period_from)) }} - {{ date('F, Y', strtotime($outputs->period_to)) }}</td> 
                                    <td>{{ $outputs->target->code }}</td>
                                    <td>{{ $outputs->target->qty }}</td>
                                    <td>{{ $outputs->target->indicator }}</td>
                                    <td>{{ $outputs->counted }}</td>
                                </tr>
                                 
                                
                            </tbody>
                        @empty
                                <td colspan="5">No records found.</td>
                        @endforelse
                    </table>
                </table>
                </div>
                  {{ $output->appends(request()->except('page'))->links() }}
            </div>   
            <div class="modal-footer">
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

         $('.output').click(function(){
            $('#output').modal('show')
        })

        $('.save').click(function() {
            $.post('{{ route("targets.store") }}', {
                        "_token": "{{ csrf_token() }}",
                        period_from: $('.period_from').val(),
                        period_to: $('.period_to').val(),
                        code: $('.code').val(),
                        indicator: $('.indicator').val(),
                        qty: $('.qty').val(),
                        position: $('.position').val(),
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

            $.post('/targets/target_edit', {
               "_token": "{{ csrf_token() }}",
               id: id
            })
            .done(function (response) {
                $('.period_froms').val(response.period_from)
                $('.period_tos').val(response.period_to)
                $('.codes').val(response.code)
                $('.indicators').val(response.indicator)
                $('.qtys').val(response.qty)
                $('.id').val(id)
                $('.positions').val(response.position)
                
            })

          })
    })

    $('.save_edit').click(function(){

            $.post('{{ route("targetupdate")}}', {
                        "_token": "{{ csrf_token() }}",
                        id: $('.id').val(),
                        period_from: $('.period_froms').val(),
                        period_to: $('.period_tos').val(),
                        code: $('.codes').val(),
                        indicator: $('.indicators').val(),
                        qty: $('.qtys').val(),
                        position: $('.positions').val(),
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
                        $.post('{{ route("targetdelete") }}', {
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
