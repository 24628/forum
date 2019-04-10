<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Tag;

class ThreadController extends Controller
{
    function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('tags')){
            $threads = Thread::whereHas('tags', function ($query) use ($request) {
//                var_dump($request->tags);
                $query->where('tags.id', $request->tags);
            })->paginate();
        } else {
            $threads = Thread::paginate(10);
        }
        return view('thread.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('thread.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'subject' => 'required|min:10',
            'tags' => 'required',
            'thread' => 'required|min:20'
        ]);

        $thread = auth()->user()->threads()->create($request->all());

        $thread->tags()->attach($request->tags);

        return back()->withMessage('Thread Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return view('thread.single',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        return view('thread.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
//        if(auth()->user()->id !== $thread->user_id){
//            abort(401, "unauthorized");
//        }
        $this->authorize('update',$thread);

        //Validate
        $this->validate($request,[
            'subject' => 'required|min:10',
            'type' => 'required',
            'thread' => 'required|min:20'
        ]);

        //update

        $thread->update($request->all());

        return redirect()->route('thread.show',$thread->id)->withMessage('Thread Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
//        if(auth()->user()->id !== $thread->user_id){
//            abort(401, "unauthorized");
//        }

        $this->authorize('update',$thread);

        $thread->delete();

        return redirect()->route('thread.index')->withMessage('Thread Deleted');
    }

    public function markAsSolution()
    {

        $solutionId=Input::get('solutionId');
        $threadId=Input::get('threadId');
        $thread=Thread::find($threadId);
        $thread->solution=$solutionId;
        if($thread->save()){
            if(request()->ajax()){
                return response()->json(['status' => 'succes', 'message' => 'Marked As Solution']);
            }
            return back()->withMessage('Marked as solution');
        }
        return back()->withMessage('Failed');
    }
}
