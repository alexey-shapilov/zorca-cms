<?php

namespace Zorca\Helpers;

/**
 * Interface DataBaseInterface
 *
 * [en] Database interface
 * [ru] Интерфейс для работы с базой данных JSON
 *
 * @package Zorca\Helpers
 */
interface DataBaseInterface {

    /**
     * [en] Setting name of data table
     * [ru] Устанавливаем имя таблицы данных
     *
     * @param $name
     *
     * @return mixed
     */
    public static function table($name);

    /**
     * [en] Set the file type
     * [ru] Устанавливаем тип файла базы данных
     *
     * @param $type
     *
     * @return mixed
     */
    public function setType($type);

    /**
     * [en] Returning path to file
     * [ru] Возвращает путь к файлу
     *
     * @return mixed
     */
    public function getPath();

    /**
     * [en] Return decoded JSON
     * [ru] Получает декодированный JSON в виде массива
     *
     * @param bool|false $assoc
     *
     * @return mixed
     */
    public function get($assoc = false);

    /**
     * [en] Saving encoded JSON to file
     * [ru] Сохраняет декодированные данные из массива в файл JSON
     *
     * @param $data
     *
     * @return mixed
     */
    public function put($data);

    /**
     * [en] Checking that file exists
     * [ru] Проверяет существование файла
     *
     * @return mixed
     */
    public function exists();

    /**
     * [en] Removing file
     * [ru] Удаляет файл
     *
     * @return mixed
     */
    public function remove();
}
