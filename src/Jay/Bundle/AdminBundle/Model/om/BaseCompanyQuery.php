<?php

namespace Jay\Bundle\AdminBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Jay\Bundle\AdminBundle\Model\Company;
use Jay\Bundle\AdminBundle\Model\CompanyPeer;
use Jay\Bundle\AdminBundle\Model\CompanyQuery;
use Jay\Bundle\AdminBundle\Model\User;

/**
 * @method CompanyQuery orderByCompanyId($order = Criteria::ASC) Order by the company_id column
 * @method CompanyQuery orderByCompanyKey($order = Criteria::ASC) Order by the company_key column
 * @method CompanyQuery orderByCompanyName($order = Criteria::ASC) Order by the company_name column
 * @method CompanyQuery orderByCompanyEmail($order = Criteria::ASC) Order by the company_email column
 * @method CompanyQuery orderByCompanyAddress($order = Criteria::ASC) Order by the company_address column
 * @method CompanyQuery orderByCompanyStatus($order = Criteria::ASC) Order by the company_status column
 * @method CompanyQuery orderByCompanyAddedBy($order = Criteria::ASC) Order by the company_added_by column
 * @method CompanyQuery orderByCompanyDateAdded($order = Criteria::ASC) Order by the company_date_added column
 *
 * @method CompanyQuery groupByCompanyId() Group by the company_id column
 * @method CompanyQuery groupByCompanyKey() Group by the company_key column
 * @method CompanyQuery groupByCompanyName() Group by the company_name column
 * @method CompanyQuery groupByCompanyEmail() Group by the company_email column
 * @method CompanyQuery groupByCompanyAddress() Group by the company_address column
 * @method CompanyQuery groupByCompanyStatus() Group by the company_status column
 * @method CompanyQuery groupByCompanyAddedBy() Group by the company_added_by column
 * @method CompanyQuery groupByCompanyDateAdded() Group by the company_date_added column
 *
 * @method CompanyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CompanyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CompanyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CompanyQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method CompanyQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method CompanyQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method Company findOne(PropelPDO $con = null) Return the first Company matching the query
 * @method Company findOneOrCreate(PropelPDO $con = null) Return the first Company matching the query, or a new Company object populated from the query conditions when no match is found
 *
 * @method Company findOneByCompanyKey(string $company_key) Return the first Company filtered by the company_key column
 * @method Company findOneByCompanyName(string $company_name) Return the first Company filtered by the company_name column
 * @method Company findOneByCompanyEmail(string $company_email) Return the first Company filtered by the company_email column
 * @method Company findOneByCompanyAddress(string $company_address) Return the first Company filtered by the company_address column
 * @method Company findOneByCompanyStatus(string $company_status) Return the first Company filtered by the company_status column
 * @method Company findOneByCompanyAddedBy(int $company_added_by) Return the first Company filtered by the company_added_by column
 * @method Company findOneByCompanyDateAdded(string $company_date_added) Return the first Company filtered by the company_date_added column
 *
 * @method array findByCompanyId(int $company_id) Return Company objects filtered by the company_id column
 * @method array findByCompanyKey(string $company_key) Return Company objects filtered by the company_key column
 * @method array findByCompanyName(string $company_name) Return Company objects filtered by the company_name column
 * @method array findByCompanyEmail(string $company_email) Return Company objects filtered by the company_email column
 * @method array findByCompanyAddress(string $company_address) Return Company objects filtered by the company_address column
 * @method array findByCompanyStatus(string $company_status) Return Company objects filtered by the company_status column
 * @method array findByCompanyAddedBy(int $company_added_by) Return Company objects filtered by the company_added_by column
 * @method array findByCompanyDateAdded(string $company_date_added) Return Company objects filtered by the company_date_added column
 */
