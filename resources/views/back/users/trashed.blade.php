@extends('back.layouts.layout')
@section('title','Trashed Users')
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

<div class="card mb-4">
    <div class="card-header d-flex align-items-center">
        <span>
            <i class="fas fa-table-list me-1"></i>
            Users (<strong>{{$users->count()}}</strong>)
        </span>
        <span class="ms-auto">
            <a href="{{route('admin.users.index')}}" class="btn btn-outline-primary">
                <i class="fa fa-eye"></i>
                All users
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
                        <a href="{{route('admin.users.recoverUser',$user->user_id)}}" title="Recycle" class="btn btn-sm btn-primary"><i class="fa fa-recycle px-1"></i></a>
                        <a href="{{route('admin.users.hardDeleteUser',$user->user_id)}}" title="HARD Delete" class="btn btn-sm btn-danger"><i class="fa fa-times px-1"></i></a>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
</div>

@endsection
