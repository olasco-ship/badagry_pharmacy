<?php

/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 8/18/2017
 * Time: 10:33 PM
 */


class StoreCount extends DatabaseObject
{
    public static $table_name = "store_count";
    protected static $db_fields = array(
        'id', 'sync', 'counted_items', 'no_counted_items', 'incorrect_items', 'no_incorrect_items',
        'counted_by', 'remarks', 'date'
    );

    public $id;
    public $sync;
    public $counted_items;
    public $no_counted_items;
    public $incorrect_items;
    public $no_incorrect_items;
    public $counted_by;
    public $remarks;
    public $date;

    public static function find_all_by_date(){
        return static::find_by_sql("SELECT * FROM " .static::$table_name . " ORDER BY date DESC " );
    }

    public static function find_count_by_date($start_date, $end_date){
        return static::find_by_sql("SELECT * FROM " .static::$table_name . " WHERE date BETWEEN '$start_date' AND '$end_date' ORDER BY date DESC ");
    }

    public static function find_last_count()
    {
        $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " ORDER BY id DESC LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    }

    public static function lastCount()
    {
        $lastCount = StoreCount::find_last_count();
        $lCount    = date('Y-m-d', strtotime($lastCount->date));
        $today     = strftime("%Y-%m-%d", time());
        $datetime1 = new DateTime($lCount);
        $datetime2 = new DateTime($today);
        $interval  = $datetime1->diff($datetime2);
        return $dateInterval = $interval->format('%R%a');
    }

    /*
    public static function find_last_count(){
        return static::find_by_sql("SELECT * FROM " .static::$table_name . " ORDER BY id DESC LIMIT 1");
    }
    */




    public static function create_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . StoreCount::$table_name . '(' .
            'id INT(11) NOT NULL AUTO_INCREMENT, ' .
            'sync VARCHAR(20) NOT NULL, ' .
            'counted_items TEXT NOT NULL, ' .
            'no_counted_items INT(11) NOT NULL, ' .
            'incorrect_items TEXT NOT NULL, ' .
            'no_incorrect_items INT(11) NOT NULL, ' .
            'counted_by VARCHAR(50) NOT NULL, ' .
            'remarks TEXT NOT NULL, ' .
            'date  DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';
        StoreCount::run_script($sql);
    }


    // Common Database Methods in the Parent class(DatabaseObject)


}

StoreCount::create_table();
