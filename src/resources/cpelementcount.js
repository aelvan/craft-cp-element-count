$(document).ready(function () {
    var href = location.href;
    var urlInEntries = href.match(/\/entries/);
    var urlInCategories = href.match(/\/categories/);
    var urlInUsers = href.match(/\/users/);
    var urlInAssets = href.match(/\/assets/);

    var hasSections = $('#main-content.has-sidebar .sidebar li a[data-key]').filter(function () {
        return $(this).data('key').match(/section:\d+/);
    }).length > 0;

    var hasGroups = $('#main-content.has-sidebar .sidebar li a[data-key]').filter(function () {
        return $(this).data('key').match(/group:\d+/);
    }).length > 0;

    var hasFolders = $('#main-content.has-sidebar .sidebar li a[data-key]').filter(function () {
        return $(this).data('key').match(/folder:\d+/);
    }).length > 0;

    if (hasSections) {
        getEntriesCount();
    }

    if (urlInCategories && hasGroups) {
        getCategoriesCount();
    }

    if (urlInUsers && hasGroups) {
        getUsersCount();
    }

    if (urlInAssets && hasFolders) {
        getAssetsCount();
    }

    function addCountToAnchor(val, $anchor) {
        var $pill = $anchor.find('.cpelementcount-pill');

        if ($pill.length === 0) {
            $anchor.append('<span class="cpelementcount-pill">' + val + '</span>');
        } else {
            $pill.text(val);
        }
    }

    function getEntriesCount() {
        var uids = getSectionUids();

        Craft.postActionRequest('cp-element-count/count/get-entries-count', {uids: uids},
            function (result) {
                $.each(uids, function (i, val) {
                    if (typeof result[val] !== 'undefined') {
                        var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="section:' + val + '"]');
                        if ($anchor.length > 0) {
                            addCountToAnchor(result[val], $anchor);
                        }
                    }
                });

                if (typeof result['*'] !== 'undefined') {
                    var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="*"]');

                    if ($anchor.length > 0) {
                        addCountToAnchor(result['*'], $anchor);
                    }
                }
            }
        );
    }

    function getCategoriesCount() {
        var uids = getGroupUids();

        Craft.postActionRequest('cp-element-count/count/get-categories-count', {uids: uids},
            function (result) {
                $.each(uids, function (i, val) {
                    if (typeof result[val] !== 'undefined') {
                        var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="group:' + val + '"]');

                        if ($anchor.length > 0) {
                            addCountToAnchor(result[val], $anchor);
                        }
                    }
                });
            }
        );
    }

    function getUsersCount() {
        var uids = getGroupUids();

        Craft.postActionRequest('cp-element-count/count/get-users-count', {uids: uids},
            function (result) {
                $.each(uids, function (i, val) {
                    if (typeof result[val] !== 'undefined') {
                        var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="group:' + val + '"]');

                        if ($anchor.length > 0) {
                            addCountToAnchor(result[val], $anchor);
                        }
                    }
                });

                var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="*"]');
                if ($anchor.length > 0) {
                    addCountToAnchor(result['*'], $anchor);
                }

                var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="admins"]');
                if ($anchor.length > 0) {
                    addCountToAnchor(result['admins'], $anchor);
                }

            }
        );
    }

    function getAssetsCount() {
        var folders = getFolders();

        Craft.postActionRequest('cp-element-count/count/get-assets-count', {folders: folders},
            function (result) {
                $.each(folders, function (i, val) {
                    if (typeof result[val] !== 'undefined') {
                        var $anchor = $('#main-content.has-sidebar .sidebar li a[data-folder-id="' + val + '"]');

                        if ($anchor.length > 0) {
                            addCountToAnchor(result[val], $anchor);                            
                        }
                    }
                });

                var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="*"]');
                if ($anchor.length > 0) {
                    addCountToAnchor(result['*'], $anchor);
                }

                var $anchor = $('#main-content.has-sidebar .sidebar li a[data-key="admins"]');
                if ($anchor.length > 0) {
                    addCountToAnchor(result['admins'], $anchor);
                }

            }
        );
    }

    function getSectionUids() {
        var uids = [];

        $('#main-content.has-sidebar .sidebar li a[data-key]').each(function () {
            if ($(this).data('key').match(/section:/)) {
                uids.push($(this).data('key').replace('section:', ''));
            }
        });

        return uids;
    }

    function getGroupUids() {
        var uids = [];

        $('#main-content.has-sidebar .sidebar li a[data-key]').each(function () {
            if ($(this).data('key').match(/group:/)) {
                uids.push($(this).data('key').replace('group:', ''));
            }
        });

        return uids;
    }

    function getFolders() {
        var folders = [];

        $('#main-content.has-sidebar .sidebar li a[data-folder-id]').each(function () {
                var folderKeys = $(this).data('folder-id');
                folders.push(folderKeys);

        });

        return folders;
    }


});
