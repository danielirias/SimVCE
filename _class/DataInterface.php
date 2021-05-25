<?php

    class DataInterface
    {
        public $DConn;
        const SIMPLE_ARRAY = 'SIMPLE_ARRAY';
        const JSON_OBJECT = 'JSON_OBJECT';

        public function __construct() //constructor de la clase DataInterface
        {
            $this->DHost = "db5002131193.hosting-data.io";
            $this->DUser = "dbu842103";
            $this->DPass = "passAdminCE@1979";
            $this->DData = "dbs1729084";
            $this->DPort = "3306";

            $this->DConn = null;
            $this->Query = null;
        }

        public function OpenConnection()
        {
            $this->DConn = new mysqli($this->DHost, $this->DUser, $this->DPass, $this->DData, $this->DPort);
            $this->DConn->query("SET NAMES 'utf8'");
            if ($this->DConn->connect_error)
            {
                $logTime = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
                $path = "../_log/log_connection.log";
                $error_msg =
                    "=============================================================================================================================".
                    "\nDATE TIME  :  ".$logTime.
                    "\nERROR      :  ".$this->DConn->connect_errno." - ".$this->DConn->connect_error;
                error_log($error_msg."\n\n", 3, $path);

                exit();
            }
        }

        public function CloseConnection()
        {
            $this->DConn->close();
        }

        public function DoSelect($SQL_QUERY, $ArrayFormat)//funcion miembro de la clase DbInterface que retorna el resultado de la consulta
        {
            //Creo la conexión
            $this->OpenConnection();

            //funcion que ejecuta la consulta en el motor de bases de datos
            $this->Query = $this->DConn->query($SQL_QUERY);

            $resultSet = array(); //Arreglo para mantener los datos de la tabla

            while($myData = $this->Query->fetch_assoc())
            {
                //Lleno el arreglo con los registros
                $resultSet[] = $myData;
            }

            $this->CloseConnection(); //Cierro la conexión

            $logTime = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
            $path = "../_log/log_DDL.log";
            $error_msg =
                "=============================================================================================================================".
                "\nDATE TIME  :  ".$logTime.
                "\nQUERY      :  ".$SQL_QUERY;

            //error_log($error_msg."\n\n", 3, $path);


            if($ArrayFormat == DataInterface::SIMPLE_ARRAY)
            {
                //Formato del resultado en un Array simple
                // Por default el resultado ya es un Array por lo que no es necesario alterarlo
            }
            if($ArrayFormat == DataInterface::JSON_OBJECT)
            {
                //Formato del resultado en un formato JSON
                $resultSet = json_encode($resultSet, JSON_PRETTY_PRINT);
            }

            return $resultSet; //Devuelvo el arreglo de datos
        }

        public function DoCUD($SQL_QUERY)
        {
            //Recibe Insert, Update y Delete
            $this->OpenConnection();
            $this->DConn->query("SET NAMES 'utf8'");
            $this->DConn->query($SQL_QUERY) === TRUE;
            $this->CloseConnection(); //Cierro la conexión

            $logTime = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
            $path = "../_log/log_DDL.log";
            $error_msg =
                "=============================================================================================================================".
                "\nDATE TIME  :  ".$logTime.
                "\nQUERY      :  ".$SQL_QUERY;

            //error_log($error_msg."\n\n", 3, $path);
        }
    }