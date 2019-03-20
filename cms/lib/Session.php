<?php

/**
 * Mahadi HaSAN
 */
class Session
{
    public static function init()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }


    // End init function
    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    // End set function
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    // End get fucntion
    public static function checkSession()
    {
        if (self::get("login") == false) {
            self::destroy();
            echo "<script>location.href='login.php'</script>";
        }
    }


    public static function checkLogin()
    {
        if (self::get("login") == true) {
            echo "check login status";
            echo "<script>location.href='index.php'</script>";
        }
    }

    public static function checkLoginActive()
    {
        if (self::get("login") == true) {
            echo "check login status";
            echo "<script>location.href='shop.php'</script>";
        }
    }

    public static function destroy()
    {
        session_destroy();
        session_unset();
        echo "<script>location.href='login.php'</script>";
    }

    public static function destroySell()
    {
        session_destroy();
        session_unset();
        echo "<script>location.href='shop_public.php'</script>";
    }

    public static function destroySellCat()
    {
        session_destroy();
        session_unset();
        echo "<script>location.href='announce.php'</script>";
    }
}

?>