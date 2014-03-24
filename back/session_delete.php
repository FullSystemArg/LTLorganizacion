<?php
require_once("class/functions.class.php");
session_destroy();
header("location:login.php");