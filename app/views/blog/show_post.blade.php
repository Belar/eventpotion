@extends('allround.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="blog-post col-md-8">
            <h2>{{{ $post->title }}}
                @if(Sentry::check()) 
                @if(Sentry::getUser()->id == $post->author_id || Sentry::getUser()->hasAccess('admin'))
                <small class="event-management"><a href="{{{ URL::to('/blog/edit/'.$post->id) }}}"><i class="fa fa-pencil"></i></a></small>
                @endif
                @endif
            </h2>
            @if($post->header_image)
            <img class="blog-post-header img-responsive" src="{{{ URL::to('uploads/posts/'.$post->header_image) }}}">
            @endif
            <div id="event-about" class="row">
                <div class="col-md-12">
                    {{ Purifier::clean($post->content) }}

                    <p class="tags"><i class="fa fa-tag"></i>
                        @foreach ( explode(",",$post->tags) as $tag)
                        <a href="/blog/tag/{{{ trim($tag) }}}">{{{ trim($tag) }}}</a>
                        @endforeach</p>	
                </div>	
            </div>
        </div>
        <div class="col-md-4">
            @include('generals.sidebar_blog')
        </div>
    </div>

</div>
@stop