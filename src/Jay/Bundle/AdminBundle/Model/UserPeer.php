<?php

namespace Jay\Bundle\AdminBundle\Model;

use Criteria;
use Jay\Bundle\AdminBundle\Model\om\BaseUserPeer;

class UserPeer extends BaseUserPeer
{

    /**
     * @description Count user by user level
     * @param(integer, object)
     * @useType(0=>"super admin")
     * @return integer
     */
    static public function countUserByLevel ($uType, Criteria $c  = null)
    {
        $c = is_null($c) ? new Criteria() : $c;

        $c->clearSelectColumns()
            ->addSelectColumn(self::USER_ID)
            ->add(self::USER_ROLE, $uType, Criteria::EQUAL)
        ;

        $count = self::doCountJoinUserLevel($c);

        return $count;
    }

    static public function loginUserRecord($user, $password, Criteria $c = null)
    {
        $c = is_null($c) ? new Criteria() : $c;

        $cton1 = $c->getNewCriterion(self::USER_LOGIN, $user);
        $cton2 = $c->getNewCriterion(self::USER_EMAIL, $user, Criteria::EQUAL);
        $cton1->addOr($cton2);

        $c->add($cton1);
        $c->add(self::USER_PASSWORD, $password, Criteria::EQUAL);

        $data = self::doSelectOne($c);

        return $data ? $data : array();

    }

    static public function getUserById($id, Criteria $c  = null)
    {
        $c = is_null($c) ? new Criteria() : $c;
        $c->add(self::USER_ID, $id, Criteria::EQUAL);
        $stmt = self::doSelectOne($c);

        return $stmt ? $stmt : array();
    }
}
