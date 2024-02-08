@if(count($articles) > 0)
@foreach ($articles as $article)
    
<!-- Post preview-->
<div class="row">
    <div class="col-3 p-2">
        <img src="{{$article->article_image}}" class="img-fluid img-thumbnail rounded">
    </div>
    <div class="col-9">
        <div class="post-preview">

            <a href="{{Route('get.article',[$article->getCategory->category_slug,$article->article_slug])}}">
                <h2 class="post-title">{{$article->article_title}}</h2>
                <h3 class="post-subtitle">{!! Str::words($article->article_content, 14) !!}</h3>
            </a>
            <p class="post-meta">
                
                <a href="{{route('category',$article->getCategory->category_slug)}}">{{$article->getCategory->category_name}}</a>
                
                <span class="float-end">
                    {{$article->created_at->diffForHumans()}}
                </span>
            </p>
        </div>
    </div>
</div>

@if(!$loop->last)
<!-- Divider-->
<hr class="my-4" />
@endif

@endforeach

@else
    <div class="alert alert-danger rounded">
        <p class="h4 text-center">There is nothing we can do.</p>
    </div>
@endif

<!-- Pager-->
{{$articles->links()}}