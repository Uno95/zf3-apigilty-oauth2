<?php

namespace Ticket2\V1\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use User\Entity\UserProfile as UserProfile;

class UserProfileStrategy implements StrategyInterface
{
    public function extract($value, $object = null)
    {
        if ($value instanceof UserProfile) {
            return $value->getFirstName();
        }

        return null;
    }

    public function hydrate($value, array $data = null)
    {
        return $value;
    }
}
