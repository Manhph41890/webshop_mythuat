<?php

namespace App\Policies;

use App\Models\danh_muc;
use App\Models\User;

class DanhMucPolicy
{
    /**
     * Determine whether the user can view any danh muc.
     */
    public function viewAny(User $user) {}

    /**
     * Determine whether the user can view the danh muc.
     */
    public function view(User $user, danh_muc $danh_muc)
    {
    }

    /**
     * Determine whether the user can create danh muc.
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the danh muc.
     */
    public function update(User $user, danh_muc $danh_muc)
    {
    }

    /**
     * Determine whether the user can delete the danh muc.
     */
    public function delete(User $user, danh_muc $danh_muc)
    {
    }
}
