<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    /** @use HasFactory<\Database\Factories\TicketHistoryFactory> */
    use HasFactory;
    protected $fillable = ['ticket_id', 'message', 'created_at'];

    // Relationships
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
