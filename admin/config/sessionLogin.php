<?php
session_start();

if($_SESSION['loginAdmin']==false){
    header('location: loginAdmin.php');
}