<?php
if (!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['error'])) {
    echo '<div class="error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
require_once 'Vista/vistaLogin.php';
?>