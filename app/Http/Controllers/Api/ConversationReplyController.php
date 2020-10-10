<?php

namespace App\Http\Controllers\Api;

use App\Events\ConversationReplyCreated;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use App\Transformers\ConversationTransformer;
use Illuminate\Http\Request;

class ConversationReplyController extends Controller
{

    public function __construct()
    {
     //   $this->middleware(['auth']);
    }

    public function store(Request $request, Conversation $conversation) {


        $this->validate($request,[
            'body' => 'required|max:4000'
        ]);

        $reply = new Conversation;
        $reply->body = $request->body;
        $reply->user()->associate(User::first());

        $conversation->replies()->save($reply);
        $conversation->touchLastReply();


        broadcast(new ConversationReplyCreated($reply))->toOthers();

        return fractal()
                ->item($reply)
                ->parseIncludes(['user', 'parent', 'parent.user', 'parent.users'])
                ->transformWith(new ConversationTransformer)
                ->toArray();
    }
}
