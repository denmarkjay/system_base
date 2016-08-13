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
use Jay\Bundle\AdminBundle\Model\User;
use Jay\Bundle\AdminBundle\Model\UserLevel;
use Jay\Bundle\AdminBundle\Model\UserLevelPeer;
use Jay\Bundle\AdminBundle\Model\UserLevelQuery;

/**
 * @method UserLevelQuery orderByUlId($order = Criteria::ASC) Order by the ul_id column
 * @method UserLevelQuery orderByUlRole($order = Criteria::ASC) Order by the ul_role column
 * @method UserLevelQuery orderByUlName($order = Criteria::ASC) Order by the ul_name column
 * @method UserLevelQuery orderByUlStatus($order = Criteria::ASC) Order by the ul_status column
 * @method UserLevelQuery orderByUlAddedBy($order = Criteria::ASC) Order by the ul_added_by column
 * @method UserLevelQuery orderByUlDateAdded($order = Criteria::ASC) Order by the ul_date_added column
 *
 * @method UserLevelQuery groupByUlId() Group by the ul_id column
 * @method UserLevelQuery groupByUlRole() Group by the ul_role column
 * @method UserLevelQuery groupByUlName() Group by the ul_name column
 * @method UserLevelQuery groupByUlStatus() Group by the ul_status column
 * @method UserLevelQuery groupByUlAddedBy() Group by the ul_added_by column
 * @method UserLevelQuery groupByUlDateAdded() Group by the ul_date_added column
 *
 * @method UserLevelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UserLevelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UserLevelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UserLevelQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method UserLevelQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method UserLevelQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method UserLevel findOne(PropelPDO $con = null) Return the first UserLevel matching the query
 * @method UserLevel findOneOrCreate(PropelPDO $con = null) Return the first UserLevel matching the query, or a new UserLevel object populated from the query conditions when no match is found
 *
 * @method UserLevel findOneByUlRole(string $ul_role) Return the first UserLevel filtered by the ul_role column
 * @method UserLevel findOneByUlName(string $ul_name) Return the first UserLevel filtered by the ul_name column
 * @method UserLevel findOneByUlStatus(string $ul_status) Return the first UserLevel filtered by the ul_status column
 * @method UserLevel findOneByUlAddedBy(int $ul_added_by) Return the first UserLevel filtered by the ul_added_by column
 * @method UserLevel findOneByUlDateAdded(string $ul_date_added) Return the first UserLevel filtered by the ul_date_added column
 *
 * @method array findByUlId(int $ul_id) Return UserLevel objects filtered by the ul_id column
 * @method array findByUlRole(string $ul_role) Return UserLevel objects filtered by the ul_role column
 * @method array findByUlName(string $ul_name) Return UserLevel objects filtered by the ul_name column
 * @method array findByUlStatus(string $ul_status) Return UserLevel objects filtered by the ul_status column
 * @method array findByUlAddedBy(int $ul_added_by) Return UserLevel objects filtered by the ul_added_by column
 * @method array findByUlDateAdded(string $ul_date_added) Return UserLevel objects filtered by the ul_date_added column
 */
