<?php
namespace App\Http\Controllers;

use App\Facades\TicketFacade;
use App\Models\Ticket;
use Illuminate\Http\Request;


/**
 * @OA\Tag(
 *     name="Tickets",
 *     description="Endpoints for managing tickets"
 * )
 */
/**
 * @OA\Schema(
 *     schema="Ticket",
 *     type="object",
 *     required={"customer_id", "title", "description", "status"},
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="agent_id", type="integer", example=2),
 *     @OA\Property(property="title", type="string", example="Issue with login"),
 *     @OA\Property(property="description", type="string", example="Unable to log in with valid credentials"),
 *     @OA\Property(property="status", type="string", enum={"open", "closed"}, example="open")
 * )
 */
class TicketController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tickets",
     *     summary="List all tickets",
     *     tags={"Tickets"},
     * @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number for pagination",
     *         @OA\Schema(
     *             type="integer",
     *             default=1
     *         )
     *     ),
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A paginated list of tickets",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Ticket")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $this->authorize('index', Ticket::class);
        $tickets = TicketFacade::getAll();
        return response()->json($tickets);
    }

    public function myTickets($request){
        $this->authorize('myTickets', Ticket::class);
        $tickets = TicketFacade::myTickets($request->user());
        return response()->json($tickets);
    }

    /**
     * @OA\Post(
     *     path="/tickets",
     *     summary="Create a new ticket",
     *     tags={"Tickets"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Ticket object that needs to be added",
     *         @OA\JsonContent(
     *             required={"customer_id", "title", "description", "status"},
     *             @OA\Property(property="customer_id", type="integer", example=1),
     *             @OA\Property(property="agent_id", type="integer", example=2),
     *             @OA\Property(property="title", type="string", example="Issue with login"),
     *             @OA\Property(property="description", type="string", example="Unable to log in with valid credentials"),
     *             @OA\Property(property="status", type="string", enum={"open", "closed"}, example="open")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
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
            'customer_id' => 'required|integer',
            'agent_id' => 'nullable|integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:created,open,closed',
        ]);
        $ticket = TicketFacade::create($data);
        return response()->json($ticket);
    }

    /**
     * @OA\Get(
     *     path="/tickets/{id}",
     *     summary="Get a specific ticket",
     *     tags={"Tickets"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the ticket to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */
    public function show(?Ticket $ticket)
    {
        $ticket->load('customer', 'agent', 'ticketHistories');
        return response()->json($ticket);
    }

    /**
     * @OA\Put(
     *     path="/tickets/{id}",
     *     summary="Update a ticket",
     *     tags={"Tickets"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the ticket to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Ticket object with updated information",
     *         @OA\JsonContent(
     *             required={"agent_id", "status"},
     *             @OA\Property(property="agent_id", type="integer", example=2),
     *             @OA\Property(property="status", type="string", enum={"open", "closed"}, example="open")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $data = $request->validate([
            'agent_id' => 'nullable|integer',
            'status' => 'required|in:open,closed',
        ]);
        TicketFacade::update($ticket, $data);
        return response()->json($ticket);
    }

    /**
     * @OA\Delete(
     *     path="/tickets/{id}",
     *     summary="Delete a ticket",
     *     tags={"Tickets"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the ticket to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ticket deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('destroy', $ticket);
        TicketFacade::delete($ticket);
        return response()->json(['message' => 'Ticket deleted successfully']);
    }
}

