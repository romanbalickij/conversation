<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['last_reply'];

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function users() {

        return $this->belongsToMany(User::class,'conversation_user');
    }

    public function usersExceptCurrentlyAuthenticated() {

        return $this->users()->where('user_id', '!=', auth()->id());
    }

    public function replies() {

        return $this->hasMany(Conversation::class,'parent_id')->latestFirst();
    }

    public function parent() {

        return $this->belongsTo(Conversation::class,'parent_id');
    }

    public function touchLastReply() {

        $this->last_reply = now();
        $this->save();
    }

    public function isReply() {

        return $this->parent_id !== null;
    }

    public function scopeLatestFirst($query) {

        return $query->orderBy('created_at', 'desc');
    }
}
