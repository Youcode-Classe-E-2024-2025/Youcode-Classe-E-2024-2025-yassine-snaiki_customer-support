<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TicketHistoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ticketHistory';
    }
}
