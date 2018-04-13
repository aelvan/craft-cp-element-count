<?php

/**
 * CP Element Count plugin for Craft CMS 3.x
 *
 * @link      https://www.vaersaagod.no/
 * @copyright Copyright (c) 2018 André Elvan
 */

namespace aelvan\cpelementcount\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class CpElementCountAssetBundle extends AssetBundle
{

    public function init()
    {
        $this->sourcePath = '@cpelementcount/resources';

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'cpelementcount.js',
        ];

        $this->css = [
            'cpelementcount.css',
        ];

        parent::init();
    }
}
