<?php


class MedicalReports extends DatabaseObject
{

    protected static $table_name = "medical_reports";
    protected static $db_fields = array('id', 'sync', 'patient_id', 'result', 'doctor', 'date');

    public $id;
    public $sync;
    public $patient_id;
    public $result;
    public $doctor;
    public $date;




public static function find_by_patient_id($patient_id){

      $result_array = static::find_by_sql(" SELECT * FROM " .static::$table_name . " WHERE id = ''");

         return !empty($result_array) ? array_shift($result_array) : FALSE;


    }

public static function find_withjoin($patient_id){

      $result_array = static::find_by_sql(" SELECT * FROM medical_reports m left join patients p on m.patient_id = p.id WHERE id = ''");
      var_dump($result_array);exit;

         return !empty($result_array) ? array_shift($result_array) : FALSE;


    }

    public static function find_medical_id(){
        return static::find_by_sql("SELECT * FROM " .static::$table_name . " ORDER BY id DESC");
    }



/* public static function find_by_sql(){

        $sql = "SELECT * FROM medical_reports m left join patients p on p.id = m.patient_id LIMIT 1";

         $result_array = MedicalReports::find_by_sql($sql);
       //var_dump($result_array);exit;

         return !empty($result_array) ? array_shift($result_array) : FALSE;
    }*/



    public static function create_table(){
        $sql = 'CREATE TABLE IF NOT EXISTS '. MedicalReports::$table_name . '('.
            'id INT NOT NULL AUTO_INCREMENT, ' .
            'sync VARCHAR(20) NOT NULL, ' .
            'patient_id INT NOT NULL, ' .
            'result TEXT NOT NULL, '.
            'doctor VARCHAR(50) NOT NULL, ' .
            'date DATETIME NOT NULL, ' .
            'PRIMARY KEY(id))';

        MedicalReports::run_script($sql);

    }
}

MedicalReports::create_table();