<?php
// config/helpers.php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php?action=login');
        exit;
    }
}
?>