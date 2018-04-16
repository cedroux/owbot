<?php

namespace Bot;

use Exception;

/**
 * Class Database
 *
 * @see https://github.com/domnikl/DesignPatternsPHP/blob/master/Creational/Singleton/Singleton.php
 * @package Bot
 */
final class Database
{
    /**
     * @var Database Singleton
     */
    private static $instance;

    /**
     * @var string Database file path
     */
    public $path = '';

    /**
     * @var array Database container
     */
    public $data = [];

    /**
     * Prevent multiple instances
     */
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    /**
     * Gets the instance via lazy initialization (created on first usage)
     *
     * @return Database
     * @throws Exception
     */
    public static function getInstance(): Database
    {
        if (null === static::$instance) {
            $config = require __DIR__ . '/../config/config.php';

            static::$instance = new static();
            static::$instance->path = $config['db_path'];
            static::$instance->loadDB();
        }

        return static::$instance;
    }

    /**
     * Description
     *
     * @throws Exception
     */
    private function loadDB()
    {
        $db = self::getInstance();

        if (!file_exists($db->path)) {
            $handle = fopen($db->path, 'w');
            if ($handle === false) {
                throw new Exception('Impossible de créer la base');
            }
            fclose($handle);
        }
        $file = file_get_contents($db->path);

        if ($file === false) {
            throw new Exception('Erreur lors de la lecture de la base');
        }

        $db->data = json_decode($file);
    }

    /**
     * Save the DB to the file system
     *
     * @return bool
     * @throws Exception
     */
    private function saveDB()
    {
        $db = self::getInstance();

        $json = json_encode($db->data, JSON_UNESCAPED_UNICODE);
        $r = file_put_contents($db->path, $json);
        if ($r === false) {
            throw new Exception('Erreur lors de la l\'écriture de la base');
        }

        return true;
    }

    /**
     * DB getter
     * Example :
     *  $db->select() // return the full database
     *  $db->select('battletag', 'Test#123') // Return specific player
     *
     * @param string|null $where
     * @param string|null $search
     * @return mixed
     * @throws Exception
     */
    static public function select($where = null, $search = null)
    {
        $db = self::getInstance();

        if (!isset($db->data)) {
            return null;
        }
        if ($where && $search) {
            foreach ($db->data as $item) {
                if (isset($item->$where) && $item->$where == $search) {
                    return $item;
                }
            }

            return null;
        }

        return $db->data;
    }

    /**
     * Update
     *
     * @param string $value
     * @param string $where
     * @param string $search
     * @return mixed
     * @throws Exception
     */
    static public function update($value, $where, $search)
    {
        $db = self::getInstance();

        foreach ($db->data as &$item) {
            if (isset($item->$where) && $item->$where == $search) {
                $item = (object)$value;

                return $db->saveDB();
            }
        }

        return false;
    }

    /**
     * Description
     *
     * @param mixed $value
     * @return bool
     * @throws Exception
     */
    static public function insert($value)
    {
        $db = self::getInstance();

        $db->data[] = (object)$value;

        return $db->saveDB();
    }

    /**
     * Description
     *
     * @param string $where
     * @param string $search
     * @return bool
     * @throws Exception
     */
    static public function delete($where, $search)
    {
        $db = self::getInstance();

        $item = self::select($where, $search);

        if (($key = array_search($item, $db->data, false)) !== false) {
            unset($db->data[$key]);
            $db->data = array_values($db->data);
        }

        return $db->saveDB();
    }
}
