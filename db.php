<?php

$db = null;

function getConnection() {
    global $db;
    if (is_null($db)) {
        $dsn = getenv("DATABASE_URL");

        $database_connect = parse_url($dsn);
        $host = $database_connect["host"];
        $port = $database_connect["port"];
        $user = $database_connect["user"];
        $pass = $database_connect["pass"];
        $database = ltrim($database_connect["path"], '/');

        return new PDO("pgsql:host=".$host.";port=".$port.";dbname=".$database,
            $user,$pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }
}