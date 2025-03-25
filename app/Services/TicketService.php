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

    public function create($request)
    {
        $data = $request->all();
        $data['status'] = 'created';
        $data['customer_id'] = $request->user()->id;
        $ticket = Ticket::create($data);
        TicketHistoryFacade::create([
            'ticket_id' => $ticket->id,
            'message' => "ticket was created by {$ticket->customer->email}",
        ]);
        return $ticket;

    }

    public function update(Ticket $ticket,Request $request)
    {

        $ticket->update(['agent_id' => $request->user()->id,'status'=>$request->status]);
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
    public static function myTickets($user){
        $tickets =  $user->customerTickets()->paginate(10);
        $tickets->load('customer', 'agent', 'ticketHistories');
        return $tickets;
    }
    public static function assignedTickets($user){
        $tickets =  $user->agentTickets()->paginate(10);
        $tickets->load('customer', 'agent', 'ticketHistories');
        return $tickets;
    }
}
