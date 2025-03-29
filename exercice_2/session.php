<?php

/**
 * this class represents a session
 * singleton design to ensure only one instance of the session is created
 */
class Session {
    /**
     *@var Session|null singleton instance of Session.
     */
    private static $instance = null;

    private function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @return Session returns the singleton instance of the Session class.
     * if the instance does not exist, it creates a new one.
     */
    public static function getInstance(): Session {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    /**
     * @param string $key The key to store the value under.
     * @param mixed $value The value to store (string, int, array, object, etc.).
     * @return void
     */
    public function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key The key to retrieve.
     * @return mixed the stored value or null.
     */
    public function get(string $key): mixed {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key The key to check.
     * @return bool true if the key exists, false otherwise.
     */
    public function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key The key to remove.
     * @return void
     */
    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public function destroy(): void {
        session_unset();
        session_destroy();
        self::$instance = null;
    }
}

