<?php declare(strict_types = 1);

namespace Classes;

class Session 
{
    static function start()
    {
        session_start();
    }

    static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    static function get($key)
    {
        return $_SESSION[$key];
    }
}