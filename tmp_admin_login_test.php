<?php
$_SERVER["HTTP_HOST"] = "njengasam.com";
$_SERVER["REQUEST_URI"] = "/admin/login.php";
$_SERVER["HTTPS"] = "on";
$_SERVER["DOCUMENT_ROOT"] = "C:/xampp/htdocs/work_folder/portfolio";
ob_start();
include "admin/login.php";
$out = ob_get_clean();
echo substr($out, 0, 1000);
