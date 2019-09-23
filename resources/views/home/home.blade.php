@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        <div class="post-preview">
            <h2 class="post-title">
                <a href="{{ route('show_post', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                @if ($post->status == Config::get('constants.POST_STATUS.DRAFT'))
                    <span class="badge badge-pill badge-secondary">Draft</span>
                @else
                    <span class="badge badge-pill badge-success">Published</span>
                @endif
            </h2>
            <div>
                <a href="{{ route('edit_post', ['slug' => $post->slug]) }}" class=""><i class="fas fa-edit"></i>Edit</a>
                <a href="{{ route('delete_post', ['slug' => $post->slug]) }}" data-toggle="modal"
                   data-target="#delete_post_{{ $post->id }}">
                    <i class="fas fa-trash"></i>Delete
                </a>
                <!-- Start:: Delete Modal Conference -->
                <div class="modal fade" id="delete_post_{{ $post->id }}" role="dialog">
                    <form method="post" action="{{ route('delete_post', ['id'=> $post->id ]) }}">
                        @csrf
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Are you sure delete: {{ $post->title }} ?</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End:: Delete Modal Conference -->
            </div>
            <div class="post-subtitle">
                {!! $post->short_body !!}
            </div>
            <div>
                <a href="{{ route('show_post', ['slug' => $post->slug]) }}" class="float-right">...read more</a>
            </div>
            <p class="post-meta">Posted by
                <a href="#">{{ $post->author->name }}</a>
                on {{ $post->created_at }}
            </p>
        </div>
    @endforeach
@endsection