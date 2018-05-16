<?php

/**
 * CP Element Count plugin for Craft CMS 3.x
 *
 * @link      https://www.vaersaagod.no/
 * @copyright Copyright (c) 2018 André Elvan
 */

namespace aelvan\cpelementcount;

use Craft;
use craft\base\Plugin;
use craft\events\TemplateEvent;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\View;

use aelvan\cpelementcount\assetbundles\CpElementCountAssetBundle;
use aelvan\cpelementcount\services\CountService;

use yii\base\Event;
use yii\base\InvalidConfigException;

/**
 * @author    André Elvan
 * @package   CpElementCount
 * @since     1.0.0
 */
class CpElementCount extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * CpElementCount::$plugin
     *
     * @var CpElementCount
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::setAlias('@cpelementcount', __DIR__);

        // Register services
        $this->setComponents([
            'count' => CountService::class,
        ]);

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(
                Plugins::class,
                Plugins::EVENT_AFTER_LOAD_PLUGINS,
                function () {
                    $this->addTemplateEvents();
                }
            );
        }

    }

    private function addTemplateEvents()
    {
        // Register CP Asset bundle
        Event::on(View::class, View::EVENT_BEFORE_RENDER_TEMPLATE,
            function (TemplateEvent $event) {
                try {
                    Craft::$app->getView()->registerAssetBundle(CpElementCountAssetBundle::class);
                } catch (InvalidConfigException $e) {
                    Craft::error(
                        'Error registering AssetBundle - ' . $e->getMessage(),
                        __METHOD__
                    );
                }
            }
        );
    }
}
