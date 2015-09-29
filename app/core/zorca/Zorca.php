<?php
namespace Zorca;

use Slim\Slim;

/**
 * Class Zorca
 *
 * [en] Main Zorca CMS class
 * [ru] Основной класс Zorca CMS
 *
 * @package Zorca
 */
class Zorca extends Slim {

    /********************************************************************************
     * Instantiation and Configuration
     *******************************************************************************/

    /**
     * Zorca CMS Constructor
     * @param  array $userSettings Associative array of application settings
     */
    public function __construct(array $userSettings = [])
    {
        // Setup IoC container
        $this->container = new \Slim\Helper\Set();
        $this->container['settings'] = array_merge(static::getDefaultSettings(), $this->getZorcaConfig(), $userSettings);

        // Default environment
        $this->container->singleton('environment', function ($c) {
            return \Slim\Environment::getInstance();
        });

        // Default request
        $this->container->singleton('request', function ($c) {
            return new \Slim\Http\Request($c['environment']);
        });

        // Default response
        $this->container->singleton('response', function ($c) {
            return new \Slim\Http\Response();
        });

        // Default router
        $this->container->singleton('router', function ($c) {
            return new \Slim\Router();
        });

        // Default view
        $this->container->singleton('view', function ($c) {
            $viewClass = $c['settings']['view'];
            $templatesPath = $c['settings']['templates.path'];

            $view = ($viewClass instanceOf \Slim\View) ? $viewClass : new $viewClass;
            $view->setTemplatesDirectory($templatesPath);
            return $view;
        });

        // Default log writer
        $this->container->singleton('logWriter', function ($c) {
            $logWriter = $c['settings']['log.writer'];

            return is_object($logWriter) ? $logWriter : new \Slim\LogWriter($c['environment']['slim.errors']);
        });

        // Default log
        $this->container->singleton('log', function ($c) {
            $log = new \Slim\Log($c['logWriter']);
            $log->setEnabled($c['settings']['log.enabled']);
            $log->setLevel($c['settings']['log.level']);
            $env = $c['environment'];
            $env['slim.log'] = $log;

            return $log;
        });

        // Default mode
        $this->container['mode'] = function ($c) {
            $mode = $c['settings']['mode'];

            if (isset($_ENV['SLIM_MODE'])) {
                $mode = $_ENV['SLIM_MODE'];
            } else {
                $envMode = getenv('SLIM_MODE');
                if ($envMode !== false) {
                    $mode = $envMode;
                }
            }

            return $mode;
        };

        // Define default middleware stack
        $this->middleware = array($this);
        $this->add(new \Slim\Middleware\Flash());
        $this->add(new \Slim\Middleware\MethodOverride());

        // Make default if first instance
        if (is_null(static::getInstance())) {
            $this->setName('default');
        }
    }

    /**
     * [en] Get main Zorca CMS config form json-file: config.json
     * [ru] Получаем основную конфигурацию Zorca CMS из json-файла: config.json
     *
     * @return array|mixed
     */
    public function getZorcaConfig() {
        $zorcaConfigFilePath = DATA . 'config.json';
        if (file_exists($zorcaConfigFilePath)) $zorcaConfig = json_decode(file_get_contents($zorcaConfigFilePath), true); else $zorcaConfig = [];
        return $zorcaConfig;
    }

    /**
     * [en] Get extensions config from json-file: ext.json
     * [ru] Получаем конфигурацию расширений из json-файла: ext.json
     *
     * @return array|mixed
     */
    public function getExtConfig() {
        $zorcaConfigFilePath = DATA . 'ext.json';
        if (file_exists($zorcaConfigFilePath)) $zorcaConfig = json_decode(file_get_contents($zorcaConfigFilePath), true); else $zorcaConfig = [];
        return $zorcaConfig;
    }

    /**
     * [en] Get default Zorca CMS settings
     * [ru] Устанавливаем настройки Zorca CMS по-умолчанию
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return array_merge(parent::getDefaultSettings(),
            [
                'zorca.offline' => false,
                'zorca.mode' => 'development',
                'zorca.skeleton' => 'default',
                'zorca.palette' => 'default',
                'zorca.theme' => 'default',
                'zorca.skeletonAdmin' => 'default',
                'zorca.themeAdmin' => 'default',
                'zorca.paletteAdmin' => 'default'
            ]);
    }
}