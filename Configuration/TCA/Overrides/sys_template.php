<?php

declare(strict_types=1);
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die('Access denied.');

call_user_func(static function () {
    ExtensionManagementUtility::addStaticFile(
        'bootstrap_containers',
        'Configuration/TypoScript',
        'Bootstrap Containers'
    );
});
