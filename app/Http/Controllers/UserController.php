<?php

namespace App\Http\Controllers;

use App\Facades\UserFacade;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Endpoints for managing users"
 * )
 */
/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="password", type="string", example="secretpassword")
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     summary="List all users",
     *     tags={"Users"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number for pagination",
     *         @OA\Schema(
     *             type="integer",
     *             default=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A paginated list of users",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/User")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $this->authorize('index', User::class);
        $users = UserFacade::getAll();
        return response()->json($users);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get a specific user",
     *     tags={"Users"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show(User $user)
    {
        $this->authorize('index', User::class);
        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Update a user",
     *     tags={"Users"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="User object with updated information",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="newpassword")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('index', User::class);
        $data = $request->validate([
            'name' => 'string',
            'email' => 'email',
            'password' => 'string|min:6',
            'role' => 'string',
        ]);


        UserFacade::update($user, $data);
        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function destroy(User $user)
    {
        $this->authorize('index', User::class);
        UserFacade::delete($user);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
