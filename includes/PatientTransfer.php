<?php


class PatientTransfer extends DatabaseObject
{
    protected static $table_name = "patient_transfer";
    protected static $db_fields = array('id', 'sync', 'patient_id', 'in_patient_id', 'transfer_purpose', 'transfer_from', 'transfer_to', 'date');

    public $id;
    public $sync;
    public $patient_id;
    public $in_patient_id;
    public $transfer_purpose;
    public $transfer_from;
    public $transfer_to;
    public $date;

    public static function find_by_in_patient_id($id){
        $sql = "SELECT * FROM " . static::$table_name . " WHERE in_patient_id = '{$id}'";
        //echo $sql;die;
        $result_array = PatientTransfer::find_by_sql($sql);
        return !empty($result_array) ? $result_array : FALSE;
    }

    public static function create_table(){

        $sql = 'CREATE TABLE IF NOT EXISTS ' . PatientTransfer::$table_name . '(' .
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'sync VARCHAR(20) NOT NULL, ' .
            'patient_id INT(11) NOT NULL, ' .
            'in_patient_id INT(11) NOT NULL, ' .
            'transfer_purpose VARCHAR(50) NOT NULL, ' .
            'transfer_from VARCHAR(50) NOT NULL, ' .
            'transfer_to VARCHAR(50) NOT NULL, ' .
            'date DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';
        PatientTransfer::run_script($sql);
    }
}

PatientTransfer::create_table();