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
use Jay\Bundle\AdminBundle\Model\UserLogin;
use Jay\Bundle\AdminBundle\Model\UserLoginPeer;
use Jay\Bundle\AdminBundle\Model\UserLoginQuery;

/**
 * @method UserLoginQuery orderByUserlogId($order = Criteria::ASC) Order by the userlog_id column
 * @method UserLoginQuery orderByUserlogUid($order = Criteria::ASC) Order by the userlog_uid column
 * @method UserLoginQuery orderByUserlogDate($order = Criteria::ASC) Order by the userlog_date column
 * @method UserLoginQuery orderByUserlogIp($order = Criteria::ASC) Order by the userlog_ip column
 *
 * @method UserLoginQuery groupByUserlogId() Group by the userlog_id column
 * @method UserLoginQuery groupByUserlogUid() Group by the userlog_uid column
 * @method UserLoginQuery groupByUserlogDate() Group by the userlog_date column
 * @method UserLoginQuery groupByUserlogIp() Group by the userlog_ip column
 *
 * @method UserLoginQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UserLoginQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UserLoginQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UserLoginQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method UserLoginQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method UserLoginQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method UserLogin findOne(PropelPDO $con = null) Return the first UserLogin matching the query
 * @method UserLogin findOneOrCreate(PropelPDO $con = null) Return the first UserLogin matching the query, or a new UserLogin object populated from the query conditions when no match is found
 *
 * @method UserLogin findOneByUserlogUid(int $userlog_uid) Return the first UserLogin filtered by the userlog_uid column
 * @method UserLogin findOneByUserlogDate(string $userlog_date) Return the first UserLogin filtered by the userlog_date column
 * @method UserLogin findOneByUserlogIp(string $userlog_ip) Return the first UserLogin filtered by the userlog_ip column
 *
 * @method array findByUserlogId(int $userlog_id) Return UserLogin objects filtered by the userlog_id column
 * @method array findByUserlogUid(int $userlog_uid) Return UserLogin objects filtered by the userlog_uid column
 * @method array findByUserlogDate(string $userlog_date) Return UserLogin objects filtered by the userlog_date column
 * @method array findByUserlogIp(string $userlog_ip) Return UserLogin objects filtered by the userlog_ip column
 */
abstract class BaseUserLoginQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUserLoginQuery object.
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
            $modelName = 'Jay\\Bundle\\AdminBundle\\Model\\UserLogin';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserLoginQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UserLoginQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UserLoginQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserLoginQuery) {
            return $criteria;
        }
        $query = new UserLoginQuery(null, null, $modelAlias);

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
     * @return   UserLogin|UserLogin[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserLoginPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UserLoginPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 UserLogin A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByUserlogId($key, $con = null)
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
     * @return                 UserLogin A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `userlog_id`, `userlog_uid`, `userlog_date`, `userlog_ip` FROM `user_login` WHERE `userlog_id` = :p0';
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
            $obj = new UserLogin();
            $obj->hydrate($row);
            UserLoginPeer::addInstanceToPool($obj, (string) $key);
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
     * @return UserLogin|UserLogin[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|UserLogin[]|mixed the list of results, formatted by the current formatter
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
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserLoginPeer::USERLOG_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserLoginPeer::USERLOG_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the userlog_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserlogId(1234); // WHERE userlog_id = 1234
     * $query->filterByUserlogId(array(12, 34)); // WHERE userlog_id IN (12, 34)
     * $query->filterByUserlogId(array('min' => 12)); // WHERE userlog_id >= 12
     * $query->filterByUserlogId(array('max' => 12)); // WHERE userlog_id <= 12
     * </code>
     *
     * @param     mixed $userlogId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function filterByUserlogId($userlogId = null, $comparison = null)
    {
        if (is_array($userlogId)) {
            $useMinMax = false;
            if (isset($userlogId['min'])) {
                $this->addUsingAlias(UserLoginPeer::USERLOG_ID, $userlogId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userlogId['max'])) {
                $this->addUsingAlias(UserLoginPeer::USERLOG_ID, $userlogId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginPeer::USERLOG_ID, $userlogId, $comparison);
    }

    /**
     * Filter the query on the userlog_uid column
     *
     * Example usage:
     * <code>
     * $query->filterByUserlogUid(1234); // WHERE userlog_uid = 1234
     * $query->filterByUserlogUid(array(12, 34)); // WHERE userlog_uid IN (12, 34)
     * $query->filterByUserlogUid(array('min' => 12)); // WHERE userlog_uid >= 12
     * $query->filterByUserlogUid(array('max' => 12)); // WHERE userlog_uid <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userlogUid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function filterByUserlogUid($userlogUid = null, $comparison = null)
    {
        if (is_array($userlogUid)) {
            $useMinMax = false;
            if (isset($userlogUid['min'])) {
                $this->addUsingAlias(UserLoginPeer::USERLOG_UID, $userlogUid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userlogUid['max'])) {
                $this->addUsingAlias(UserLoginPeer::USERLOG_UID, $userlogUid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginPeer::USERLOG_UID, $userlogUid, $comparison);
    }

    /**
     * Filter the query on the userlog_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUserlogDate('2011-03-14'); // WHERE userlog_date = '2011-03-14'
     * $query->filterByUserlogDate('now'); // WHERE userlog_date = '2011-03-14'
     * $query->filterByUserlogDate(array('max' => 'yesterday')); // WHERE userlog_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $userlogDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function filterByUserlogDate($userlogDate = null, $comparison = null)
    {
        if (is_array($userlogDate)) {
            $useMinMax = false;
            if (isset($userlogDate['min'])) {
                $this->addUsingAlias(UserLoginPeer::USERLOG_DATE, $userlogDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userlogDate['max'])) {
                $this->addUsingAlias(UserLoginPeer::USERLOG_DATE, $userlogDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginPeer::USERLOG_DATE, $userlogDate, $comparison);
    }

    /**
     * Filter the query on the userlog_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByUserlogIp('fooValue');   // WHERE userlog_ip = 'fooValue'
     * $query->filterByUserlogIp('%fooValue%'); // WHERE userlog_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userlogIp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function filterByUserlogIp($userlogIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userlogIp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userlogIp)) {
                $userlogIp = str_replace('*', '%', $userlogIp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserLoginPeer::USERLOG_IP, $userlogIp, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserLoginQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(UserLoginPeer::USERLOG_UID, $user->getUserId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserLoginPeer::USERLOG_UID, $user->toKeyValue('PrimaryKey', 'UserId'), $comparison);
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
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Jay\Bundle\AdminBundle\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   UserLogin $userLogin Object to remove from the list of results
     *
     * @return UserLoginQuery The current query, for fluid interface
     */
    public function prune($userLogin = null)
    {
        if ($userLogin) {
            $this->addUsingAlias(UserLoginPeer::USERLOG_ID, $userLogin->getUserlogId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
