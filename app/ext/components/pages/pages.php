<?php
namespace Zorca\Ext;

use Symfony\Component\HttpFoundation\Response;
use ParsedownExtra;
use Zorca\Theme;
use Zorca\Scss;

/**
 * Class PagesExt
 *
 * @package Zorca\Ext
 */
class PagesExt {
    /**
     * @param $extRequest
     * @param $extAction
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function run($extRequest, $extAction) {
        $responseStatus = '200';
        $parsedown = new ParsedownExtra();
        $pageContentFilePath = DATA . 'ext/components/pages' . DS . $extAction . '.md';
        if (!file_exists($pageContentFilePath)) {
            $pageContentFilePath = APP . 'ext/components/pages/content/404.md';
            $responseStatus = '404';
        }
        $pageContent = $parsedown->text(file_get_contents($pageContentFilePath));
        $menuContent = MenuMod::load('pages', 'menuMain', 'horizontal');
        $scss = new Scss();
        $scss->setImportPaths([BASE . 'app/design/themes/default/styles', BASE . 'app/core/oxi', BASE . 'app/design/skeletons']);
        $scss->compileFile([BASE. 'app/design/themes/default/styles/main.scss'], BASE. 'pub/styles/main.css');
        $renderedPage = Theme::render(['menuContent' => $menuContent, 'pageContent' => $pageContent, 'skeleton' => 'default'], '', 'pages');
        $response = new Response($renderedPage, $responseStatus);
        return $response;
    }
}