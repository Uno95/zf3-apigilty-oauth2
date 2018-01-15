<?php
namespace Ticket2\V1\Rest\ShowTickets;

use Zend\Db\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use Zend\Db\Adapter\Adapter;
use CompanyNamespace\Adapter\LowercaseDbSelect;

class ShowTicketsMapper
{

    protected $db;
    protected $table;

    public function __construct(Adapter $db)
    {
        $this->db = $db;
        $this->table = new \Zend\Db\Sql\TableIdentifier('ticket', 'zf3_apigility');
    }

    public function fetchAll()
    {
        // \Zend\Debug\Debug::dump(get_class_methods($this->table));exit;);
        $select = new Select($this->table);
        $paginatorAdapter = new LowercaseDbSelect($select, $this->db);
        // \Zend\Debug\Debug::dump($paginatorAdapter);exit;
        $collection = new ShowTicketsCollection($paginatorAdapter);
        return $collection;
    }
}
