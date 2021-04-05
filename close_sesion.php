<?php
    session_start();
    setcookie("id_sesion", "", time() + 1, "/");
    setcookie("grupo", "", time() + 1, "/");
    setcookie("reminder", "", time() + 1, "/");
    session_destroy();
    header("Location: ../Horarios/");
?>