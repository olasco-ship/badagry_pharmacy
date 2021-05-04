<?php

require_once("initialize.php");


class CaseNote extends DatabaseObject
{
    public static $table_name = "caseNote";
    protected static $db_fields = array('id', 'sync', 'patient_id', 'waiting_list_id', 'ref_adm_id', 'sub_clinic_id',
        'complains', 'hpc', 'duration', 'sys_review', 'examination', 'diagnosis', 'differentials', 'note',
        'consultant', 'status', 'date');



    public $id;
    public $sync;
    public $patient_id;
    public $waiting_list_id;
    public $ref_adm_id;
    public $sub_clinic_id;
    public $complains;
    public $hpc;
    public $duration;
    public $sys_review;
    public $examination;
    public $diagnosis;
    public $differentials;
    public $note;
    public $consultant;
    public $status;
    public $date;

    public static function find_by_waiting_list_id($id=0){
        global $database;
        $result_array = static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE waiting_list_id=".$database->escape_value($id));
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    }

    public static function find_open_case_note($waiting_list, $patient_id){
        $result_array = static::find_by_sql("SELECT * FROM " .static::$table_name. " WHERE waiting_list_id = $waiting_list AND patient_id = $patient_id AND status = 'OPEN' " );
        return !empty($result_array) ? array_shift($result_array) : FALSE;
    }

    public static function find_patient_case_note($patient_id)
    {
        return static::find_by_sql("SELECT * FROM " .static::$table_name . " WHERE patient_id= '{$patient_id}' ORDER BY date DESC LIMIT 20 " );
    }


    public static function create_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . CaseNote::$table_name . '(' .
            'id INT(11) NOT NULL AUTO_INCREMENT, ' .
            'sync VARCHAR(20) NOT NULL, ' .
            'patient_id INT(11) NOT NULL, ' .
            'waiting_list_id INT(11) NOT NULL, ' .
            'ref_adm_id INT(11) NOT NULL, ' .
            'sub_clinic_id INT(11) NOT NULL, ' .

            'complains TEXT NOT NULL, ' .
            'hpc TEXT NOT NULL, ' .
            'duration TEXT NOT NULL, ' .
            'sys_review TEXT NOT NULL, ' .
            'examination TEXT NOT NULL, ' .
            'diagnosis TEXT NOT NULL, ' .
            'differentials TEXT NOT NULL, ' .
            'note TEXT NOT NULL, ' .

            'consultant  VARCHAR(50) NOT NULL, ' .
            'status VARCHAR(50) NOT NULL, ' .
            'date DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';

        CaseNote::run_script($sql);
    }


    // Common Database Methods in the Parent class(DatabaseObject)


}

CaseNote::create_table();