<?php

function db_connect() {
    try { 
        $dbh = new PDO(
            'mysql:host=' . DB_HOST .
            ';port=' . DB_PORT .
            ';dbname=' . DB_DATABASE,
            DB_USER,
            DB_PASS
        );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $e) {
        // Optionally log connection error or set global error flag
        return null;
    }
}
