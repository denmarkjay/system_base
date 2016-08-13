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
use Jay\Bundle\AdminBundle\Model\User;
use Jay\Bundle\AdminBundle\Model\UserLevel;
use Jay\Bundle\AdminBundle\Model\UserLogin;
use Jay\Bundle\AdminBundle\Model\UserPeer;
use Jay\Bundle\AdminBundle\Model\UserQuery;

/**
 * @method UserQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method UserQuery orderByUserFname($order = Criteria::ASC) Order by the user_fname column
 * @method UserQuery orderByUserMname($order = Criteria::ASC) Order by the user_mname column
 * @method UserQuery orderByUserLname($order = Criteria::ASC) Order by the user_lname column
 * @method UserQuery orderByUserLogin($order = Criteria::ASC) Order by the user_login column
 * @method UserQuery orderByUserPassword($order = Criteria::ASC) Order by the user_password column
 * @method UserQuery orderByUserEmail($order = Criteria::ASC) Order by the user_email column
 * @method UserQuery orderByUserGender($order = Criteria::ASC) Order by the user_gender column
 * @method UserQuery orderByUserBirthDate($order = Criteria::ASC) Order by the user_birth_date column
 * @method UserQuery orderByUserAge($order = Criteria::ASC) Order by the user_age column
 * @method UserQuery orderByUserPhone($order = Criteria::ASC) Order by the user_phone column
 * @method UserQuery orderByUserCompanyKey($order = Criteria::ASC) Order by the user_company_key column
 * @method UserQuery orderByUserRole($order = Criteria::ASC) Order by the user_role column
 * @method UserQuery orderByUserStatus($order = Criteria::ASC) Order by the user_status column
 * @method UserQuery orderByUserAddedBy($order = Criteria::ASC) Order by the user_added_by column
 * @method UserQuery orderByUserDateAdded($order = Criteria::ASC) Order by the user_date_added column
 * @method UserQuery orderByUserDateLastlogin($order = Criteria::ASC) Order by the user_date_lastlogin column
 *
 * @method UserQuery groupByUserId() Group by the user_id column
 * @method UserQuery groupByUserFname() Group by the user_fname column
 * @method UserQuery groupByUserMname() Group by the user_mname column
 * @method UserQuery groupByUserLname() Group by the user_lname column
 * @method UserQuery groupByUserLogin() Group by the user_login column
 * @method UserQuery groupByUserPassword() Group by the user_password column
 * @method UserQuery groupByUserEmail() Group by the user_email column
 * @method UserQuery groupByUserGender() Group by the user_gender column
 * @method UserQuery groupByUserBirthDate() Group by the user_birth_date column
 * @method UserQuery groupByUserAge() Group by the user_age column
 * @method UserQuery groupByUserPhone() Group by the user_phone column
 * @method UserQuery groupByUserCompanyKey() Group by the user_company_key column
 * @method UserQuery groupByUserRole() Group by the user_role column
 * @method UserQuery groupByUserStatus() Group by the user_status column
 * @method UserQuery groupByUserAddedBy() Group by the user_added_by column
 * @method UserQuery groupByUserDateAdded() Group by the user_date_added column
 * @method UserQuery groupByUserDateLastlogin() Group by the user_date_lastlogin column
 *
 * @method UserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UserQuery leftJoinCompany($relationAlias = null) Adds a LEFT JOIN clause to the query using the Company relation
 * @method UserQuery rightJoinCompany($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Company relation
 * @method UserQuery innerJoinCompany($relationAlias = null) Adds a INNER JOIN clause to the query using the Company relation
 *
 * @method UserQuery leftJoinUserLevel($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserLevel relation
 * @method UserQuery rightJoinUserLevel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserLevel relation
 * @method UserQuery innerJoinUserLevel($relationAlias = null) Adds a INNER JOIN clause to the query using the UserLevel relation
 *
 * @method UserQuery leftJoinUserLogin($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserLogin relation
 * @method UserQuery rightJoinUserLogin($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserLogin relation
 * @method UserQuery innerJoinUserLogin($relationAlias = null) Adds a INNER JOIN clause to the query using the UserLogin relation
 *
 * @method User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method User findOneOrCreate(PropelPDO $con = null) Return the first User matching the query, or a new User object populated from the query conditions when no match is found
 *
 * @method User findOneByUserFname(string $user_fname) Return the first User filtered by the user_fname column
 * @method User findOneByUserMname(string $user_mname) Return the first User filtered by the user_mname column
 * @method User findOneByUserLname(string $user_lname) Return the first User filtered by the user_lname column
 * @method User findOneByUserLogin(string $user_login) Return the first User filtered by the user_login column
 * @method User findOneByUserPassword(string $user_password) Return the first User filtered by the user_password column
 * @method User findOneByUserEmail(string $user_email) Return the first User filtered by the user_email column
 * @method User findOneByUserGender(string $user_gender) Return the first User filtered by the user_gender column
 * @method User findOneByUserBirthDate(string $user_birth_date) Return the first User filtered by the user_birth_date column
 * @method User findOneByUserAge(int $user_age) Return the first User filtered by the user_age column
 * @method User findOneByUserPhone(string $user_phone) Return the first User filtered by the user_phone column
 * @method User findOneByUserCompanyKey(string $user_company_key) Return the first User filtered by the user_company_key column
 * @method User findOneByUserRole(string $user_role) Return the first User filtered by the user_role column
 * @method User findOneByUserStatus(string $user_status) Return the first User filtered by the user_status column
 * @method User findOneByUserAddedBy(int $user_added_by) Return the first User filtered by the user_added_by column
 * @method User findOneByUserDateAdded(string $user_date_added) Return the first User filtered by the user_date_added column
 * @method User findOneByUserDateLastlogin(string $user_date_lastlogin) Return the first User filtered by the user_date_lastlogin column
 *
 * @method array findByUserId(int $user_id) Return User objects filtered by the user_id column
 * @method array findByUserFname(string $user_fname) Return User objects filtered by the user_fname column
 * @method array findByUserMname(string $user_mname) Return User objects filtered by the user_mname column
 * @method array findByUserLname(string $user_lname) Return User objects filtered by the user_lname column
 * @method array findByUserLogin(string $user_login) Return User objects filtered by the user_login column
 * @method array findByUserPassword(string $user_password) Return User objects filtered by the user_password column
 * @method array findByUserEmail(string $user_email) Return User objects filtered by the user_email column
 * @method array findByUserGender(string $user_gender) Return User objects filtered by the user_gender column
 * @method array findByUserBirthDate(string $user_birth_date) Return User objects filtered by the user_birth_date column
 * @method array findByUserAge(int $user_age) Return User objects filtered by the user_age column
 * @method array findByUserPhone(string $user_phone) Return User objects filtered by the user_phone column
 * @method array findByUserCompanyKey(string $user_company_key) Return User objects filtered by the user_company_key column
 * @method array findByUserRole(string $user_role) Return User objects filtered by the user_role column
 * @method array findByUserStatus(string $user_status) Return User objects filtered by the user_status column
 * @method array findByUserAddedBy(int $user_added_by) Return User objects filtered by the user_added_by column
 * @method array findByUserDateAdded(string $user_date_added) Return User objects filtered by the user_date_added column
 * @method array findByUserDateLastlogin(string $user_date_lastlogin) Return User objects filtered by the user_date_lastlogin column
 */
