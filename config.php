<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 $dsn="mysql:host=localhost;dbname=automobile";
 $user="root";
 $passe="";
 $db=NEW PDO($dsn,$user,$passe);
?>