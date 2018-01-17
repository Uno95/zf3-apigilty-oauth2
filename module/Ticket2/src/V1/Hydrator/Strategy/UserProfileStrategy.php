<?php

namespace Ticket2\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use User\Entity\UserProfile;

class UserProfileStrategy implements StrategyInterface
{
    public function extract($value, $object = null)
    {
        if ($value instanceof UserProfile) {
            \Zend\Debug\Debug::dump($value);
            exit;
            // var_dump($value);exit;
            return $value->getFirstName();
        }

        return $value->getFirstName();
    }

    public function hydrate($value, array $data = null)
    {
        // \Zend\Debug\Debug::dump($value);exit;
        return $value;
    }
}
