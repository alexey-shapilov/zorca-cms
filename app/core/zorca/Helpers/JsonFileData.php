<?php

namespace Zorca\Helpers;

/**
 * Class JsonFileData
 *
 * [en] Data managing class
 * [ru] Менджер данных
 *
 * @package Zorca\Helpers
 */
class JsonFileData extends JsonFile {
    /**
     * @param $name
     *
     * @return \Zorca\Helpers\JsonFileData
     */
    public static function table($name)
    {
        $file       = new JsonFileData;
        $file->name = $name;
        $file->setType('data');

        return $file;
    }

}