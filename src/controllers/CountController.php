<?php

/**
 * CP Element Count plugin for Craft CMS 3.x
 *
 * @link      https://www.vaersaagod.no/
 * @copyright Copyright (c) 2018 André Elvan
 */

namespace aelvan\cpelementcount\controllers;

use Craft;
use craft\elements\Asset;
use craft\web\Controller;

use aelvan\cpelementcount\CpElementCount as Plugin;

/**
 * Class CountController
 *
 * @package aelvan\cpelementcount\controllers
 */
class CountController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var array
     */
    protected $allowAnonymous = true;

    // Public Methods
    // =========================================================================

    public function actionGetEntriesCount()
    {
        $config = Plugin::$plugin->getSettings();
        $request = Craft::$app->getRequest();
        $uids = $request->getParam('uids', []);
        
        $counts = Plugin::$plugin->count->getEntriesCount($uids);
        
        return $this->asJson($counts);
    }

    public function actionGetCategoriesCount()
    {
        $config = Plugin::$plugin->getSettings();
        $request = Craft::$app->getRequest();
        $uids = $request->getParam('uids', []);
        
        $counts = Plugin::$plugin->count->getCategoriesCount($uids);
        
        return $this->asJson($counts);
    }

    public function actionGetUsersCount()
    {
        $config = Plugin::$plugin->getSettings();
        $request = Craft::$app->getRequest();
        $uids = $request->getParam('uids', []);
        
        $counts = Plugin::$plugin->count->getUsersCount($uids);
        
        return $this->asJson($counts);
    }

    public function actionGetAssetsCount()
    {
        $config = Plugin::$plugin->getSettings();
        $request = Craft::$app->getRequest();
        $folders = $request->getParam('folders', []);
        
        $counts = Plugin::$plugin->count->getAssetsCount($folders);
        
        return $this->asJson($counts);
    }
}
