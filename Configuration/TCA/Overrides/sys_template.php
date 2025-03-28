<?php
declare(strict_types=1);

defined('TYPO3') or die('Access denied.');

call_user_func(function () {
    
    /**
     * Temporary variables
     */
    $extensionKey = 'bootstrap_containers';

    /**
     * Default TypoScript for BootstrapContainers
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'bootstrap_containers'
    );

});
