<?php
namespace Ticket2\V1\Rest\ShowTickets;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Ticket2\Mapper\Ticket as TicketMapper;
use Ticket2\V1\Service\Ticket as TicketService;

class ShowTicketsResource extends AbstractResourceListener
{
    protected $ticketMapper;
    protected $ticketService;

    public function __construct(TicketMapper $ticketMapper, TicketService $ticketService)
    {
        $this->setTicketMapper($ticketMapper);
        $this->setTicketService($ticketService);
        // $this->mapper = $mapper;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = (array) $data;
        // return $this->mapper->getEntityRepository()->create($data);
        // return $this->getTicketMapper()->getEntityRepository()->create($data);
        return $this->getTicketService()->save($data);
        // return new ApiProblem(405, 'sThe POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        // return $this->getTicketMapper();
        // \Zend\Debug\Debug::dump(get_class_methods($this->getTicketMapper()));
        return $this->getTicketMapper()->getEntityRepository()->findAll();
        // return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

    public function getTicketMapper()
    {
        return $this->ticketMapper;
    }

    public function setTicketMapper(TicketMapper $ticketMapper)
    {
        $this->ticketMapper = $ticketMapper;
    }

    public function getTicketService()
    {
        return $this->ticketService;
    }

    public function setTicketService(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }
}
