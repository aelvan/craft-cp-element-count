<?php

/**
 * CP Element Count plugin for Craft CMS 3.x
 *
 * @link      https://www.vaersaagod.no/
 * @copyright Copyright (c) 2018 André Elvan
 */

namespace aelvan\cpelementcount\services;

use Craft;
use craft\base\Component;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\User;
use craft\services\UserGroups;

/**
 * CpElementCountService Service
 *
 * @author    André Elvan
 * @package   CpElementCount
 * @since     1.0.0
 */
class CountService extends Component
{
    public function getEntriesCount($uids = []): array
    {
        if (count($uids) === 0) {
            return [];
        }

        $r = [];

        foreach ($uids as $uid) {
            $section = Craft::$app->getSections()->getSectionByUid($uid);
            $count = Entry::find()->sectionId($section->id)->limit(null)->status(['disabled', 'enabled'])->count();
            $r[$uid] = $count;
        }

        $count = Entry::find()->limit(null)->status(['disabled', 'enabled'])->count();
        $r['*'] = $count;

        return $r;
    }

    public function getCategoriesCount($uids = []): array
    {
        if (count($uids) === 0) {
            return [];
        }

        $r = [];

        foreach ($uids as $uid) {
            $count = Category::find(['uid' => $uid])->limit(null)->status(['disabled', 'enabled'])->count();
            $r[$uid] = $count;
        }

        return $r;
    }

    public function getUsersCount($uids = []): array
    {
        if (count($uids) === 0) {
            return [];
        }

        $r = [];

        foreach ($uids as $uid) {
            $group = Craft::$app->getUserGroups()->getGroupByUid($uid);
            $count = User::find()->groupId($group->id)->limit(null)->status(null)->count();
            $r[$uid] = $count;
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