abstract class BaseUserLevelQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUserLevelQuery object.
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
            $modelName = 'Jay\\Bundle\\AdminBundle\\Model\\UserLevel';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserLevelQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UserLevelQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UserLevelQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserLevelQuery) {
            return $criteria;
        }
        $query = new UserLevelQuery(null, null, $modelAlias);

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
     * @return   UserLevel|UserLevel[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserLevelPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UserLevelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 UserLevel A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByUlId($key, $con = null)
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
     * @return                 UserLevel A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ul_id`, `ul_role`, `ul_name`, `ul_status`, `ul_added_by`, `ul_date_added` FROM `user_level` WHERE `ul_id` = :p0';
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
            $obj = new UserLevel();
            $obj->hydrate($row);
            UserLevelPeer::addInstanceToPool($obj, (string) $key);
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
     * @return UserLevel|UserLevel[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|UserLevel[]|mixed the list of results, formatted by the current formatter
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
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserLevelPeer::UL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserLevelPeer::UL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ul_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUlId(1234); // WHERE ul_id = 1234
     * $query->filterByUlId(array(12, 34)); // WHERE ul_id IN (12, 34)
     * $query->filterByUlId(array('min' => 12)); // WHERE ul_id >= 12
     * $query->filterByUlId(array('max' => 12)); // WHERE ul_id <= 12
     * </code>
     *
     * @param     mixed $ulId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByUlId($ulId = null, $comparison = null)
    {
        if (is_array($ulId)) {
            $useMinMax = false;
            if (isset($ulId['min'])) {
                $this->addUsingAlias(UserLevelPeer::UL_ID, $ulId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ulId['max'])) {
                $this->addUsingAlias(UserLevelPeer::UL_ID, $ulId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLevelPeer::UL_ID, $ulId, $comparison);
    }

    /**
     * Filter the query on the ul_role column
     *
     * Example usage:
     * <code>
     * $query->filterByUlRole('fooValue');   // WHERE ul_role = 'fooValue'
     * $query->filterByUlRole('%fooValue%'); // WHERE ul_role LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ulRole The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByUlRole($ulRole = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ulRole)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ulRole)) {
                $ulRole = str_replace('*', '%', $ulRole);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserLevelPeer::UL_ROLE, $ulRole, $comparison);
    }

    /**
     * Filter the query on the ul_name column
     *
     * Example usage:
     * <code>
     * $query->filterByUlName('fooValue');   // WHERE ul_name = 'fooValue'
     * $query->filterByUlName('%fooValue%'); // WHERE ul_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ulName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByUlName($ulName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ulName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ulName)) {
                $ulName = str_replace('*', '%', $ulName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserLevelPeer::UL_NAME, $ulName, $comparison);
    }

    /**
     * Filter the query on the ul_status column
     *
     * Example usage:
     * <code>
     * $query->filterByUlStatus('fooValue');   // WHERE ul_status = 'fooValue'
     * $query->filterByUlStatus('%fooValue%'); // WHERE ul_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ulStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByUlStatus($ulStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ulStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ulStatus)) {
                $ulStatus = str_replace('*', '%', $ulStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserLevelPeer::UL_STATUS, $ulStatus, $comparison);
    }

    /**
     * Filter the query on the ul_added_by column
     *
     * Example usage:
     * <code>
     * $query->filterByUlAddedBy(1234); // WHERE ul_added_by = 1234
     * $query->filterByUlAddedBy(array(12, 34)); // WHERE ul_added_by IN (12, 34)
     * $query->filterByUlAddedBy(array('min' => 12)); // WHERE ul_added_by >= 12
     * $query->filterByUlAddedBy(array('max' => 12)); // WHERE ul_added_by <= 12
     * </code>
     *
     * @param     mixed $ulAddedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByUlAddedBy($ulAddedBy = null, $comparison = null)
    {
        if (is_array($ulAddedBy)) {
            $useMinMax = false;
            if (isset($ulAddedBy['min'])) {
                $this->addUsingAlias(UserLevelPeer::UL_ADDED_BY, $ulAddedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ulAddedBy['max'])) {
                $this->addUsingAlias(UserLevelPeer::UL_ADDED_BY, $ulAddedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLevelPeer::UL_ADDED_BY, $ulAddedBy, $comparison);
    }

    /**
     * Filter the query on the ul_date_added column
     *
     * Example usage:
     * <code>
     * $query->filterByUlDateAdded('2011-03-14'); // WHERE ul_date_added = '2011-03-14'
     * $query->filterByUlDateAdded('now'); // WHERE ul_date_added = '2011-03-14'
     * $query->filterByUlDateAdded(array('max' => 'yesterday')); // WHERE ul_date_added < '2011-03-13'
     * </code>
     *
     * @param     mixed $ulDateAdded The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function filterByUlDateAdded($ulDateAdded = null, $comparison = null)
    {
        if (is_array($ulDateAdded)) {
            $useMinMax = false;
            if (isset($ulDateAdded['min'])) {
                $this->addUsingAlias(UserLevelPeer::UL_DATE_ADDED, $ulDateAdded['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ulDateAdded['max'])) {
                $this->addUsingAlias(UserLevelPeer::UL_DATE_ADDED, $ulDateAdded['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLevelPeer::UL_DATE_ADDED, $ulDateAdded, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserLevelQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(UserLevelPeer::UL_ROLE, $user->getUserRole(), $comparison);
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
     * @return UserLevelQuery The current query, for fluid interface
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
     * @param   UserLevel $userLevel Object to remove from the list of results
     *
     * @return UserLevelQuery The current query, for fluid interface
     */
    public function prune($userLevel = null)
    {
        if ($userLevel) {
            $this->addUsingAlias(UserLevelPeer::UL_ID, $userLevel->getUlId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
