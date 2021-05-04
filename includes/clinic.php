<?php


require_once("initialize.php");

class Clinic extends DatabaseObject
{
    protected static $table_name = "clinic";
    protected static $db_fields = array('id', 'sync', 'name', 'date');
    public $id;
    public $sync;
    public $name;
    public $date;

    public static function create_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . Clinic::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'sync VARCHAR(20) NOT NULL, ' .
            'name VARCHAR(100) NOT NULL, ' .
            'date DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';
        //    'UNIQUE KEY(revenue_code))';
        Clinic::run_script($sql);
    }


}

Clinic::create_table();




