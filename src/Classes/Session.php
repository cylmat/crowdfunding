<?php declare(strict_types = 1);

namespace Classes;

/**
 * Class de session
 */
class Session
{
    static function start(): void
    {
        if(!isset($_SESSION)) {
            session_start();
        }
    }

    static function getSessionId()
    {
        self::start();
        return session_id();
    }

    static function destroy(): void
    {
        unset($_SESSION);
        session_destroy();
    }

    static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    static function get(string $key)
    {
        self::start();
        if(!empty($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }
}
