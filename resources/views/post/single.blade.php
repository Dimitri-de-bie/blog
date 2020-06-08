@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 post-single">
                <h1 class="title">{{$post->title}}</h1>
                <hr/>
                <div class="single-post">
                    <p class="post-content">{!! $post->content !!}</p>
                    <hr/>
                    <i>Geplaatst op: {{ $post->published_at ?? "Not yet published" }}</i>
                </div>
                <hr/>

                    @auth()
                    @if(!$post->published_at && Auth::user()->can('publish',$post))
                        <button class="btn btn-success" onclick="event.preventDefault(); document.getElementById('publish-post-form').submit();">
                            Publish post
                        </button>
                        <form id="publish-post-form" action="/posts/{{$post->id}}/publish" method="POST" style="display:none;">
                            @csrf;
                        </form>
                    @endif
                        @can('update', $post)
                        <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary ">Edit post</a>
                        @endcan
                        <a class="teruglink2" href="/posts">terug</a>
                </div>
                @endauth
            <hr/>
            <br/>
            <div class="comment">
            @foreach($post->comments as $comment)

                    <div class="comment-details">
                        <i class="comment-info">Commentend by: {{$comment->author->name}} at {{$comment->created_at}}</i>
                        <p class="comment-content">{{$comment->content}}</p>
                        @can('delete',$comment)
                            <button class="btn btn-danger comment-delete" onclick="event.preventDefault(); document.getElementById('delete-comment-form').submit();">
                                Delete comment
                            </button>
                            <form id="delete-comment-form" action="/comment/{{$comment->id}}" method="post" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                        @endcan
                    </div>
                @endforeach
                </div>

            @auth()
                <hr>
                <div class="single-post-comment">
                    <p class="comment-title">Any comments?</p>
                    <form action="/posts/{{$post->id}}/comment" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="txtComment">Comment</label>
                            <textarea class="form-control" name="txtComment" id="txtComment" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save comment</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
@endsection