<?php

namespace App\Http\Controllers\Api;

use App\Events\ConversationCreated;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Transformers\ConversationTransformer;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct() {

        $this->middleware(['auth']);
    }

    public function index(Request $request) {

        $conversations = $request->user()->conversations()->get();

        return fractal()
                ->collection($conversations)
                ->parseIncludes(['user', 'users'])
                ->transformWith(new ConversationTransformer())
                ->toArray();

    }

    public function show(Conversation $conversation) {

        if($conversation->isReply()) {
            abort(404);
        }

        return fractal()
            ->item($conversation)
            ->parseIncludes(['user', 'users', 'replies', 'replies.user'])
            ->transformWith(new ConversationTransformer())
            ->toArray();
    }

    public function store(Request $request){

        //validate

        $conversation = new Conversation;
        $conversation->body = $request->body;
        $conversation->user()->associate($request->user()); //auth user
        $conversation->save();

        $conversation->touchLastReply();

        $conversation->users()->sync(array_unique(
            array_merge($request->recipients, [$request->user()->id])
        ));  // users [1,2,3]

        $conversation->load('users');

        broadcast(new ConversationCreated($conversation))->toOthers();

        return fractal()
            ->item($conversation)
            ->parseIncludes(['user', 'users', 'replies', 'replies.user'])
            ->transformWith(new ConversationTransformer())
            ->toArray();


//        $room = new Room;
//        $room->body = 'generate title ';
//        $room->save();
//
//
//
//        $message = new Message ;
//        $message->body = $request->body;
//        $message->user()->associate($request->user());
//        $message->rooms()->associate($room);
//
//        $room->users()->sync($request->recipients + auth()->id());
    }
}
