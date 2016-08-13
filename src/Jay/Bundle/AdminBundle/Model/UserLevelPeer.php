<?php

namespace Jay\Bundle\AdminBundle\Model;

use Criteria;
use Jay\Bundle\AdminBundle\Model\om\BaseUserLevelPeer;

class UserLevelPeer extends BaseUserLevelPeer
{
    static public function countUserLevel( $role = null, Criteria $c = null)
    {
        $c = is_null($c) ? new Criteria() : $c;

        if(! empty($role))
            $c->add(self::UL_ROLE, $role, Criteria::EQUAL);

        $count = self::doCount($c);

        return $count;
    }

    static public function fetchUserLevel( $role = null, Criteria $c = null)
    {
        $c = is_null($c) ? new Criteria() : $c;

        if(! empty($role))
            $c->add(self::UL_ROLE, $role, Criteria::EQUAL);


        $data = self::doSelectOne($c);

        return $data ? $data : array();
    }
}
