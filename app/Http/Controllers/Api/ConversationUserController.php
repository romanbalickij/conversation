<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Transformers\ConversationTransformer;
use Illuminate\Http\Request;

class ConversationUserController extends Controller
{

    public function store(Request $request ,Conversation $conversation ) {

        //auth
        $this->validate($request,[
            'recipients' => 'required|array|exists:users,id'
        ]);

        $conversation->users()->syncWithoutDetaching($request->recipients);

        $conversation->load(['users']);

        return fractal()
            ->item($conversation)
            ->parseIncludes(['user', 'users'])
            ->transformWith(new ConversationTransformer())
            ->toArray();


    }
}
