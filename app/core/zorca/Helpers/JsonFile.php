<?php

namespace Zorca\Helpers;

use Zorca\DatabaseException;

/**
 * Class JsonFile
 *
 * @package Zorca\Helpers
 */
class JsonFile implements DataBaseInterface {

    /**
     * File name
     * @var string
     */
    protected $name;

    /**
     * File type (data|config)
     * @var string
     */
    protected $type;

    /**
     * @param $name
     *
     * @return \Zorca\Helpers\JsonFile
     */
    public static function table($name)
    {
        $file       = new JsonFile;
        $file->name = $name;

        return $file;
    }

    /**
     * @param $type
     */
    public final function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     * @throws \Zorca\DatabaseException
     */
    public final function getPath()
    {
        if (!defined('DATA'))
        {
            throw new DatabaseException('Please define constant DATA');
        }
        else if (!empty($this->type))
        {
            return DATA . $this->name . '.' . $this->type . '.json';
        }
        else
        {
            throw new DatabaseException('Please specify the type of database files in class: ' . __CLASS__);
        }
    }

    public final function get($assoc = false)
    {
        return json_decode(file_get_contents($this->getPath()), $assoc);
    }

    public final function put($data)
    {
        return file_put_contents($this->getPath(), json_encode($data, JSON_PRETTY_PRINT));
    }

    public final function exists()
    {
        return file_exists($this->getPath());
    }

    public final function remove()
    {
        $type = ucfirst($this->type);
        if ($this->exists())
        {
            if (unlink($this->getPath()))
                return TRUE;

            throw new DatabaseException($type . ': Deleting failed');
        }

        throw new DatabaseException($type . ': File does not exists');
    }

}