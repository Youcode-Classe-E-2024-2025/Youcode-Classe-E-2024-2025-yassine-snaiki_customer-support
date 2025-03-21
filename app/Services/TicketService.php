<?php


namespace App\Services;

use App\Facades\TicketHistoryFacade;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketService
{
    public function getAll()
    {
        return Ticket::with('customer', 'agent','ticketHistories')->paginate(10);
    }

    public function create($data)
    {
        $ticket = Ticket::create($data);
        TicketHistoryFacade::create([
            'ticket_id' => $ticket->id,
            'message' => "ticket was created by {$ticket->customer->email}",
        ]);
        return $ticket;

    }

    public function update(Ticket $ticket, $data)
    {
        $ticket->update($data);
        TicketHistoryFacade::create([
            'ticket_id' => $ticket->id,
            'message' => "{$ticket->customer->email} ticket was $ticket->status by {$ticket->agent->email}",
        ]);
        return $ticket;
    }

    public function delete(Ticket $ticket)
    {
        $ticket->delete();
        return ['message' => 'Ticket deleted successfully'];
    }
    protected static function myTickets($user){
        $tickets =  $user->tickets()->paginate(10);
        $tickets->load('customer', 'agent', 'ticketHistories');
        return $tickets;
    }
}
