<?php
/**
 * [en] Define directory separator
 * [ru] Устанавливаем разделительный знак для путей
 **/
define('DS', '/');
/**
 * [en] Define the path to the root directory, including the slash at the end
 * [ru] Устанавливаем корневую папку сервера со слешем в конце
 **/
define('BASE', str_replace(DIRECTORY_SEPARATOR, DS, __DIR__ . DS));
/**
 * [en] Define the path to the main app directory, including the slash at the end
 * [ru] Устанавливаем основную папку CMS
 **/
define('APP', BASE . 'app' . DS);
/**
 * [en] Define the path to the config & database directory, including the slash at the end
 * [ru] Устанавливаем папку для хранения конфигурации и базы данных CMS
 **/
define('DATA', BASE . 'data' . DS);
/**
 * [en] Define the path to the public assets directory, including the slash at the end
 * [ru] Устанавливаем публичную папку для хранения картинок, стилей и скриптов, показываемых клиенту
 **/
define('PUB', BASE . 'pub' . DS);