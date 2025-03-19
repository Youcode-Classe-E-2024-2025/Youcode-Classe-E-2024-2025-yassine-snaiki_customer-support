<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    /** @use HasFactory<\Database\Factories\AgentFactory> */
    use HasFactory;
    protected $fillable = ['name', 'email', 'password'];

    // Relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