abstract class BaseUserQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUserQuery object.
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
            $modelName = 'Jay\\Bundle\\AdminBundle\\Model\\User';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UserQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UserQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserQuery) {
            return $criteria;
        }
        $query = new UserQuery(null, null, $modelAlias);

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
     * @return   User|User[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 User A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByUserId($key, $con = null)
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
     * @return                 User A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `user_id`, `user_fname`, `user_mname`, `user_lname`, `user_login`, `user_password`, `user_email`, `user_gender`, `user_birth_date`, `user_age`, `user_phone`, `user_company_key`, `user_role`, `user_status`, `user_added_by`, `user_date_added`, `user_date_lastlogin` FROM `user` WHERE `user_id` = :p0';
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
            $obj = new User();
            $obj->hydrate($row);
            UserPeer::addInstanceToPool($obj, (string) $key);
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
     * @return User|User[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|User[]|mixed the list of results, formatted by the current formatter
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
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserPeer::USER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserPeer::USER_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id >= 12
     * $query->filterByUserId(array('max' => 12)); // WHERE user_id <= 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(UserPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(UserPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the user_fname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserFname('fooValue');   // WHERE user_fname = 'fooValue'
     * $query->filterByUserFname('%fooValue%'); // WHERE user_fname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userFname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserFname($userFname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userFname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userFname)) {
                $userFname = str_replace('*', '%', $userFname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_FNAME, $userFname, $comparison);
    }

    /**
     * Filter the query on the user_mname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserMname('fooValue');   // WHERE user_mname = 'fooValue'
     * $query->filterByUserMname('%fooValue%'); // WHERE user_mname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userMname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserMname($userMname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userMname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userMname)) {
                $userMname = str_replace('*', '%', $userMname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_MNAME, $userMname, $comparison);
    }

    /**
     * Filter the query on the user_lname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserLname('fooValue');   // WHERE user_lname = 'fooValue'
     * $query->filterByUserLname('%fooValue%'); // WHERE user_lname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userLname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserLname($userLname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userLname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userLname)) {
                $userLname = str_replace('*', '%', $userLname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_LNAME, $userLname, $comparison);
    }

    /**
     * Filter the query on the user_login column
     *
     * Example usage:
     * <code>
     * $query->filterByUserLogin('fooValue');   // WHERE user_login = 'fooValue'
     * $query->filterByUserLogin('%fooValue%'); // WHERE user_login LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userLogin The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserLogin($userLogin = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userLogin)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userLogin)) {
                $userLogin = str_replace('*', '%', $userLogin);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_LOGIN, $userLogin, $comparison);
    }

    /**
     * Filter the query on the user_password column
     *
     * Example usage:
     * <code>
     * $query->filterByUserPassword('fooValue');   // WHERE user_password = 'fooValue'
     * $query->filterByUserPassword('%fooValue%'); // WHERE user_password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userPassword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserPassword($userPassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userPassword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userPassword)) {
                $userPassword = str_replace('*', '%', $userPassword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_PASSWORD, $userPassword, $comparison);
    }

    /**
     * Filter the query on the user_email column
     *
     * Example usage:
     * <code>
     * $query->filterByUserEmail('fooValue');   // WHERE user_email = 'fooValue'
     * $query->filterByUserEmail('%fooValue%'); // WHERE user_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserEmail($userEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userEmail)) {
                $userEmail = str_replace('*', '%', $userEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_EMAIL, $userEmail, $comparison);
    }

    /**
     * Filter the query on the user_gender column
     *
     * Example usage:
     * <code>
     * $query->filterByUserGender('fooValue');   // WHERE user_gender = 'fooValue'
     * $query->filterByUserGender('%fooValue%'); // WHERE user_gender LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userGender The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserGender($userGender = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userGender)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userGender)) {
                $userGender = str_replace('*', '%', $userGender);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_GENDER, $userGender, $comparison);
    }

    /**
     * Filter the query on the user_birth_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUserBirthDate('2011-03-14'); // WHERE user_birth_date = '2011-03-14'
     * $query->filterByUserBirthDate('now'); // WHERE user_birth_date = '2011-03-14'
     * $query->filterByUserBirthDate(array('max' => 'yesterday')); // WHERE user_birth_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $userBirthDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserBirthDate($userBirthDate = null, $comparison = null)
    {
        if (is_array($userBirthDate)) {
            $useMinMax = false;
            if (isset($userBirthDate['min'])) {
                $this->addUsingAlias(UserPeer::USER_BIRTH_DATE, $userBirthDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userBirthDate['max'])) {
                $this->addUsingAlias(UserPeer::USER_BIRTH_DATE, $userBirthDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_BIRTH_DATE, $userBirthDate, $comparison);
    }

    /**
     * Filter the query on the user_age column
     *
     * Example usage:
     * <code>
     * $query->filterByUserAge(1234); // WHERE user_age = 1234
     * $query->filterByUserAge(array(12, 34)); // WHERE user_age IN (12, 34)
     * $query->filterByUserAge(array('min' => 12)); // WHERE user_age >= 12
     * $query->filterByUserAge(array('max' => 12)); // WHERE user_age <= 12
     * </code>
     *
     * @param     mixed $userAge The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserAge($userAge = null, $comparison = null)
    {
        if (is_array($userAge)) {
            $useMinMax = false;
            if (isset($userAge['min'])) {
                $this->addUsingAlias(UserPeer::USER_AGE, $userAge['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userAge['max'])) {
                $this->addUsingAlias(UserPeer::USER_AGE, $userAge['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_AGE, $userAge, $comparison);
    }

    /**
     * Filter the query on the user_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByUserPhone('fooValue');   // WHERE user_phone = 'fooValue'
     * $query->filterByUserPhone('%fooValue%'); // WHERE user_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserPhone($userPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userPhone)) {
                $userPhone = str_replace('*', '%', $userPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_PHONE, $userPhone, $comparison);
    }

    /**
     * Filter the query on the user_company_key column
     *
     * Example usage:
     * <code>
     * $query->filterByUserCompanyKey('fooValue');   // WHERE user_company_key = 'fooValue'
     * $query->filterByUserCompanyKey('%fooValue%'); // WHERE user_company_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userCompanyKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserCompanyKey($userCompanyKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userCompanyKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userCompanyKey)) {
                $userCompanyKey = str_replace('*', '%', $userCompanyKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_COMPANY_KEY, $userCompanyKey, $comparison);
    }

    /**
     * Filter the query on the user_role column
     *
     * Example usage:
     * <code>
     * $query->filterByUserRole('fooValue');   // WHERE user_role = 'fooValue'
     * $query->filterByUserRole('%fooValue%'); // WHERE user_role LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userRole The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserRole($userRole = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userRole)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userRole)) {
                $userRole = str_replace('*', '%', $userRole);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_ROLE, $userRole, $comparison);
    }

    /**
     * Filter the query on the user_status column
     *
     * Example usage:
     * <code>
     * $query->filterByUserStatus('fooValue');   // WHERE user_status = 'fooValue'
     * $query->filterByUserStatus('%fooValue%'); // WHERE user_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserStatus($userStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userStatus)) {
                $userStatus = str_replace('*', '%', $userStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_STATUS, $userStatus, $comparison);
    }

    /**
     * Filter the query on the user_added_by column
     *
     * Example usage:
     * <code>
     * $query->filterByUserAddedBy(1234); // WHERE user_added_by = 1234
     * $query->filterByUserAddedBy(array(12, 34)); // WHERE user_added_by IN (12, 34)
     * $query->filterByUserAddedBy(array('min' => 12)); // WHERE user_added_by >= 12
     * $query->filterByUserAddedBy(array('max' => 12)); // WHERE user_added_by <= 12
     * </code>
     *
     * @param     mixed $userAddedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserAddedBy($userAddedBy = null, $comparison = null)
    {
        if (is_array($userAddedBy)) {
            $useMinMax = false;
            if (isset($userAddedBy['min'])) {
                $this->addUsingAlias(UserPeer::USER_ADDED_BY, $userAddedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userAddedBy['max'])) {
                $this->addUsingAlias(UserPeer::USER_ADDED_BY, $userAddedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_ADDED_BY, $userAddedBy, $comparison);
    }

    /**
     * Filter the query on the user_date_added column
     *
     * Example usage:
     * <code>
     * $query->filterByUserDateAdded('2011-03-14'); // WHERE user_date_added = '2011-03-14'
     * $query->filterByUserDateAdded('now'); // WHERE user_date_added = '2011-03-14'
     * $query->filterByUserDateAdded(array('max' => 'yesterday')); // WHERE user_date_added < '2011-03-13'
     * </code>
     *
     * @param     mixed $userDateAdded The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserDateAdded($userDateAdded = null, $comparison = null)
    {
        if (is_array($userDateAdded)) {
            $useMinMax = false;
            if (isset($userDateAdded['min'])) {
                $this->addUsingAlias(UserPeer::USER_DATE_ADDED, $userDateAdded['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userDateAdded['max'])) {
                $this->addUsingAlias(UserPeer::USER_DATE_ADDED, $userDateAdded['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_DATE_ADDED, $userDateAdded, $comparison);
    }

    /**
     * Filter the query on the user_date_lastlogin column
     *
     * Example usage:
     * <code>
     * $query->filterByUserDateLastlogin('2011-03-14'); // WHERE user_date_lastlogin = '2011-03-14'
     * $query->filterByUserDateLastlogin('now'); // WHERE user_date_lastlogin = '2011-03-14'
     * $query->filterByUserDateLastlogin(array('max' => 'yesterday')); // WHERE user_date_lastlogin < '2011-03-13'
     * </code>
     *
     * @param     mixed $userDateLastlogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserDateLastlogin($userDateLastlogin = null, $comparison = null)
    {
        if (is_array($userDateLastlogin)) {
            $useMinMax = false;
            if (isset($userDateLastlogin['min'])) {
                $this->addUsingAlias(UserPeer::USER_DATE_LASTLOGIN, $userDateLastlogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userDateLastlogin['max'])) {
                $this->addUsingAlias(UserPeer::USER_DATE_LASTLOGIN, $userDateLastlogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_DATE_LASTLOGIN, $userDateLastlogin, $comparison);
    }

    /**
     * Filter the query by a related Company object
     *
     * @param   Company|PropelObjectCollection $company The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCompany($company, $comparison = null)
    {
        if ($company instanceof Company) {
            return $this
                ->addUsingAlias(UserPeer::USER_COMPANY_KEY, $company->getCompanyKey(), $comparison);
        } elseif ($company instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserPeer::USER_COMPANY_KEY, $company->toKeyValue('PrimaryKey', 'CompanyKey'), $comparison);
        } else {
            throw new PropelException('filterByCompany() only accepts arguments of type Company or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Company relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinCompany($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Company');

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
            $this->addJoinObject($join, 'Company');
        }

        return $this;
    }

    /**
     * Use the Company relation Company object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Jay\Bundle\AdminBundle\Model\CompanyQuery A secondary query class using the current class as primary query
     */
    public function useCompanyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCompany($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Company', '\Jay\Bundle\AdminBundle\Model\CompanyQuery');
    }

    /**
     * Filter the query by a related UserLevel object
     *
     * @param   UserLevel|PropelObjectCollection $userLevel The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserLevel($userLevel, $comparison = null)
    {
        if ($userLevel instanceof UserLevel) {
            return $this
                ->addUsingAlias(UserPeer::USER_ROLE, $userLevel->getUlRole(), $comparison);
        } elseif ($userLevel instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserPeer::USER_ROLE, $userLevel->toKeyValue('PrimaryKey', 'UlRole'), $comparison);
        } else {
            throw new PropelException('filterByUserLevel() only accepts arguments of type UserLevel or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserLevel relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserLevel($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserLevel');

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
            $this->addJoinObject($join, 'UserLevel');
        }

        return $this;
    }

    /**
     * Use the UserLevel relation UserLevel object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Jay\Bundle\AdminBundle\Model\UserLevelQuery A secondary query class using the current class as primary query
     */
    public function useUserLevelQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserLevel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserLevel', '\Jay\Bundle\AdminBundle\Model\UserLevelQuery');
    }

    /**
     * Filter the query by a related UserLogin object
     *
     * @param   UserLogin|PropelObjectCollection $userLogin  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserLogin($userLogin, $comparison = null)
    {
        if ($userLogin instanceof UserLogin) {
            return $this
                ->addUsingAlias(UserPeer::USER_ID, $userLogin->getUserlogUid(), $comparison);
        } elseif ($userLogin instanceof PropelObjectCollection) {
            return $this
                ->useUserLoginQuery()
                ->filterByPrimaryKeys($userLogin->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserLogin() only accepts arguments of type UserLogin or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserLogin relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserLogin($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserLogin');

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
            $this->addJoinObject($join, 'UserLogin');
        }

        return $this;
    }

    /**
     * Use the UserLogin relation UserLogin object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Jay\Bundle\AdminBundle\Model\UserLoginQuery A secondary query class using the current class as primary query
     */
    public function useUserLoginQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserLogin($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserLogin', '\Jay\Bundle\AdminBundle\Model\UserLoginQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   User $user Object to remove from the list of results
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserPeer::USER_ID, $user->getUserId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
