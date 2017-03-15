<?php
/**
 * Created by PhpStorm.
 * User: Astrid D
 * Date: 20.01.2017
 * Time: 13:53
 */

session_start();
unset($_SESSION['b_id']);

header('Location: ..\\index.html');