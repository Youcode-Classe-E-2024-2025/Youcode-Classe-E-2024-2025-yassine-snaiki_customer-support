<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    protected $fillable = [
        'customer_id', 'agent_id', 'title', 'description', 'status'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class);
    }
    public function ticketHistories() {
        return $this->hasMany(TicketHistory::class);
    }

}
