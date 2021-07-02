<?php

namespace App\Policies;

use App\Models\User;
use App\Models\comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class commentpolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\comment  $comment
     * @return mixed
     */
    public function view(User $user, comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\comment  $comment
     * @return mixed
     */
    public function update(User $user, comment $comment)
    {
        return $user->id === $comment->user_id ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\comment  $comment
     * @return mixed
     */
    public function delete(User $user, comment $comment)
    {
        return $user->id === $comment->user_id || $user->id === $comment->post()->first()->user_id ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\comment  $comment
     * @return mixed
     */
    public function restore(User $user, comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\comment  $comment
     * @return mixed
     */
    public function forceDelete(User $user, comment $comment)
    {
        //
    }
}
