@extends('layouts.front')

@section('content')

    <div class="content-wrap card card-body bg-primary">
        <style>
            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            /* The Close Button */
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
        </style>

        <h4>{{$thread->subject}}</h4>
        <hr>

        <div class="thread-details">
            {{$thread->thread}}
        </div>

        <br>
        {{--@if(auth()->user()->id == $thread->user_id)--}}
        @can('update',$thread)
            <div class="actions">

                <a href="{{ route('thread.edit',$thread->id) }}" class="btn btn-info">Edit</a>

                <form action="{{ route('thread.destroy', $thread->id) }}" method="post" class="inline-it">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <input class="btn btn-danger" type="submit" value="delete">
                </form>

            </div>
        @endcan
        {{--@endif--}}
    </div>
    <hr>
    {{--Answers/comments--}}

    @foreach($thread->comments as $comment)
        <div class="comment-list card card-body bg-secondary">

            <h4>{{$comment->body}}</h4>
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    @if(!empty($thread->solution))
                        @if($thread->solution == $comment->id)
                            <button class="btn btn-success">Solution</button>
                        @endif
                    @else
                        {{--@if(auth()->check())--}}
                            {{--@if(auth()->user()->id == $thread->user_id )--}}

                                {{--<form action="{{ route('markAsSolution') }}" method="post" role="form">--}}
                                {{--{{csrf_field()}}--}}
                                {{--<input type="hidden" name="threadId" value="{{$thread->id}}">--}}
                                {{--<input type="hidden" name="solutionId" value="{{$comment->id}}">--}}
                                {{--<input type="submit" class="btn btn-sm btn-success text-right" id="{{$comment->id}}" value="Mark As Solution">--}}
                                {{--</form>--}}
                                @can('update',$thread)
                                <div class="btn btn-sm btn-success" onclick="markAsSolution('{{$thread->id}}','{{$comment->id}}',this)">Mark As Solution</div>
                                @endcan
                            {{--@endif--}}
                        {{--@endif--}}

                    @endif
                </div>
            </div>
            <lead> by {{$comment->user->name}}</lead>

            <div class="actions">
            <button class="btn btn-sm" id="{{$comment->id}}-count"> {{$comment->likes()->count()}}</button>
            <span class="btn btn-sm {{$comment->isLiked()?"liked":""}}"  onclick="likeIt('{{$comment->id}}', this)"><i class="material-icons ">done</i></span>

            {{--<a href="{{ route('thread.edit',$thread->id) }}" class="btn btn-info">Edit</a>--}}

            <!-- Modal -->
                <!-- Trigger/Open The Modal -->
                <button class="btn btn-sm btn-info" id="myBtn{{$comment->id}}">Edit</button>
                <div id="myModal{{$comment->id}}" class="modal">>
                    <div class="modal-content">
                        <span class="close{{$comment->id}}">&times;</span>
                        <form action="{{route('replycomment.store',$comment->id)}}" method="post" role="form">
                            {{csrf_field()}}
                            <legend>Create Reply</legend>

                            <div class="form-group">
                                <input type="text" class="form-control" name="body" id="" placeholder="Reply...">
                            </div>


                            <button type="submit" class="btn btn-primary">Reply</button>
                        </form>
                    </div>

                </div>

                <script>
                    const modal{{$comment->id}} = document.getElementById('myModal{{$comment->id}}');
                    const btn{{$comment->id}} = document.getElementById("myBtn{{$comment->id}}");
                    const span{{$comment->id}} = document.getElementsByClassName("close{{$comment->id}}")[0];
                    btn{{$comment->id}}.onclick = function() {
                        modal{{$comment->id}}.style.display = "block";
                    };
                    span{{$comment->id}}.onclick = function() {
                        modal{{$comment->id}}.style.display = "none";
                    };
                    window.onclick = function(event) {
                        if (event.target == modal{{$comment->id}}) {
                            modal{{$comment->id}}.style.display = "none";
                        }
                    }
                </script>


                <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="inline-it">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <input class="btn btn-sm btn-danger" type="submit" value="delete">
                </form>

            </div>

        </div>
        <hr>
        {{--reply to comment--}}
        <button class="btn btn-sm btn-light" onclick="openForm{{$comment->id}}()" style="margin-left: 40px;" >Reply</button>
        <br>
        {{--Reply Form--}}
        <div class="reply-form" id="myForm{{$comment->id}}" style="margin-left: 40px;display: none;">
            <form action="{{ route('replycomment.store', $comment->id) }}" method="post" role="form">
                {{csrf_field()}}
                <h4>Create Reply</h4>

                <div class="form-group">
                    <input type="text" class="form-control" name="body" id="" placeholder="Reply...">
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                <button type="button" class="btn btn-sm btn-light" onclick="closeForm{{$comment->id}}()">Close</button>
            </form>

        </div>
        <script>
            function openForm{{$comment->id}}() {
                document.getElementById("myForm{{$comment->id}}").style.display = "block";
            }

            function closeForm{{$comment->id}}() {
                document.getElementById("myForm{{$comment->id}}").style.display = "none";
            }
        </script>
        @foreach($comment->comments as $reply)
            <div class="small card card-body text-info reply-list" style="margin-left: 40px;">
                <p>{{$reply->body}}</p>
                <lead> by {{$reply->user->name}}</lead>

                <div class="actions">
                    <button class="btn btn-sm btn-info" id="myBtn{{$reply->id}}">Edit</button>

                    <div id="myModal{{$reply->id}}" class="modal">

                        <div class="modal-content">
                            <span class="close{{$reply->id}}">&times;</span>
                            <form action="{{ route('comment.update', $reply->id) }}" method="post" role="form">
                                {{csrf_field()}}
                                @method('PUT')
                                <legend>Edit comment</legend>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="body" id="" value="{{$comment->body}}">
                                </div>
                                <button class="btn btn-info" type="submit">Edit</button>
                            </form>
                        </div>

                    </div>

                    <script>
                        const modal{{$reply->id}} = document.getElementById('myModal{{$reply->id}}');
                        const btn{{$reply->id}} = document.getElementById("myBtn{{$reply->id}}");
                        const span{{$reply->id}} = document.getElementsByClassName("close{{$reply->id}}")[0];
                        btn{{$reply->id}}.onclick = function() {
                            modal{{$reply->id}}.style.display = "block";
                        };
                        span{{$reply->id}}.onclick = function() {
                            modal{{$reply->id}}.style.display = "none";
                        };
                        window.onclick = function(event) {
                            if (event.target == modal{{$comment->id}}) {
                                modal{{$reply->id}}.style.display = "none";
                            }
                        }
                    </script>


                    <form action="{{ route('comment.destroy', $reply->id) }}" method="post" class="inline-it">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input class="btn btn-sm btn-danger" type="submit" value="delete">
                    </form>

                </div>
            </div>
        @endforeach
        <br>
    @endforeach

    <div class="comment-form">
        <form action="{{ route('threadcomment.store', $thread->id) }}" method="post" role="form">
            {{csrf_field()}}
            <h4>Create Comment</h4>

            <div class="form-group">
                <input type="text" class="form-control" name="body" id="" placeholder="Input...">
            </div>

            <button type="submit" class="btn btn-primary">Comment</button>
        </form>
    </div>

@endsection

@section('js')

    <script>

        function markAsSolution(threadId, solutionId, elem){
            const csrfToken='{{csrf_token()}}';
            $.post('{{route('markAsSolution')}}', {solutionId: solutionId, threadId: threadId,_token:csrfToken}, function (data) {
                $(elem).text('Solution');
            });
        }

        function likeIt(commentId, elem) {
            const csrfToken='{{csrf_token()}}';
            var likesCount = parseInt($('#'+commentId+"-count").text());
            $.post('{{route('toggleLike')}}', {commentId: commentId,_token:csrfToken}, function (data) {
                console.log(data);
                if(data.message==='liked'){
                    $(elem).addClass('liked');
                    $('#'+commentId+"-count").text(likesCount+1);
                } else {
                    $('#'+commentId+"-count").text(likesCount-1);
                    $(elem).removeClass('liked');
                }
            });
        }
        
    </script>

@endsection