<?php
    define('BASEDIR', dirname(__FILE__, 2));
    define('VIEWS', BASEDIR . '/View/modules/');

    $_ENV['db']['host'] = "localhost:3306";
    $_ENV['db']['user'] = "root";
    $_ENV['db']['pass'] = "Eduardo@mysql";
    $_ENV['db']['database'] = "db_jahuepi";