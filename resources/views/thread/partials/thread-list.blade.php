<div class="list-group">

    @forelse($threads as $thread)

        <div class="card" style="margin-bottom: 25px">
            <div class="bg-light">
                <h3 class="card-title"><a href="{{ route('thread.show', $thread->id) }}">{{$thread->subject}}</a></h3>
            </div>
            <div class="card-body">
                <p>{{str_limit($thread->thread, 100)}}
                    <br>
                    Posted by <a href="{{ route('user_profile', $thread->user->name ) }}">{{$thread->user->name}}</a> {{$thread->created_at->diffForHumans()}}
                </p>
            </div>
        </div>

    @empty
        <h5>No Threads</h5>
    @endforelse

        {{ $threads->appends(['tags' => $tags])->links() }}
</div>