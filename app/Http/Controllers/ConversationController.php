<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index() {

        return view('conversation.index');
    }

    public function show(Conversation $conversation) {


        //authorize/.....

        return view('conversation.index', compact('conversation'));
    }


}
