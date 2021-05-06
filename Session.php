<?php


namespace app\core;


/**
 * Class Session
 * @package app\core
 */
class Session
{
    /**
     * Property to store all flash messages
     * in super global array $_SESSION
     */
    protected const FLASH_KEY = 'flash_messages';

    /**
     * Session constructor.
     */
    public function __construct()
    {
        // Start session
        session_start();
        // Get all flash messages
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // Mark each flash message as removed
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }
        // Set updated flash messages
        // array to flash key subarray
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Create new session flash
     * with given key and message
     * @param string $key
     * @param string $message
     */
    public function setFlash(string $key, string $message): void
    {
        // Add message with specified key
        // to FLASH_KEY in super global
        // session array $_SESSION
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message,
        ];
    }

    /**
     * Get flash message
     * with specified key
     * @param string $key
     * @return false|mixed
     */
    public function getFlash(string $key)
    {
        // Return the message from subarray FLASH_KEY
        // with specified key in super global array
        // $_SESSION or false if not exists
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     * Check if flash message with
     * specified key if exists
     * @param string $key
     * @return bool
     */
    public function hasFlash(string $key): bool
    {
        // Check flash massage of given key
        // in flash messages array is exists
        return isset($_SESSION[self::FLASH_KEY][$key]);
    }


    /**
     * Set session value
     * with given key
     * @param $key
     * @param $value
     */
    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value
     * with given key
     * @param $key
     * @return mixed|string
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? '';
    }

    /**
     * Remove session value
     * from $_SESSION
     * @param $key
     */
    public function remove($key): void
    {
        unset($_SESSION[$key]);

    }

    /**
     * Delete all flash messages
     * in the end of working
     */
    public function __destruct()
    {
        // Get all flash messages
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // Remove all flash messages that
        // are marked with 'remove'
        foreach ($flashMessages as $key => $flashMessage) {
            // Remove flash message if 'remove' is true
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        // Set updated flash messages
        // array to flash key subarray
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}