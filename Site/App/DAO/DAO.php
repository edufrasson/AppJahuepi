<?php

namespace App\DAO;

use Exception;
use \PDO;
use PDOException;

abstract class DAO
{
    protected $conexao;

    public function __construct()
    {
        try
        {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES uft8'
            ];

            $dsn = "mysql:host=" . $_ENV['db']['host'] . ";dbname" . $_ENV['db']['database'];

            $this->conexao = new PDO(
                $dsn,
                $_ENV['db']['user'],
                $_ENV['db']['user'],
                $options);
        }   
        catch (PDOException $e)
        {
            throw new Exception("Ocorreu um erro ao tentar conectar ao MySQL", 0 ,$e);
        }
    }
}