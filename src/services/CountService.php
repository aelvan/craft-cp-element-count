<?php

/**
 * CP Element Count plugin for Craft CMS 3.x
 *
 * @link      https://www.vaersaagod.no/
 * @copyright Copyright (c) 2018 André Elvan
 */

namespace aelvan\cpelementcount\services;

use craft\base\Component;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\User;

/**
 * CpElementCountService Service
 *
 * @author    André Elvan
 * @package   CpElementCount
 * @since     1.0.0
 */
class CountService extends Component
{
    public function getEntriesCount($slugs = []): array
    {
        if (count($slugs) === 0) {
            return [];
        }

        $r = [];

        foreach ($slugs as $slug) {
            $count = Entry::find()->section($slug)->limit(null)->status(['disabled', 'enabled'])->count();
            $r[$slug] = $count;
        }

        $count = Entry::find()->limit(null)->status(['disabled', 'enabled'])->count();
        $r['*'] = $count;

        return $r;
    }

    public function getCategoriesCount($slugs = []): array
    {
        if (count($slugs) === 0) {
            return [];
        }

        $r = [];

        foreach ($slugs as $slug) {
            $count = Category::find()->groupId($slug)->limit(null)->status(['disabled', 'enabled'])->count();
            $r[$slug] = $count;
        }

        return $r;
    }

    public function getUsersCount($ids = []): array
    {
        if (count($ids) === 0) {
            return [];
        }

        $r = [];

        foreach ($ids as $id) {
            $count = User::find()->groupId($id)->limit(null)->status(null)->count();
            $r[$id] = $count;
        }
        
        $count = User::find()->limit(null)->status(null)->count();
        $r['*'] = $count;

        $count = User::find()->admin(true)->limit(null)->status(null)->count();
        $r['admins'] = $count;

        return $r;
    }

    public function getAssetsCount($folders = []): array
    {
        if (count($folders) === 0) {
            return [];
        }

        $r = [];

        foreach ($folders as $folder) {
            $arr = explode('|', $folder);
            $count = Asset::find()->folderId($arr[count($arr)-1])->includeSubfolders(false)->limit(null)->count();
            $r[$folder] = $count;
        }
        
        return $r;
    }

}
