@extends('allround.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @foreach($posts as $post)
            <div class="blog-post">
                <h2>{{{ $post->title }}}
                    @if(Sentry::check()) 
                    @if(Sentry::getUser()->id == $post->author_id || Sentry::getUser()->hasAccess('admin'))
                    <small class="event-management"><a href="{{{ URL::to('/blog/edit/'.$post->id) }}}"><i class="fa fa-pencil"></i></a></small>
                    @endif
                    @endif
                </h2>
                <div id="event-about" class="row">
                    <div class="col-md-12">
                        @if($post->header_image)
                        <img class="blog-post-header img-responsive" src="{{{ URL::to('uploads/posts/'.$post->header_image) }}}">
                        @endif

                        {{ Purifier::clean(substr($post->content,0, 350) )}}


                    </div>	
                </div>
            </div>
            <div class="row">
                <div class="tags col-xs-10">
                    <i class="fa fa-tag"></i>
                    @foreach ( explode(",",$post->tags) as $tag)
                    <a href="/blog/tag/{{{ trim($tag) }}}">{{{ trim($tag) }}}</a>
                    @endforeach</div>	
                <div class="tags col-xs-2">
                    <a href="{{{ URL::to('/blog/'.$post->slug) }}}"><i class="fa  fa-angle-double-right"></i> Read more</a>
                </div>
            </div>
            @endforeach
            {{ $posts->links() }}
        </div>
        <div class="col-md-4">
            @include('generals.sidebar_blog')
        </div>
    </div>

</div>
@stop