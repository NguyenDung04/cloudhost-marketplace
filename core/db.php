<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once('config.php');
require_once('rsa.php');
require_once('vps.php');
// require_once('cloud-vps.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
$mail = new PHPMailer(true);
$ketnoi = new teamapiit();
$rsa = new RSA();
$now = time();
$ip = $_SERVER['REMOTE_ADDR'];
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['session'])) {
    $session = $_SESSION['session'];
    $user = $ketnoi->get_row("SELECT * FROM `users` WHERE `session_token` = '$session'");
    $username = isset($user['username']) ? $user['username'] : null;
} else {
    $user = null;
    $username = null;
}

require_once('function.php');
?>