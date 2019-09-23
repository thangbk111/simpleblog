@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
@endsection

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="{{ asset('js/post/show.js') }}"></script>
@endsection

@section('content')
<!-- Post Content -->
<h2 class="post-title">
    {{ $post->title }}
    @auth
    @if (Auth::user()->is_admin == Config::get('constants.USER.ADMIN'))
        @if ($post->status == Config::get('constants.POST_STATUS.DRAFT'))
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#publishForm">Publish</button>
            <!-- Modal -->
            <div class="modal fade" id="publishForm" tabindex="-1" role="dialog" aria-labelledby="publishFormLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="publishFormLabel">Set Schedule Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('schedule_post', ['postId' => $post->id]) }}">
                            @csrf
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label for="published_at">Published At</label>
                                        <input required name="published_at" type="text" class="form-control datetimepicker-input" id="published_at" data-toggle="datetimepicker" data-target="#published_at"/>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <button type="button" data-toggle="modal" data-target="#unpublish_post" class="btn btn-dark">UnPublish</button>
            <form method="POST" action="{{ route('unpublish_post', ['postId' => $post->id]) }}">
                @csrf
                <div id="unpublish_post" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Are you sure unpublish post ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Yes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    @endif
    @endauth
</h2>
<article>
    {!! $post->body !!}
</article>
@endsection