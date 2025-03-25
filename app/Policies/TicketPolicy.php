<?php
namespace App\Policies;

use App\Models\Ticket;
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
    public function myTickets(User $user){
        return $user->role==='customer';
    }
    public function assignedTickets(User $user){
        return $user->role==='agent';
    }
    public function view(User $user ,Ticket $ticket){
        return $user->role==='admin'||$user->role==='agent'||$user->id==$ticket->customer_id;
    }

}
