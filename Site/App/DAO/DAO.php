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