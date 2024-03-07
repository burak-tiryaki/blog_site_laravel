@extends('back.layouts.layout')
@section('title','Users')
@section('content')

@if(session('status'))
<div class="row">{{-- Alert --}}
    <div class="col-12 text-center">
        <div class="alert alert-success mt-4">
            {{ session('status') }}
        </div>
    </div>
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-sm-4">
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
                <span>
                    <i class="fa-solid fa-user-plus"></i>
                    Create New User
                </span>
            </div>
            <div class="card-body">
                <form action="{{route('admin.users.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                        @error('name') <div class="text-small text-danger">{{$message}}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                        @error('email') <div class="text-small text-danger">{{$message}}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="password">
                        @error('password') <div class="text-small text-danger">{{$message}}</div> @enderror
                    </div>

                    <label class="form-label">Role</label>
                    @foreach ($roles as $role)
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="roles[]" value="{{$role}}" id="" class="form-check-input">
                            <label class="form-check-label">{{$role}}</label>
                        </div>
                    @endforeach
                    
                    <hr>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="status" id="" class="form-check-input">
                        <label class="form-check-label">Set as Active?</label>
                    </div>

                    <div class="mb-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center">
                <span>
                    <i class="fas fa-users me-1"></i>
                    All Users
                </span>
                <span class="ms-auto">
                    <a href="{{route('admin.users.getTrashedUsers')}}" class="btn btn-outline-secondary">
                        <i class="fa fa-trash"></i>
                        Deleted Users
                    </a>
                </span>
            </div>
            <div class="card-body">
        
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->user_id}}</td>
                            <td>{{$user->user_name}}</td>
                            <td>{{$user->user_email}}</td>
                            <td>{{ implode(', ', $user->roles()->pluck('name')->toArray()) }}</td>
                            <td>
                                <a href="{{route('admin.users.changeStatus',$user->user_id)}}" 
                                    class="btn btn-sm {!!$user->user_status == 1 ? 'btn-success' : 'btn-danger'!!}">
                                    {!!$user->user_status == 1 ? 'Active' : 'Passive'!!}
                                </a>
                            </td>
                            <td>
                                <a href="#" title="Edit" user-id="{{$user->user_id}}" class="btn btn-sm btn-primary custom-edit-click"><i class="fa fa-pen px-1"></i></a>
                                <a href="{{route('admin.users.trashUser',$user->user_id)}}" title="Delete" class="btn btn-sm btn-danger custom-delete-click"><i class="fa fa-trash px-1"></i></a>
                            </td>
                        </tr>
                        @endforeach
                       
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('admin.users.updateUser')}}" method="post">
            @csrf
            <input type="hidden" name="id" id="user-id">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="modalName" id="modalName">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="modalEmail" id="modalEmail">
            </div>

            <label class="form-check-label mb-1">Roles</label>
            @foreach ($roles as $role)
                <div class="mb-3 form-check">

                    <input type="checkbox" 
                    name="modalRoles[]" 
                    value="{{$role}}" 
                    id="modal{{$role}}" 
                    class="form-check-input">

                    <label class="form-check-label">{{$role}}</label>
                </div>
            @endforeach

        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
            </form>
      </div>
    </div>
</div> 

@endsection

@section('headScript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('script')
<script>
    // Document hazır olduğunda işlemleri gerçekleştir
    $(document).ready(function() {
        
        //------ Edit Butonuna click event'i ekle ----------
        $(".custom-edit-click").click(function(event) {
                    
            // AJAX isteği yap
            id = $(this)[0].getAttribute('user-id');
            //console.log(id);

            $.ajax({
                type: "GET", // GET veya POST olarak isteği yapılandırın
                url: "{{route('admin.users.getData')}}", // AJAX isteğinin yapılacağı adresi belirtin
                data: {id:id}, // Sunucuya gönderilecek verileri belirtin (isteğe bağlı)
                success: function(response) {
                    // AJAX isteği başarılı olduğunda yapılacak işlemler
                    console.log(response)
                    $('#modalName').val(response.user_name);
                    $('#modalEmail').val(response.user_email);
                    $('#user-id').val(response.user_id);

                    // İlk önce bütün checkbox'ları boşalt
                    var allRoles = response.allRoles;
                    if (allRoles && allRoles.length > 0) {
                        allRoles.forEach(function(role) {
                            $('#modal' + role).prop('checked', false);
                        });
                    }
                    // Kullanıcının rollerini kontrol edin
                    var userRoles = response.roles;
                    if (userRoles && userRoles.length > 0) {
                        // Her bir rol için checkbox işaretini kontrol edin
                        userRoles.forEach(function(role) {
                            // İlgili rolün checkbox'unu işaretle
                            $('#modal' + role.name).prop('checked', true);
                        });
                    }

                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // AJAX isteği başarısız olduğunda yapılacak işlemler
                    console.error(error); // Hata konsoluna hata mesajını yazdır
                }
            });
        });
    });
</script>
    
@endsection