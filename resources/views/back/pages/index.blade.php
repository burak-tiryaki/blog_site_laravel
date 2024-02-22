@extends('back.layouts.layout')
@section('title','All Pages')
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
            Pages (<strong>{{$pages->count()}}</strong>)
            {{ empty(config('app.custom_site_logo')) ?'bu silah boş':'' }}
        </span>
        <span class="ms-auto">
            {{-- <a href="#" class="btn btn-outline-secondary">
                <i class="fa fa-trash"></i>
                Trashed pages
            </a> --}}
        </span>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Order</th>
                    <th>Content</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Order</th>
                    <th>Content</th>
                    <th>Create Date</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </tfoot>
            <tbody id="orderPages">
                @foreach ($pages as $page)
                <tr>
                    <td>
                        <img src="{{$page->page_image}}" style="max-width: 150px" class="w-100 d-inline-block rounded" alt="" srcset="">
                    </td>
                    <td>{{$page->page_title}}</td>
                    <td>{{$page->page_order}}</td>
                    <td>{{ Str::words($page->page_content, 10) }}</td>
                    <td>{{$page->created_at}}</td>
                    <td>
                        <a href="{{route('admin.pages.changeStatus',$page->page_id)}}" 
                            class="btn btn-sm {!!$page->page_status == 1 ? 'btn-success' : 'btn-danger'!!}">
                            {!!$page->page_status == 1 ? 'Active' : 'Passive'!!}
                        </a>
                    </td>
                    <td>
                        <a href="{{route('page',$page->page_slug)}}" target="_blank" title="Show" class="btn btn-sm btn-success"><i class="fa fa-eye px-1"></i></a>
                        <a href="{{route('admin.pages.edit',$page->page_id)}}" title="Edit" class="btn btn-sm btn-primary"><i class="fa fa-pen px-1"></i></a>
                        <a href="#" page-id="{{$page->page_id}}" page-name="{{$page->page_title}}" title="Delete" class="btn btn-sm btn-danger custom-delete-click"><i class="fa fa-trash px-1"></i></a>
                    </td>
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete page</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="row">{{-- Alert --}}
                <div class="col-12 text-center">
                    <div class="alert alert-danger mt-4">
                        <span class="" id="articleAlert"></span>
                    </div>
                </div>
            </div>

          <form action="{{route('admin.pages.deletePage')}}" method="post">
            @csrf
            <input type="hidden" name="deleteId" id="deletepageid">
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="deleteButton" type="submit" class="btn btn-danger">Delete</button>
        </div>
            </form>
      </div>
    </div>
</div> 

@endsection
@section('headScript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    /* The switch - the box around the slider */
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* The slider */
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        //------ Delete Butonuna click event'i ekle ----------
        $(".custom-delete-click").click(function(event) {
            // Tarayıcıda varsayılan davranışı engelle
            event.preventDefault();
            
            id = $(this)[0].getAttribute('page-id');
            page = $(this)[0].getAttribute('page-name');
            $('#articleAlert').html('Are you sure you want to delete the <strong>' + page + '</strong> page?');
            $('#deletepageid').val(id);
            $('#deleteModal').modal('show');
        });
    });
</script>

@endsection