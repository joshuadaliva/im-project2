<?php

    require("../database/config.php");

    if ($_SERVER["user_type"] != "admin") {
        header('Location: addon/hecker.php'); 
        exit;
    }


?>