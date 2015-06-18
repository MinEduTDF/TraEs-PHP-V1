<?php
/**
 * @author Enrique Nicolas Colasurdo
 * @package Classes
 * @version 1.0
 */

include_once($APP_PATH . "/Classes/Configuration.php");

class Connection
{
    var $server = "";
    var $user = "";
    var $password = "";
    var $db = "";
    var $conf, $conn, $database;

    /**
     * Constructor
     * @property string $server Database Host
     * @property string $user Database User Name
     * @property string $password Database Password
     * @property string $db Database
     */
    function __construct()
    {
        $conf = new Configuration();
        $this->server = $this->server=="" ? $conf->server : $this->server;
        $this->user = $this->user=="" ? $conf->user : $this->user;
        $this->password = $this->password=="" ? $conf->password : $this->password;
        $this->db = $this->db=="" ? $conf->db : $this->db;
    }

    /**
     * Abre la Conexion con la Base de Datos
     */
    function open()
    {
        $this->conn = mysql_connect($this->server,$this->user,$this->password, false, 65536);
        $database = mysql_select_db($this->db,$this->conn);
    }

    /**
     * Cierra la Conexion con la Base de Datos
     */
    function close()
    {
        mysql_close($this->conn);
    }

    /**
     * Comienza una Transaccion
     */
    function begin_tran()
    {
        @mysql_query("START TRANSACTION",$this->conn);
    }

    /**
     * Confirma la Transacci&oacute;n
     */
    function commit()
    {
        @mysql_query("COMMIT",$this->conn);
    }

    /**
     * Cancela la Transaccion
     */
    function rollback()
    {
        @mysql_query("ROLLBACK",$this->conn);
    }
}
?>