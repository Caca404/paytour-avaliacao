<?php

namespace App\Conexao;

class Conexao{
    private static $instance;

    public static function getConn($caminhoDb){
        if(!isset(self::$instance)){
            try
            {
                self::$instance = new \PDO("sqlite:".$caminhoDb);
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch(\PDOException $exception)
            {
                throw $exception;
            }
        }
        return self::$instance;
    }
}