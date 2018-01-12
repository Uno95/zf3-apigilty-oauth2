<?php
namespace Ticket2\V1\Rest\ShowTickets;

class ShowTicketsResourceFactory
{
    public function __invoke($services)
    {
        $mapper = $services->get('ticket.showTickets');
        return new ShowTicketsResource($mapper);
        // return new ShowTicketsResource($services->get(Mapper::class));
    }
}
