<?php

namespace App\Http\Controllers;


/**
 * @OA\Info(
 *     title="customer support API",
 *     version="1.0.0",
 *     description="API documentation for the Customer Support System",
 * )
 *
 * @OA\Server(
 *     url="http://customer-support.test/api",
 *     description="Local API Server"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints related to user authentication (login, register, logout)"
 * )
 *
 * @OA\Tag(
 *     name="tickets",
 *     description="Endpoints for managing tickets (CRUD)"
 * )
 *
 * @OA\Tag(
 *     name="TicketHistories",
 *     description="Endpoints for histories"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Use this to authenticate with Sanctum."
 * )
 */

abstract class Controller
{
    //
}
