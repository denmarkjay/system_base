<?php

namespace Jay\Bundle\AdminBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Jay\Bundle\AdminBundle\Model\Company;
use Jay\Bundle\AdminBundle\Model\CompanyQuery;
use Jay\Bundle\AdminBundle\Model\User;
use Jay\Bundle\AdminBundle\Model\UserLevel;
use Jay\Bundle\AdminBundle\Model\UserLevelQuery;
use Jay\Bundle\AdminBundle\Model\UserLogin;
use Jay\Bundle\AdminBundle\Model\UserLoginQuery;
use Jay\Bundle\AdminBundle\Model\UserPeer;
use Jay\Bundle\AdminBundle\Model\UserQuery;

abstract class BaseUser extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Jay\\Bundle\\AdminBundle\\Model\\UserPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        UserPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the user_fname field.
     * @var        string
     */
    protected $user_fname;

    /**
     * The value for the user_mname field.
     * @var        string
     */
    protected $user_mname;

    /**
     * The value for the user_lname field.
     * @var        string
     */
    protected $user_lname;

    /**
     * The value for the user_login field.
     * @var        string
     */
    protected $user_login;

    /**
     * The value for the user_password field.
     * @var        string
     */
    protected $user_password;

    /**
     * The value for the user_email field.
     * @var        string
     */
    protected $user_email;

    /**
     * The value for the user_gender field.
     * @var        string
     */
    protected $user_gender;

    /**
     * The value for the user_birth_date field.
     * @var        string
     */
    protected $user_birth_date;

    /**
     * The value for the user_age field.
     * @var        int
     */
    protected $user_age;

    /**
     * The value for the user_phone field.
     * @var        string
     */
    protected $user_phone;

    /**
     * The value for the user_company_key field.
     * @var        string
     */
    protected $user_company_key;

    /**
     * The value for the user_role field.
     * @var        string
     */
    protected $user_role;

    /**
     * The value for the user_status field.
     * @var        string
     */
    protected $user_status;

    /**
     * The value for the user_added_by field.
     * @var        int
     */
    protected $user_added_by;

    /**
     * The value for the user_date_added field.
     * @var        string
     */
    protected $user_date_added;

    /**
     * The value for the user_date_lastlogin field.
     * @var        string
     */
    protected $user_date_lastlogin;

    /**
     * @var        Company
     */
    protected $aCompany;

    /**
     * @var        UserLevel
     */
    protected $aUserLevel;

    /**
     * @var        PropelObjectCollection|UserLogin[] Collection to store aggregation of UserLogin objects.
     */
    protected $collUserLogins;
    protected $collUserLoginsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $userLoginsScheduledForDeletion = null;

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {

        return $this->user_id;
    }

    /**
     * Get the [user_fname] column value.
     *
     * @return string
     */
    public function getUserFname()
    {

        return $this->user_fname;
    }

    /**
     * Get the [user_mname] column value.
     *
     * @return string
     */
    public function getUserMname()
    {

        return $this->user_mname;
    }

    /**
     * Get the [user_lname] column value.
     *
     * @return string
     */
    public function getUserLname()
    {

        return $this->user_lname;
    }

    /**
     * Get the [user_login] column value.
     *
     * @return string
     */
    public function getUserLogin()
    {

        return $this->user_login;
    }

    /**
     * Get the [user_password] column value.
     *
     * @return string
     */
    public function getUserPassword()
    {

        return $this->user_password;
    }

    /**
     * Get the [user_email] column value.
     *
     * @return string
     */
    public function getUserEmail()
    {

        return $this->user_email;
    }

    /**
     * Get the [user_gender] column value.
     *
     * @return string
     */
    public function getUserGender()
    {

        return $this->user_gender;
    }

    /**
     * Get the [optionally formatted] temporal [user_birth_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUserBirthDate($format = null)
    {
        if ($this->user_birth_date === null) {
            return null;
        }

        if ($this->user_birth_date === '0000-00-00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->user_birth_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->user_birth_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [user_age] column value.
     *
     * @return int
     */
    public function getUserAge()
    {

        return $this->user_age;
    }

    /**
     * Get the [user_phone] column value.
     *
     * @return string
     */
    public function getUserPhone()
    {

        return $this->user_phone;
    }

    /**
     * Get the [user_company_key] column value.
     *
     * @return string
     */
    public function getUserCompanyKey()
    {

        return $this->user_company_key;
    }

    /**
     * Get the [user_role] column value.
     *
     * @return string
     */
    public function getUserRole()
    {

        return $this->user_role;
    }

    /**
     * Get the [user_status] column value.
     *
     * @return string
     */
    public function getUserStatus()
    {

        return $this->user_status;
    }

    /**
     * Get the [user_added_by] column value.
     *
     * @return int
     */
    public function getUserAddedBy()
    {

        return $this->user_added_by;
    }

    /**
     * Get the [optionally formatted] temporal [user_date_added] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUserDateAdded($format = null)
    {
        if ($this->user_date_added === null) {
            return null;
        }

        if ($this->user_date_added === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->user_date_added);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->user_date_added, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [user_date_lastlogin] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUserDateLastlogin($format = null)
    {
        if ($this->user_date_lastlogin === null) {
            return null;
        }

        if ($this->user_date_lastlogin === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->user_date_lastlogin);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->user_date_lastlogin, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [user_id] column.
     *
     * @param  int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[] = UserPeer::USER_ID;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [user_fname] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserFname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_fname !== $v) {
            $this->user_fname = $v;
            $this->modifiedColumns[] = UserPeer::USER_FNAME;
        }


        return $this;
    } // setUserFname()

    /**
     * Set the value of [user_mname] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserMname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_mname !== $v) {
            $this->user_mname = $v;
            $this->modifiedColumns[] = UserPeer::USER_MNAME;
        }


        return $this;
    } // setUserMname()

    /**
     * Set the value of [user_lname] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserLname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_lname !== $v) {
            $this->user_lname = $v;
            $this->modifiedColumns[] = UserPeer::USER_LNAME;
        }


        return $this;
    } // setUserLname()

    /**
     * Set the value of [user_login] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserLogin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_login !== $v) {
            $this->user_login = $v;
            $this->modifiedColumns[] = UserPeer::USER_LOGIN;
        }


        return $this;
    } // setUserLogin()

    /**
     * Set the value of [user_password] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_password !== $v) {
            $this->user_password = $v;
            $this->modifiedColumns[] = UserPeer::USER_PASSWORD;
        }


        return $this;
    } // setUserPassword()

    /**
     * Set the value of [user_email] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_email !== $v) {
            $this->user_email = $v;
            $this->modifiedColumns[] = UserPeer::USER_EMAIL;
        }


        return $this;
    } // setUserEmail()

    /**
     * Set the value of [user_gender] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserGender($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_gender !== $v) {
            $this->user_gender = $v;
            $this->modifiedColumns[] = UserPeer::USER_GENDER;
        }


        return $this;
    } // setUserGender()

    /**
     * Sets the value of [user_birth_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return User The current object (for fluent API support)
     */
    public function setUserBirthDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->user_birth_date !== null || $dt !== null) {
            $currentDateAsString = ($this->user_birth_date !== null && $tmpDt = new DateTime($this->user_birth_date)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->user_birth_date = $newDateAsString;
                $this->modifiedColumns[] = UserPeer::USER_BIRTH_DATE;
            }
        } // if either are not null


        return $this;
    } // setUserBirthDate()

    /**
     * Set the value of [user_age] column.
     *
     * @param  int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserAge($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_age !== $v) {
            $this->user_age = $v;
            $this->modifiedColumns[] = UserPeer::USER_AGE;
        }


        return $this;
    } // setUserAge()

    /**
     * Set the value of [user_phone] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_phone !== $v) {
            $this->user_phone = $v;
            $this->modifiedColumns[] = UserPeer::USER_PHONE;
        }


        return $this;
    } // setUserPhone()

    /**
     * Set the value of [user_company_key] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserCompanyKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_company_key !== $v) {
            $this->user_company_key = $v;
            $this->modifiedColumns[] = UserPeer::USER_COMPANY_KEY;
        }

        if ($this->aCompany !== null && $this->aCompany->getCompanyKey() !== $v) {
            $this->aCompany = null;
        }


        return $this;
    } // setUserCompanyKey()

    /**
     * Set the value of [user_role] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserRole($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_role !== $v) {
            $this->user_role = $v;
            $this->modifiedColumns[] = UserPeer::USER_ROLE;
        }

        if ($this->aUserLevel !== null && $this->aUserLevel->getUlRole() !== $v) {
            $this->aUserLevel = null;
        }


        return $this;
    } // setUserRole()

    /**
     * Set the value of [user_status] column.
     *
     * @param  string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_status !== $v) {
            $this->user_status = $v;
            $this->modifiedColumns[] = UserPeer::USER_STATUS;
        }


        return $this;
    } // setUserStatus()

    /**
     * Set the value of [user_added_by] column.
     *
     * @param  int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserAddedBy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_added_by !== $v) {
            $this->user_added_by = $v;
            $this->modifiedColumns[] = UserPeer::USER_ADDED_BY;
        }


        return $this;
    } // setUserAddedBy()

    /**
     * Sets the value of [user_date_added] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return User The current object (for fluent API support)
     */
    public function setUserDateAdded($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->user_date_added !== null || $dt !== null) {
            $currentDateAsString = ($this->user_date_added !== null && $tmpDt = new DateTime($this->user_date_added)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->user_date_added = $newDateAsString;
                $this->modifiedColumns[] = UserPeer::USER_DATE_ADDED;
            }
        } // if either are not null


        return $this;
    } // setUserDateAdded()

    /**
     * Sets the value of [user_date_lastlogin] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return User The current object (for fluent API support)
     */
    public function setUserDateLastlogin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->user_date_lastlogin !== null || $dt !== null) {
            $currentDateAsString = ($this->user_date_lastlogin !== null && $tmpDt = new DateTime($this->user_date_lastlogin)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->user_date_lastlogin = $newDateAsString;
                $this->modifiedColumns[] = UserPeer::USER_DATE_LASTLOGIN;
            }
        } // if either are not null


        return $this;
    } // setUserDateLastlogin()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->user_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->user_fname = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->user_mname = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->user_lname = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->user_login = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->user_password = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->user_email = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->user_gender = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->user_birth_date = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->user_age = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->user_phone = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->user_company_key = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->user_role = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->user_status = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->user_added_by = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
            $this->user_date_added = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->user_date_lastlogin = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 17; // 17 = UserPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating User object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aCompany !== null && $this->user_company_key !== $this->aCompany->getCompanyKey()) {
            $this->aCompany = null;
        }
        if ($this->aUserLevel !== null && $this->user_role !== $this->aUserLevel->getUlRole()) {
            $this->aUserLevel = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCompany = null;
            $this->aUserLevel = null;
            $this->collUserLogins = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = UserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCompany !== null) {
                if ($this->aCompany->isModified() || $this->aCompany->isNew()) {
                    $affectedRows += $this->aCompany->save($con);
                }
                $this->setCompany($this->aCompany);
            }

            if ($this->aUserLevel !== null) {
                if ($this->aUserLevel->isModified() || $this->aUserLevel->isNew()) {
                    $affectedRows += $this->aUserLevel->save($con);
                }
                $this->setUserLevel($this->aUserLevel);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->userLoginsScheduledForDeletion !== null) {
                if (!$this->userLoginsScheduledForDeletion->isEmpty()) {
                    foreach ($this->userLoginsScheduledForDeletion as $userLogin) {
                        // need to save related object because we set the relation to null
                        $userLogin->save($con);
                    }
                    $this->userLoginsScheduledForDeletion = null;
                }
            }

            if ($this->collUserLogins !== null) {
                foreach ($this->collUserLogins as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = UserPeer::USER_ID;
        if (null !== $this->user_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserPeer::USER_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserPeer::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`user_id`';
        }
        if ($this->isColumnModified(UserPeer::USER_FNAME)) {
            $modifiedColumns[':p' . $index++]  = '`user_fname`';
        }
        if ($this->isColumnModified(UserPeer::USER_MNAME)) {
            $modifiedColumns[':p' . $index++]  = '`user_mname`';
        }
        if ($this->isColumnModified(UserPeer::USER_LNAME)) {
            $modifiedColumns[':p' . $index++]  = '`user_lname`';
        }
        if ($this->isColumnModified(UserPeer::USER_LOGIN)) {
            $modifiedColumns[':p' . $index++]  = '`user_login`';
        }
        if ($this->isColumnModified(UserPeer::USER_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`user_password`';
        }
        if ($this->isColumnModified(UserPeer::USER_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`user_email`';
        }
        if ($this->isColumnModified(UserPeer::USER_GENDER)) {
            $modifiedColumns[':p' . $index++]  = '`user_gender`';
        }
        if ($this->isColumnModified(UserPeer::USER_BIRTH_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`user_birth_date`';
        }
        if ($this->isColumnModified(UserPeer::USER_AGE)) {
            $modifiedColumns[':p' . $index++]  = '`user_age`';
        }
        if ($this->isColumnModified(UserPeer::USER_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`user_phone`';
        }
        if ($this->isColumnModified(UserPeer::USER_COMPANY_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`user_company_key`';
        }
        if ($this->isColumnModified(UserPeer::USER_ROLE)) {
            $modifiedColumns[':p' . $index++]  = '`user_role`';
        }
        if ($this->isColumnModified(UserPeer::USER_STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`user_status`';
        }
        if ($this->isColumnModified(UserPeer::USER_ADDED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`user_added_by`';
        }
        if ($this->isColumnModified(UserPeer::USER_DATE_ADDED)) {
            $modifiedColumns[':p' . $index++]  = '`user_date_added`';
        }
        if ($this->isColumnModified(UserPeer::USER_DATE_LASTLOGIN)) {
            $modifiedColumns[':p' . $index++]  = '`user_date_lastlogin`';
        }

        $sql = sprintf(
            'INSERT INTO `user` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`user_id`':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case '`user_fname`':
                        $stmt->bindValue($identifier, $this->user_fname, PDO::PARAM_STR);
                        break;
                    case '`user_mname`':
                        $stmt->bindValue($identifier, $this->user_mname, PDO::PARAM_STR);
                        break;
                    case '`user_lname`':
                        $stmt->bindValue($identifier, $this->user_lname, PDO::PARAM_STR);
                        break;
                    case '`user_login`':
                        $stmt->bindValue($identifier, $this->user_login, PDO::PARAM_STR);
                        break;
                    case '`user_password`':
                        $stmt->bindValue($identifier, $this->user_password, PDO::PARAM_STR);
                        break;
                    case '`user_email`':
                        $stmt->bindValue($identifier, $this->user_email, PDO::PARAM_STR);
                        break;
                    case '`user_gender`':
                        $stmt->bindValue($identifier, $this->user_gender, PDO::PARAM_STR);
                        break;
                    case '`user_birth_date`':
                        $stmt->bindValue($identifier, $this->user_birth_date, PDO::PARAM_STR);
                        break;
                    case '`user_age`':
                        $stmt->bindValue($identifier, $this->user_age, PDO::PARAM_INT);
                        break;
                    case '`user_phone`':
                        $stmt->bindValue($identifier, $this->user_phone, PDO::PARAM_STR);
                        break;
                    case '`user_company_key`':
                        $stmt->bindValue($identifier, $this->user_company_key, PDO::PARAM_STR);
                        break;
                    case '`user_role`':
                        $stmt->bindValue($identifier, $this->user_role, PDO::PARAM_STR);
                        break;
                    case '`user_status`':
                        $stmt->bindValue($identifier, $this->user_status, PDO::PARAM_STR);
                        break;
                    case '`user_added_by`':
                        $stmt->bindValue($identifier, $this->user_added_by, PDO::PARAM_INT);
                        break;
                    case '`user_date_added`':
                        $stmt->bindValue($identifier, $this->user_date_added, PDO::PARAM_STR);
                        break;
                    case '`user_date_lastlogin`':
                        $stmt->bindValue($identifier, $this->user_date_lastlogin, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setUserId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCompany !== null) {
                if (!$this->aCompany->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCompany->getValidationFailures());
                }
            }

            if ($this->aUserLevel !== null) {
                if (!$this->aUserLevel->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUserLevel->getValidationFailures());
                }
            }


            if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collUserLogins !== null) {
                    foreach ($this->collUserLogins as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getUserId();
                break;
            case 1:
                return $this->getUserFname();
                break;
            case 2:
                return $this->getUserMname();
                break;
            case 3:
                return $this->getUserLname();
                break;
            case 4:
                return $this->getUserLogin();
                break;
            case 5:
                return $this->getUserPassword();
                break;
            case 6:
                return $this->getUserEmail();
                break;
            case 7:
                return $this->getUserGender();
                break;
            case 8:
                return $this->getUserBirthDate();
                break;
            case 9:
                return $this->getUserAge();
                break;
            case 10:
                return $this->getUserPhone();
                break;
            case 11:
                return $this->getUserCompanyKey();
                break;
            case 12:
                return $this->getUserRole();
                break;
            case 13:
                return $this->getUserStatus();
                break;
            case 14:
                return $this->getUserAddedBy();
                break;
            case 15:
                return $this->getUserDateAdded();
                break;
            case 16:
                return $this->getUserDateLastlogin();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['User'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->getPrimaryKey()] = true;
        $keys = UserPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getUserId(),
            $keys[1] => $this->getUserFname(),
            $keys[2] => $this->getUserMname(),
            $keys[3] => $this->getUserLname(),
            $keys[4] => $this->getUserLogin(),
            $keys[5] => $this->getUserPassword(),
            $keys[6] => $this->getUserEmail(),
            $keys[7] => $this->getUserGender(),
            $keys[8] => $this->getUserBirthDate(),
            $keys[9] => $this->getUserAge(),
            $keys[10] => $this->getUserPhone(),
            $keys[11] => $this->getUserCompanyKey(),
            $keys[12] => $this->getUserRole(),
            $keys[13] => $this->getUserStatus(),
            $keys[14] => $this->getUserAddedBy(),
            $keys[15] => $this->getUserDateAdded(),
            $keys[16] => $this->getUserDateLastlogin(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCompany) {
                $result['Company'] = $this->aCompany->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserLevel) {
                $result['UserLevel'] = $this->aUserLevel->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collUserLogins) {
                $result['UserLogins'] = $this->collUserLogins->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setUserId($value);
                break;
            case 1:
                $this->setUserFname($value);
                break;
            case 2:
                $this->setUserMname($value);
                break;
            case 3:
                $this->setUserLname($value);
                break;
            case 4:
                $this->setUserLogin($value);
                break;
            case 5:
                $this->setUserPassword($value);
                break;
            case 6:
                $this->setUserEmail($value);
                break;
            case 7:
                $this->setUserGender($value);
                break;
            case 8:
                $this->setUserBirthDate($value);
                break;
            case 9:
                $this->setUserAge($value);
                break;
            case 10:
                $this->setUserPhone($value);
                break;
            case 11:
                $this->setUserCompanyKey($value);
                break;
            case 12:
                $this->setUserRole($value);
                break;
            case 13:
                $this->setUserStatus($value);
                break;
            case 14:
                $this->setUserAddedBy($value);
                break;
            case 15:
                $this->setUserDateAdded($value);
                break;
            case 16:
                $this->setUserDateLastlogin($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = UserPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setUserId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUserFname($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUserMname($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUserLname($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUserLogin($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUserPassword($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUserEmail($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setUserGender($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setUserBirthDate($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setUserAge($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setUserPhone($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setUserCompanyKey($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setUserRole($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setUserStatus($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setUserAddedBy($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setUserDateAdded($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setUserDateLastlogin($arr[$keys[16]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserPeer::DATABASE_NAME);

        if ($this->isColumnModified(UserPeer::USER_ID)) $criteria->add(UserPeer::USER_ID, $this->user_id);
        if ($this->isColumnModified(UserPeer::USER_FNAME)) $criteria->add(UserPeer::USER_FNAME, $this->user_fname);
        if ($this->isColumnModified(UserPeer::USER_MNAME)) $criteria->add(UserPeer::USER_MNAME, $this->user_mname);
        if ($this->isColumnModified(UserPeer::USER_LNAME)) $criteria->add(UserPeer::USER_LNAME, $this->user_lname);
        if ($this->isColumnModified(UserPeer::USER_LOGIN)) $criteria->add(UserPeer::USER_LOGIN, $this->user_login);
        if ($this->isColumnModified(UserPeer::USER_PASSWORD)) $criteria->add(UserPeer::USER_PASSWORD, $this->user_password);
        if ($this->isColumnModified(UserPeer::USER_EMAIL)) $criteria->add(UserPeer::USER_EMAIL, $this->user_email);
        if ($this->isColumnModified(UserPeer::USER_GENDER)) $criteria->add(UserPeer::USER_GENDER, $this->user_gender);
        if ($this->isColumnModified(UserPeer::USER_BIRTH_DATE)) $criteria->add(UserPeer::USER_BIRTH_DATE, $this->user_birth_date);
        if ($this->isColumnModified(UserPeer::USER_AGE)) $criteria->add(UserPeer::USER_AGE, $this->user_age);
        if ($this->isColumnModified(UserPeer::USER_PHONE)) $criteria->add(UserPeer::USER_PHONE, $this->user_phone);
        if ($this->isColumnModified(UserPeer::USER_COMPANY_KEY)) $criteria->add(UserPeer::USER_COMPANY_KEY, $this->user_company_key);
        if ($this->isColumnModified(UserPeer::USER_ROLE)) $criteria->add(UserPeer::USER_ROLE, $this->user_role);
        if ($this->isColumnModified(UserPeer::USER_STATUS)) $criteria->add(UserPeer::USER_STATUS, $this->user_status);
        if ($this->isColumnModified(UserPeer::USER_ADDED_BY)) $criteria->add(UserPeer::USER_ADDED_BY, $this->user_added_by);
        if ($this->isColumnModified(UserPeer::USER_DATE_ADDED)) $criteria->add(UserPeer::USER_DATE_ADDED, $this->user_date_added);
        if ($this->isColumnModified(UserPeer::USER_DATE_LASTLOGIN)) $criteria->add(UserPeer::USER_DATE_LASTLOGIN, $this->user_date_lastlogin);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(UserPeer::DATABASE_NAME);
        $criteria->add(UserPeer::USER_ID, $this->user_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getUserId();
    }

    /**
     * Generic method to set the primary key (user_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setUserId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getUserId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of User (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserFname($this->getUserFname());
        $copyObj->setUserMname($this->getUserMname());
        $copyObj->setUserLname($this->getUserLname());
        $copyObj->setUserLogin($this->getUserLogin());
        $copyObj->setUserPassword($this->getUserPassword());
        $copyObj->setUserEmail($this->getUserEmail());
        $copyObj->setUserGender($this->getUserGender());
        $copyObj->setUserBirthDate($this->getUserBirthDate());
        $copyObj->setUserAge($this->getUserAge());
        $copyObj->setUserPhone($this->getUserPhone());
        $copyObj->setUserCompanyKey($this->getUserCompanyKey());
        $copyObj->setUserRole($this->getUserRole());
        $copyObj->setUserStatus($this->getUserStatus());
        $copyObj->setUserAddedBy($this->getUserAddedBy());
        $copyObj->setUserDateAdded($this->getUserDateAdded());
        $copyObj->setUserDateLastlogin($this->getUserDateLastlogin());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getUserLogins() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserLogin($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setUserId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return User Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return UserPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new UserPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Company object.
     *
     * @param                  Company $v
     * @return User The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCompany(Company $v = null)
    {
        if ($v === null) {
            $this->setUserCompanyKey(NULL);
        } else {
            $this->setUserCompanyKey($v->getCompanyKey());
        }

        $this->aCompany = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Company object, it will not be re-added.
        if ($v !== null) {
            $v->addUser($this);
        }


        return $this;
    }


    /**
     * Get the associated Company object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Company The associated Company object.
     * @throws PropelException
     */
    public function getCompany(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCompany === null && (($this->user_company_key !== "" && $this->user_company_key !== null)) && $doQuery) {
            $this->aCompany = CompanyQuery::create()
                ->filterByUser($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCompany->addUsers($this);
             */
        }

        return $this->aCompany;
    }

    /**
     * Declares an association between this object and a UserLevel object.
     *
     * @param                  UserLevel $v
     * @return User The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserLevel(UserLevel $v = null)
    {
        if ($v === null) {
            $this->setUserRole(NULL);
        } else {
            $this->setUserRole($v->getUlRole());
        }

        $this->aUserLevel = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the UserLevel object, it will not be re-added.
        if ($v !== null) {
            $v->addUser($this);
        }


        return $this;
    }


    /**
     * Get the associated UserLevel object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return UserLevel The associated UserLevel object.
     * @throws PropelException
     */
    public function getUserLevel(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUserLevel === null && (($this->user_role !== "" && $this->user_role !== null)) && $doQuery) {
            $this->aUserLevel = UserLevelQuery::create()
                ->filterByUser($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserLevel->addUsers($this);
             */
        }

        return $this->aUserLevel;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('UserLogin' == $relationName) {
            $this->initUserLogins();
        }
    }

    /**
     * Clears out the collUserLogins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return User The current object (for fluent API support)
     * @see        addUserLogins()
     */
    public function clearUserLogins()
    {
        $this->collUserLogins = null; // important to set this to null since that means it is uninitialized
        $this->collUserLoginsPartial = null;

        return $this;
    }

    /**
     * reset is the collUserLogins collection loaded partially
     *
     * @return void
     */
    public function resetPartialUserLogins($v = true)
    {
        $this->collUserLoginsPartial = $v;
    }

    /**
     * Initializes the collUserLogins collection.
     *
     * By default this just sets the collUserLogins collection to an empty array (like clearcollUserLogins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserLogins($overrideExisting = true)
    {
        if (null !== $this->collUserLogins && !$overrideExisting) {
            return;
        }
        $this->collUserLogins = new PropelObjectCollection();
        $this->collUserLogins->setModel('UserLogin');
    }

    /**
     * Gets an array of UserLogin objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|UserLogin[] List of UserLogin objects
     * @throws PropelException
     */
    public function getUserLogins($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collUserLoginsPartial && !$this->isNew();
        if (null === $this->collUserLogins || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserLogins) {
                // return empty collection
                $this->initUserLogins();
            } else {
                $collUserLogins = UserLoginQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collUserLoginsPartial && count($collUserLogins)) {
                      $this->initUserLogins(false);

                      foreach ($collUserLogins as $obj) {
                        if (false == $this->collUserLogins->contains($obj)) {
                          $this->collUserLogins->append($obj);
                        }
                      }

                      $this->collUserLoginsPartial = true;
                    }

                    $collUserLogins->getInternalIterator()->rewind();

                    return $collUserLogins;
                }

                if ($partial && $this->collUserLogins) {
                    foreach ($this->collUserLogins as $obj) {
                        if ($obj->isNew()) {
                            $collUserLogins[] = $obj;
                        }
                    }
                }

                $this->collUserLogins = $collUserLogins;
                $this->collUserLoginsPartial = false;
            }
        }

        return $this->collUserLogins;
    }

    /**
     * Sets a collection of UserLogin objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $userLogins A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return User The current object (for fluent API support)
     */
    public function setUserLogins(PropelCollection $userLogins, PropelPDO $con = null)
    {
        $userLoginsToDelete = $this->getUserLogins(new Criteria(), $con)->diff($userLogins);


        $this->userLoginsScheduledForDeletion = $userLoginsToDelete;

        foreach ($userLoginsToDelete as $userLoginRemoved) {
            $userLoginRemoved->setUser(null);
        }

        $this->collUserLogins = null;
        foreach ($userLogins as $userLogin) {
            $this->addUserLogin($userLogin);
        }

        $this->collUserLogins = $userLogins;
        $this->collUserLoginsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserLogin objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related UserLogin objects.
     * @throws PropelException
     */
    public function countUserLogins(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collUserLoginsPartial && !$this->isNew();
        if (null === $this->collUserLogins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserLogins) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserLogins());
            }
            $query = UserLoginQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collUserLogins);
    }

    /**
     * Method called to associate a UserLogin object to this object
     * through the UserLogin foreign key attribute.
     *
     * @param    UserLogin $l UserLogin
     * @return User The current object (for fluent API support)
     */
    public function addUserLogin(UserLogin $l)
    {
        if ($this->collUserLogins === null) {
            $this->initUserLogins();
            $this->collUserLoginsPartial = true;
        }

        if (!in_array($l, $this->collUserLogins->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddUserLogin($l);

            if ($this->userLoginsScheduledForDeletion and $this->userLoginsScheduledForDeletion->contains($l)) {
                $this->userLoginsScheduledForDeletion->remove($this->userLoginsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	UserLogin $userLogin The userLogin object to add.
     */
    protected function doAddUserLogin($userLogin)
    {
        $this->collUserLogins[]= $userLogin;
        $userLogin->setUser($this);
    }

    /**
     * @param	UserLogin $userLogin The userLogin object to remove.
     * @return User The current object (for fluent API support)
     */
    public function removeUserLogin($userLogin)
    {
        if ($this->getUserLogins()->contains($userLogin)) {
            $this->collUserLogins->remove($this->collUserLogins->search($userLogin));
            if (null === $this->userLoginsScheduledForDeletion) {
                $this->userLoginsScheduledForDeletion = clone $this->collUserLogins;
                $this->userLoginsScheduledForDeletion->clear();
            }
            $this->userLoginsScheduledForDeletion[]= $userLogin;
            $userLogin->setUser(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->user_id = null;
        $this->user_fname = null;
        $this->user_mname = null;
        $this->user_lname = null;
        $this->user_login = null;
        $this->user_password = null;
        $this->user_email = null;
        $this->user_gender = null;
        $this->user_birth_date = null;
        $this->user_age = null;
        $this->user_phone = null;
        $this->user_company_key = null;
        $this->user_role = null;
        $this->user_status = null;
        $this->user_added_by = null;
        $this->user_date_added = null;
        $this->user_date_lastlogin = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collUserLogins) {
                foreach ($this->collUserLogins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCompany instanceof Persistent) {
              $this->aCompany->clearAllReferences($deep);
            }
            if ($this->aUserLevel instanceof Persistent) {
              $this->aUserLevel->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collUserLogins instanceof PropelCollection) {
            $this->collUserLogins->clearIterator();
        }
        $this->collUserLogins = null;
        $this->aCompany = null;
        $this->aUserLevel = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
