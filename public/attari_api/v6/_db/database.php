<?php
/**
 * Created by CH Arbaz Mateen.
 * User: Arbaz Mateen
 * Date: 02-Jan-2019
 * Time: 10:30 AM
 * Desc: Database class for database related task.
 */

require_once("constants.php");

defined('OK') ? null : define("OK", 1);
defined('ALREADY_EXISTS') ? null : define("ALREADY_EXISTS", 2);
defined('DATA_EMPTY') ? null : define("DATA_EMPTY", 3);
defined('NOT_VALID') ? null : define("NOT_VALID", 4);
defined('NOT_OK') ? null : define("NOT_OK", 5);
defined('ALREADY_LOGED_IN') ? null : define("ALREADY_LOGED_IN", 6);
defined('IN_USE') ? null : define("IN_USE", 7);

defined('LIMIT') ? null : define("LIMIT", 50);

class Database
{
    private $connection;

    function __construct()
    {
        $this->open_connection();
    }

    public function open_connection()
    {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->connection, 'utf8');
        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
        }
    }

    public function close_connection()
    {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($query)
    {
        $result = mysqli_query($this->connection, $query);
        $this->confirm_query($result, $query);
        return $result;
    }

    private function confirm_query($res, $que)
    {
        if (!$res) {
            die("Database query failed. >>> Error: " . mysqli_error($this->connection) . ". >>> Query: " . $que);
        }
    }

    public function escape_value($string)
    {
        $escape_string = mysqli_real_escape_string($this->connection, $string);
        return $escape_string;
    }

    public function begin_trans() {
        mysqli_autocommit($this->connection, false);
        mysqli_begin_transaction($this->connection);
    }

    public function commit() {
        mysqli_commit($this->connection);
    }

    public function rollBack() {
        mysqli_rollback($this->connection);
    }

    public function fetch_array($result_set)
    {
        return mysqli_fetch_array($result_set);
    }

    public function fetch_assoc($result_set)
    {
        return mysqli_fetch_assoc($result_set);
    }

    public function num_rows($result_set)
    {
        return mysqli_num_rows($result_set);
    }

    public function inserted_id()
    {
        // last inserted id
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }

}

$database = new Database();


