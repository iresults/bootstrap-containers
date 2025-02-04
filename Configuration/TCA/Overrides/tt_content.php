<?php

use B13\Container\Tca\ContainerConfiguration;
use B13\Container\Tca\Registry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

$gridLocalizationFile = 'LLL:EXT:bootstrap_containers/Resources/Private/Language/locallang.xlf:';
$addFlexForm = function (ContainerConfiguration $containerConfiguration): ContainerConfiguration {
    $flexFormFileName = GeneralUtility::underscoredToUpperCamelCase(
        str_replace('-', '_', $containerConfiguration->getCType())
    ) . '.xml';
    $CType = $containerConfiguration->getCType();
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:bootstrap_containers/Configuration/FlexForm/' . $flexFormFileName,
        $CType
    );
    $showItemAppearanceTab = '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,';
    $GLOBALS['TCA']['tt_content']['types'][$CType]['showitem'] = str_replace(
        $showItemAppearanceTab,
        'pi_flexform,' . $showItemAppearanceTab,
        $GLOBALS['TCA']['tt_content']['types'][$CType]['showitem']
    );

    return $containerConfiguration;
};

$containerRegistry = GeneralUtility::makeInstance(Registry::class);
$client2cols = (new ContainerConfiguration(
    'client-2cols', // CType
    $gridLocalizationFile . '2cols.title', // label
    '', // description
    [
        [
            ['name' => $gridLocalizationFile . 'content.leftColumn', 'colPos' => 101],
            ['name' => $gridLocalizationFile . 'content.rightColumn', 'colPos' => 102],
        ],
    ]
))->setIcon('EXT:container/Resources/Public/Icons/container-2col.svg');
$containerRegistry->configureContainer($client2cols);
$addFlexForm($client2cols);

$client3cols = (new ContainerConfiguration(
    'client-3cols', // CType
    $gridLocalizationFile . '3cols.title', // label
    '', // description
    [
        [
            ['name' => $gridLocalizationFile . 'grid.label.col1', 'colPos' => 101],
            ['name' => $gridLocalizationFile . 'grid.label.col2', 'colPos' => 102],
            ['name' => $gridLocalizationFile . 'grid.label.col3', 'colPos' => 103],
        ],
    ]
))->setIcon('EXT:container/Resources/Public/Icons/container-3col.svg');
$containerRegistry->configureContainer($client3cols);
$addFlexForm($client3cols);

$client4cols = (new ContainerConfiguration(
    'client-4cols', // CType
    $gridLocalizationFile . '4cols.title', // label
    '', // description
    [
        [
            ['name' => $gridLocalizationFile . 'grid.label.col1', 'colPos' => 101],
            ['name' => $gridLocalizationFile . 'grid.label.col2', 'colPos' => 102],
            ['name' => $gridLocalizationFile . 'grid.label.col3', 'colPos' => 103],
            ['name' => $gridLocalizationFile . 'grid.label.col4', 'colPos' => 104],
        ],
    ]
))->setIcon('EXT:container/Resources/Public/Icons/container-4col.svg');

$containerRegistry->configureContainer($client4cols);
$addFlexForm($client4cols);

$clientContainer = (new ContainerConfiguration(
    'client-container', // CType
    $gridLocalizationFile . 'container.title', // label
    '', // description
    [
        [
            ['name' => $gridLocalizationFile . 'content.content', 'colPos' => 101],
        ],
    ]
))->setIcon('EXT:container/Resources/Public/Icons/container-1col.svg');
$containerRegistry->configureContainer($clientContainer);
$addFlexForm($clientContainer);

$containerRegistry->configureContainer(
    (new ContainerConfiguration(
        'client-group', // CType
        $gridLocalizationFile . 'group.title',
        $gridLocalizationFile . 'group.description',
        [
            [
                ['name' => $gridLocalizationFile . 'content.content', 'colPos' => 101],
            ],
        ]
    ))->setIcon('EXT:container/Resources/Public/Icons/container-1col.svg')
);

$clientAccordion = (new ContainerConfiguration(
    'client-accordion', // CType
    $gridLocalizationFile . 'accordion.title', // label
    '', // description
    [
        [
            ['name' => $gridLocalizationFile . 'content.accordionElements', 'colPos' => 101],
        ],
    ]
))->setIcon('EXT:container/Resources/Public/Icons/container-1col.svg');
$containerRegistry->configureContainer($clientAccordion);
$addFlexForm($clientAccordion);