abstract class BaseCompanyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCompanyQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Jay\\Bundle\\AdminBundle\\Model\\Company';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CompanyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CompanyQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CompanyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CompanyQuery) {
            return $criteria;
        }
        $query = new CompanyQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Company|Company[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompanyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CompanyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Company A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCompanyId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Company A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `company_id`, `company_key`, `company_name`, `company_email`, `company_address`, `company_status`, `company_added_by`, `company_date_added` FROM `company` WHERE `company_id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Company();
            $obj->hydrate($row);
            CompanyPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Company|Company[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Company[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompanyPeer::COMPANY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompanyPeer::COMPANY_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the company_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyId(1234); // WHERE company_id = 1234
     * $query->filterByCompanyId(array(12, 34)); // WHERE company_id IN (12, 34)
     * $query->filterByCompanyId(array('min' => 12)); // WHERE company_id >= 12
     * $query->filterByCompanyId(array('max' => 12)); // WHERE company_id <= 12
     * </code>
     *
     * @param     mixed $companyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyId($companyId = null, $comparison = null)
    {
        if (is_array($companyId)) {
            $useMinMax = false;
            if (isset($companyId['min'])) {
                $this->addUsingAlias(CompanyPeer::COMPANY_ID, $companyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($companyId['max'])) {
                $this->addUsingAlias(CompanyPeer::COMPANY_ID, $companyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_ID, $companyId, $comparison);
    }

    /**
     * Filter the query on the company_key column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyKey('fooValue');   // WHERE company_key = 'fooValue'
     * $query->filterByCompanyKey('%fooValue%'); // WHERE company_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyKey($companyKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyKey)) {
                $companyKey = str_replace('*', '%', $companyKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_KEY, $companyKey, $comparison);
    }

    /**
     * Filter the query on the company_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyName('fooValue');   // WHERE company_name = 'fooValue'
     * $query->filterByCompanyName('%fooValue%'); // WHERE company_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyName($companyName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyName)) {
                $companyName = str_replace('*', '%', $companyName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_NAME, $companyName, $comparison);
    }

    /**
     * Filter the query on the company_email column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyEmail('fooValue');   // WHERE company_email = 'fooValue'
     * $query->filterByCompanyEmail('%fooValue%'); // WHERE company_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyEmail($companyEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyEmail)) {
                $companyEmail = str_replace('*', '%', $companyEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_EMAIL, $companyEmail, $comparison);
    }

    /**
     * Filter the query on the company_address column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyAddress('fooValue');   // WHERE company_address = 'fooValue'
     * $query->filterByCompanyAddress('%fooValue%'); // WHERE company_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyAddress($companyAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyAddress)) {
                $companyAddress = str_replace('*', '%', $companyAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_ADDRESS, $companyAddress, $comparison);
    }

    /**
     * Filter the query on the company_status column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyStatus('fooValue');   // WHERE company_status = 'fooValue'
     * $query->filterByCompanyStatus('%fooValue%'); // WHERE company_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyStatus($companyStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyStatus)) {
                $companyStatus = str_replace('*', '%', $companyStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_STATUS, $companyStatus, $comparison);
    }

    /**
     * Filter the query on the company_added_by column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyAddedBy(1234); // WHERE company_added_by = 1234
     * $query->filterByCompanyAddedBy(array(12, 34)); // WHERE company_added_by IN (12, 34)
     * $query->filterByCompanyAddedBy(array('min' => 12)); // WHERE company_added_by >= 12
     * $query->filterByCompanyAddedBy(array('max' => 12)); // WHERE company_added_by <= 12
     * </code>
     *
     * @param     mixed $companyAddedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyAddedBy($companyAddedBy = null, $comparison = null)
    {
        if (is_array($companyAddedBy)) {
            $useMinMax = false;
            if (isset($companyAddedBy['min'])) {
                $this->addUsingAlias(CompanyPeer::COMPANY_ADDED_BY, $companyAddedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($companyAddedBy['max'])) {
                $this->addUsingAlias(CompanyPeer::COMPANY_ADDED_BY, $companyAddedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_ADDED_BY, $companyAddedBy, $comparison);
    }

    /**
     * Filter the query on the company_date_added column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyDateAdded('2011-03-14'); // WHERE company_date_added = '2011-03-14'
     * $query->filterByCompanyDateAdded('now'); // WHERE company_date_added = '2011-03-14'
     * $query->filterByCompanyDateAdded(array('max' => 'yesterday')); // WHERE company_date_added < '2011-03-13'
     * </code>
     *
     * @param     mixed $companyDateAdded The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function filterByCompanyDateAdded($companyDateAdded = null, $comparison = null)
    {
        if (is_array($companyDateAdded)) {
            $useMinMax = false;
            if (isset($companyDateAdded['min'])) {
                $this->addUsingAlias(CompanyPeer::COMPANY_DATE_ADDED, $companyDateAdded['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($companyDateAdded['max'])) {
                $this->addUsingAlias(CompanyPeer::COMPANY_DATE_ADDED, $companyDateAdded['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompanyPeer::COMPANY_DATE_ADDED, $companyDateAdded, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CompanyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(CompanyPeer::COMPANY_KEY, $user->getUserCompanyKey(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            return $this
                ->useUserQuery()
                ->filterByPrimaryKeys($user->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Jay\Bundle\AdminBundle\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Jay\Bundle\AdminBundle\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Company $company Object to remove from the list of results
     *
     * @return CompanyQuery The current query, for fluid interface
     */
    public function prune($company = null)
    {
        if ($company) {
            $this->addUsingAlias(CompanyPeer::COMPANY_ID, $company->getCompanyId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
