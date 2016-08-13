<?php

namespace Jay\Bundle\AdminBundle\Model;

use Criteria;
use Jay\Bundle\AdminBundle\Model\om\BaseCompanyPeer;

class CompanyPeer extends BaseCompanyPeer
{
    public static function searchCompanyKey($key, Criteria $c = null)
    {
        if(is_null($c)){
            $c = new Criteria();
        }

        $c->clearSelectColumns()
            ->addSelectColumn(self::COMPANY_KEY)
            ->add(self::COMPANY_KEY, $key, Criteria::EQUAL);

        $count = self::doCount($c);

        return $count;
    }

    public static function searchCompanyByName($name, Criteria $c = null)
    {
        if(is_null($c)){
            $c = new Criteria();
        }

        $c->clearSelectColumns()
            ->setIgnoreCase (true)
            ->add(self::COMPANY_NAME, $name, Criteria::EQUAL);

        $data = self::doSelectOne($c);

        return $data ? $data : array();
    }

    public static function getCompanies(Criteria $c = null)
    {
        if(is_null($c)){
            $c = new Criteria();
            $c->clearSelectColumns();
        }

        $records = self::doSelect($c);

        return $records ? $records : array();

    }

}
