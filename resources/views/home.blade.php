@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">

                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade" role="alert" id="message">
                        <strong>Succesfully Updated!</strong> You should check in on some of those fields below.
                        <button type="button" class="close" dat a-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <button class="fa fa-plus-square create-modal btn btn-dark pull-right" data-info="">Add Cargo</button>
                    <a class="fa fa-file-excel-o btn btn-success pull-right" href="export">Export to Excel</a>

                    <table id="cargo-table" class="table table-striped table-bordered " style="width:100%">
                        <thead>
                            <tr>
                                <th>qrcode</th>
                                <th>Name</th>
                                <th>cargo status</th>
                                <th>cargo_code</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th style="width: 130px">Contact Person</th>
                                {{-- <th>Date of entry</th> --}}
                                <th  class="actions text-right dt-not-orderable sorting_disabled"  style="width: 130px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach ($cargos as $cargo)
                    <tr class="item{{$cargo->id}}">

                        {{-- <td><img src="{{asset('/img/'.$cargo->name.'.svg')}}" class="img-thumbnail rounded mx-auto d-block" style="height: 50px; width:50px"></td> --}}
                        {{-- <td><img src="" class="img-thumbnail rounded mx-auto d-block" style="height: 50px; width:50px"></td> --}}
                        <td>{!! QrCode::size(50)->generate('https://localhost:8000'.$cargo->cargo_code) !!}</td>
                        <td>{{$cargo->name}}</td>
                        <td>{{$cargo->cargo_status}}</td>
                        <td>{{$cargo->cargo_code}}</td>
                        <td>{{$cargo->cargo_description}}</td>
                        <td>{{$cargo->official_address}}</td>
                        <td>{{$cargo->contact_person}}</td>
                        {{-- <td>{{$cargo->created_at}}</td> --}}
                        <td class="no-sort no-click bread-actions">
                            <button class="edit-modal btn btn-sm btn-info center" data-info="{{$cargo->id}},{{$cargo->name}},{{$cargo->cargo_code}},{{$cargo->cargo_status}},{{$cargo->cargo_description}},{{$cargo->official_address}},{{$cargo->contact_person}}">
                            <span class="fa fa-edit"></span> Edit
                            </button>
                            <button class="delete-modal btn btn-sm btn-danger center" data-info="{{$cargo->name}},{{$cargo->id}}">
                                <span class="fa fa-trash"></span> Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade" id="cargo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                {{-- <h1 class="text-hide" style="{{asset('/img/'.$cargo->name.'.svg')}}'); width: 50px; height: 50px;">Bootstrap</h1> --}}
                <span class="fa fa-edit"><h5 class="modal-title">Edit</h5></span>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ">
                <div class="form-horizontal px-5 align-middle">
                    <div class="alert alert-danger alert-dismissible cargo_error" role="alert" id="error-message">
                        <strong>ERROR!</strong> You should check in on some of those fields below.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @csrf
                    <input type="hidden" name="did" id="did" value="">
                    <div class="form-group row" id="id-group">
                        <div class="col-md-4 "><label class="pull-right">ID</label></div>
                        <div class="col-md-8"><input type="text"  class="form-control " id="id" placeholder="" disabled/></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 "><label class="pull-right">Name</label></div>
                        <div class="col-md-8"><input type="text"  class="form-control" id="name" placeholder=""/></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4"><label class="pull-right">Cargo Status</label></div>
                        <div class="col-md-8 dropdown">
                            <input type="text"  class="form-control" id="cargo_status" placeholder=""/>
                            {{-- <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown button
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                              </ul> --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4"><label class="pull-right">Cargo Code</label></div>
                        <div class="col-md-8"><input type="text"  class="form-control" id="cargo_code" placeholder=""/></div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4"><label class="pull-right">Description</label></div>
                        <div class="col-md-8"><input type="text"  class="form-control" id="cargo_description" placeholder=""/></div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4"><label class="pull-right">Address</label></div>
                        <div class="col-md-8"><input type="text"  class="form-control" id="official_address" placeholder=""/></div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4"><label class="pull-right">Contact Person</label></div>
                        <div class="col-md-8"><input type="text"  class="form-control" id="contact_person" placeholder=""/></div>
                    </div>

                </div>
                <div class="deleteContent">
                    <h3 class="dname">Are you sure you want to delete? </h3>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary actionBtn save">Save changes</button>
            </div>
          </div>
        </div>
      </div>
</div>

<script>
    $(document).ready(function() {

        $('#error-message').hide();
        $('#message').hide();
        $('#cargo-table').DataTable({
            rowReorder: {selector: 'td:nth-child(2)'},
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ],
        });
        $('#cargo-modal').on('hidden.bs.modal', function (e) {
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
            })
        // create new
        $(document).on('click', '.create-modal', function() {
            $('#footer_action_button').text(" Create");
            $('#footer_action_button').addClass('fa fa-edit');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('#id-group').hide();
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('.actionBtn').removeClass('save');
            $('.actionBtn').addClass('create');
            $('.actionBtn').text('Create');
            $('.modal-title').text('Create New');
            $('.deleteContent').hide();

            $('.form-horizontal').show();
            $('#cargo-modal').modal('show');
        });
        // edit
        $(document).on('click', '.edit-modal', function() {
            $('#footer_action_button').text(" Update");
            $('#footer_action_button').addClass('glyphicon-check');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('.actionBtn').addClass('edit');
            $('.actionBtn').text('Update');
            $('.modal-title').text('Edit');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            var stuff = $(this).data('info').split(',');
            fillmodalData(stuff)
            $('#cargo-modal').modal('show');
        });

        function fillmodalData(details){
            $('#id').val(details[0]);
            $('#name').val(details[1]);
            $('#cargo_code').val(details[2]);
            $('#cargo_status').val(details[3]);
            $('#cargo_description').val(details[4]);
            $('#official_address').val(details[5]);
            $('#contact_person').val(details[6]);
        }
        // delete
        $(document).on('click', '.delete-modal', function() {
            $('#footer_action_button').text(" Delete");
            $('#footer_action_button').removeClass('glyphicon-check');
            $('#footer_action_button').addClass('glyphicon-trash');
            $('.actionBtn').removeClass('btn-success');
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').removeClass('save');
            $('.actionBtn').addClass('delete');
            $('.actionBtn').text('Delete');
            $('.modal-title').text('Delete');
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            var stuff = $(this).data('info').split(',');
            $('#did').val(stuff[1]);
            $('.dname').html('Are you sure you want to delete '+stuff[0])+ '?';
            $('#cargo-modal').modal('show');
        });
        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: 'post',
                url: '/deleteItem',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': $("#did").val()
                },
                success: function(data) {
                    $('.item' + $('#did').val()).remove();
                    $('#cargo-modal').modal('hide');
                    $('#message').removeClass('fade');
                    $('#message').show().delay(1500).fadeOut();
                    $('#message').removeClass('alert-success');
                    $('#message').addClass('alert-danger');

                }
            });
        });
        $('.modal-footer').on('click', '.create', function() {
            $.ajax({
                type: 'post',
                url: '/new-cargo',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': $("#id").val(),
                    'name': $('#name').val(),
                    'cargo_code': $('#cargo_code').val(),
                    'cargo_status': $('#cargo_status').val(),
                    'cargo_description': $('#cargo_description').val(),
                    'official_address': $('#official_address').val(),
                    'contact_person': $('#contact_person').val()
                },
                success: function(result) {
                    if (result.errors){
                        // $('#cargo-modal').modal('show');
                        if(result.errors.name) {
                            $('#error-message').show();
                            $('.cargo_error').text("name can't be empty !");
                        }
                    }
                    else{
                        $('#cargo-modal').modal('hide');
                        $('#message').show().delay(1500).fadeOut();;
                        $('#message').removeClass('alert-danger');
                        $('#message').addClass('alert-success');
                        $('.alert-dismissible').addClass('show');
                        $('.error').addClass('hidden');

                        $('.item' + result.id + 1).replaceWith("<tr class='item" +
                            result.id + 1 + "'>" +
                            "<td><img src='{{asset('/img/'.$cargo->name.'.svg')}}' class='img-thumbnail rounded mx-auto d-block' style='height: 50px; width:50px'></td><td>" +
                            result.name + "</td><td>" +
                            result.cargo_status + "</td><td>" +
                            result.cargo_code + "</td><td>" +
                            result.cargo_description + "</td><td>" +
                            result.official_address  + "</td><td>" +
                            result.contact_person + "</td>" +
                          "<td><button class='edit-modal btn btn-sm btn-info' data-info='" +
                          result.id + 1 +","+
                          result.name+","+
                          result.cargo_status+","+
                          result.cargo_code+","+
                          result.cargo_description+","+
                          result.official_address+","+
                          result.contact_person+"'><span class='fa fa-edit'></span> Edit</button> <button class='delete-modal btn btn-sm btn-danger' data-info='" + result.id+","+result.first_name+","+result.last_name+","+result.email+","+result.gender+","+result.country+","+result.salary+"' ><span class='fa fa-trash'></span> Delete</button></td></tr>");
                          setTimeout(function() {
                                location.reload();
                        }, 1500);
                    }
                }
            });
        });
        // update
        $('.modal-footer').on('click', '.save', function() {
            $.ajax({
                type: 'post',
                url: '/updateItem',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': $("#id").val(),
                    'name': $('#name').val(),
                    'cargo_code': $('#cargo_code').val(),
                    'cargo_status': $('#cargo_status').val(),
                    'cargo_description': $('#cargo_description').val(),
                    'official_address': $('#official_address').val(),
                    'contact_person': $('#contact_person').val()
                },
                success: function(result) {
                    $('#cargo-modal').modal('hide');
                    $('#message').show().delay(1500).fadeOut();;
                    $('#message').removeClass('alert-danger');
                    $('#message').addClass('alert-success');
                    $('.alert-dismissible').addClass('show');
                    console.log(result.id);
                        $('.item' + result.id).replaceWith("<tr class='item" +
                            result.id + "'>" +
                            "<td><img src='{{asset('/img/'.$cargo->name.'.svg')}}' class='img-thumbnail rounded mx-auto d-block' style='height: 50px; width:50px'></td><td>" +
                            result.name + "</td><td>" +
                            result.cargo_status + "</td><td>" +
                            result.cargo_code + "</td><td>" +
                            result.cargo_description + "</td><td>" +
                            result.official_address  + "</td><td>" +
                            result.contact_person + "</td>" +
                          "<td><button class='edit-modal btn btn-sm btn-info' data-info='" +
                          result.name+","+
                          result.cargo_status+","+
                          result.cargo_code+","+
                          result.cargo_description+","+
                          result.official_address+","+
                          result.contact_person+","+
                          result.id+"'><span class='fa fa-edit'></span> Edit</button> <button class='delete-modal btn btn-sm btn-danger' data-info='" +
                          result.id+","+
                          result.cargo_status+","+
                          result.cargo_code+","+
                          result.cargo_description+","+
                          result.official_address+","+
                          result.contact_person+"'><span class='fa fa-trash'></span> Delete</button></td></tr>");

                }
            });
        });
    });
</script>
@endsection
