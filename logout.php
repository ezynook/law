<?php
    //Clear Cookies and Logout
    session_start();
    foreach ($_COOKIE as $name => $value) {
        setcookie($name, '', 1);
        setcookie("PHPSESSID", "", time() - 3600, '/');
    }
    session_destroy();
    echo "<script>window.location.href='Auth'</script>";
?>