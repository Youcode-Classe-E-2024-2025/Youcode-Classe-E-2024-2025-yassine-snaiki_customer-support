<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;



    public function index(User $user)
    {
        return $user->role==='admin'||$user->role==='agent';
    }
    public function update(User $user)
    {
        return $user->role==='admin'||$user->role==='agent';
    }
    public function destroy(User $user)
    {
        return $user->role==='admin'||$user->role==='agent';
    }

}
