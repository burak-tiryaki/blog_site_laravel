
<div class="col-md-3 order-md-2 mb-3">
    <div class="card rounded">
        <div class="card-header text-center">
            Categories
        </div>
        <div class="">
            <ul class="list-group">

            @foreach ($categories as $cat)  
                <li class="list-group-item d-flex justify-content-between align-items-center ">
                    <a href="{{route('category',$cat->category_slug)}}"
                        class="{{Request::segment(2) == $cat->category_slug ? 'bg-primary d-flex rounded p-1 text-white me-1' :''}}  "
                        >{{$cat->category_name}}</a>
                    <span class="badge bg-primary rounded-pill">{{$cat->getArticleCount()}}</span>
                </li>
            @endforeach
                
            </ul>
        </div>
    </div>
    
</div>
