<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_caption',
        'comment',
        'image_path',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //her post birden fazla yorum vardir
    public function comments()
    {
        return $this->hasMany(comment::class)->orderBy('created_at', 'DESC');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likse');
    }


    //like vermek icin kullandi
    // public function like(User $user)
    // {
    //     return $this->likedByUsers()->save($user);
    // }

    // //like silmek icin kullandik

    // public function dislike(User $user)
    // {
    //     return $this->likedByUsers()->detach($user);
    // }

    //EGER LIKE VARSA YOKSA 
    public function likedByUser(User $user)
    {
        return (bool)DB::table('likse')
            ->where('user_id', $user->id)
            ->where('post_id', $this->id)
            ->count();
    }

    // hangi function kullanacgiz bilertieceigiz like yoksa dislike 
    // public function likesystem(user $user)
    // {
    //     if ($this->likedByUser($user)) {
    //         return $this->dislike($user);
    //     } else {
    //         return $this->like($user);
    //     }
    // }

    //تم الإستغناء عن الدوال الثلاث بسبب استخدام الدالة (toggle) التي توفرها لارافيل
}
