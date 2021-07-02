<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'url',
        'satuts'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    //her user birden fazla yorum vardir

    public function comments()
    {
        return $this->hasMany(comment::class)->orderBy('created_at', 'DESC');
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
    }

    public function following(User $user)
    {
        return $this->follows()->where('following_user_id', $user->id)->exists();
    }

    //لكي نتأكد من أن الحساب عام ويستطيع أي شخص الوصول إلى المنشورات
    public function setaccepted(User $user)
    {
        if ($user->status = 'public') {
            DB::table('follows')
                ->where('user_id', $this->id)
                ->where('following_user_id', $user->id)
                ->update([
                    'accepted' => true,
                ]);
        }
    }

    //لكي نقوم باختبار أن المستخدم يقوم بمتابعة أي مستخدم أخرى 
    public function accepted(User $user)
    {
        if ($this->status == 'public') {
            return true;
        } else {
            return (bool) DB::table('follows')
                ->where('user_id', $user->id)
                ->where('following_user_id', $this->id)
                ->where('accepted', true)->count();
        }
    }

    // لكي يتم عرض طلبات المتابعة 
    public function followReq()
    {
        if ($this->status == 'private') {
            return $this->followers()
                ->where('following_user_id', $this->id)
                ->where('accepted', false)
                ->latest()->get();
        }

        return null;
    }

    //لكي نقوم بعرض طلبات المتابعة التي قام المستخدم في إرسالها 
    public function pendingfollowing()
    {
        return $this->follows()
            ->where('user_id', $this->id)
            ->where('accepted', false)
            ->latest()->get();
    }

    //لكي لأ يتم عرض المنشورات في الحسابات الخاصة قبل قبول الطلب 
    public function followingandaccepted(User $user)
    {
        return $this->follows()->where('following_user_id', $user->id)->where('accepted', true)->exists();
    }
    //لكي تقوم بوضع الحالة من الطلبات التي تحتاج إلى قبول أو رفض 

    public function toggleAccept(User $user, $status)
    {
        return DB::table('follows')
            ->where('user_id', $user->id)
            ->where('following_user_id', $this->id)
            ->update([
                'accepted' => $status
            ]);
    }

    //home page postsler gitermek icin

    public function home()
    {
        $ids = $this->follows()->where('accepted', true)->get()->pluck('id');
        return post::whereIn('user_id', $ids)->latest()->get();
    }

    public function iFollow()
    {
        return $this->follows()->where('user_id', $this->id)->where('accepted', true)->latest()->get();
    }

    public function otherusers()
    {
        $ifollow = $this->iFollow()->pluck('id')->toArray();
        $pendingFollow = $this->pendingfollowing()->pluck('id')->toArray();
        array_push($ifollow, $this->id);
        $other = array_merge($ifollow, $pendingFollow);
        return User::whereNoIn('id', $other)->latest()->get();
    }

    public function explore()
    {
        $ifollow = $this->ifollow;
    }
}
