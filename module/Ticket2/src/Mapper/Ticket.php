<?php

namespace Ticket2\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

use Zend\Db\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use Zend\Db\Adapter\Adapter;
use CompanyNamespace\Adapter\LowercaseDbSelect;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Mapper
 */
class Ticket extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('Ticket2\\Entity\\Ticket');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {

        $qb = $this->getEntityRepository()->createQueryBuilder('t');
        $sort = ($asc === false) ? 'DESC' : 'ASC';

        // filter by status
        if (isset($params['status'])) {
            $qb->andWhere('t.status = :status')
               ->setParameter('status', $params['status']);
        }
        if (is_null($order)) {
            $qb->orderBy('t.createdAt', $sort);
        } else {
            $qb->orderBy('t.createdAt', $sort);
        }

        $query = $qb->getQuery();
        return $query;
    }
}
