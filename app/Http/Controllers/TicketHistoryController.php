<?php

namespace App\Http\Controllers;

use App\Models\TicketHistory;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="TicketHistories",
 *     description="Endpoints for managing ticket histories"
 * )
 */
/**
 * @OA\Schema(
 *     schema="TicketHistory",
 *     type="object",
 *     required={"ticket_id", "message"},
 *     @OA\Property(property="ticket_id", type="integer", example=1),
 *     @OA\Property(property="message", type="string", example="Ticket created and assigned to agent")
 * )
 */
class TicketHistoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/ticket-histories",
     *     summary="List all ticket histories",
     *     tags={"TicketHistories"},
     *     @OA\Response(
     *         response=200,
     *         description="A paginated list of ticket histories",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/TicketHistory")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(TicketHistory::paginate(10));
    }

    /**
     * @OA\Post(
     *     path="/ticket-histories",
     *     summary="Create a new ticket history",
     *     tags={"TicketHistories"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Ticket history object that needs to be added",
     *         @OA\JsonContent(
     *             required={"ticket_id", "message"},
     *             @OA\Property(property="ticket_id", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Ticket created and assigned to agent")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket history created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TicketHistory")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_id' => 'required|integer',
            'message' => 'required|string',
        ]);
        $ticketHistory = TicketHistory::create($data);
        return response()->json($ticketHistory);
    }

    /**
     * @OA\Get(
     *     path="/ticket-histories/{id}",
     *     summary="Get a specific ticket history",
     *     tags={"TicketHistories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the ticket history to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket history retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TicketHistory")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket history not found"
     *     )
     * )
     */
    public function show(TicketHistory $ticketHistory)
    {
        return response()->json($ticketHistory);
    }

    /**
     * @OA\Delete(
     *     path="/ticket-histories/{id}",
     *     summary="Delete a ticket history",
     *     tags={"TicketHistories"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the ticket history to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket history deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ticket history deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket history not found"
     *     )
     * )
     */
    public function destroy(TicketHistory $ticketHistory)
    {
        $ticketHistory->delete();
        return response()->json(['message' => 'Ticket history deleted successfully']);
    }
}
