<?php

namespace App\DAO;

use Exception;
use \PDO;
use PDOException;

abstract class DAO
{
    private static $conexao = null;

    public function __construct()
    {
        try
        {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ];

            $dsn = "mysql:host=" . $_ENV['db']['host'] . ";dbname=" . $_ENV['db']['database'];

            self::$conexao = (self::$conexao == null) ? new PDO(
                $dsn,
                $_ENV['db']['user'],
                $_ENV['db']['pass'],
                $options) :  self::$conexao;

                $stmt = $this->getConnection()->prepare("SET lc_time_names = 'pt_BR'; SET GLOBAL sql_mode='STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_ENGINE_SUBSTITUTION'; "); 
                $stmt->execute();  
        }   
        catch (PDOException $e)
        {
            throw new Exception("Ocorreu um erro ao tentar conectar ao MySQL", 0 ,$e);
        }
    }

    protected function getConnection(){
        return self::$conexao;
    }
}