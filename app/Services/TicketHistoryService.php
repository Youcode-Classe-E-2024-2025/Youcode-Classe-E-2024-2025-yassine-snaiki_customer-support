<?php


namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketHistory;
use Illuminate\Http\Request;

class TicketHistoryService
{
    public function getAll()
    {
        return TicketHistory::with('ticket')->paginate(10);
    }

    public function create($data)
    {
        return TicketHistory::create($data);
    }

    public function update(TicketHistory $ticketHistory, $data)
    {
        $ticketHistory->update($data);
        return $ticketHistory;
    }

    public function delete(TicketHistory $ticketHistory)
    {
        $ticketHistory->delete();
        return ['message' => 'Ticket deleted successfully'];
    }
}
