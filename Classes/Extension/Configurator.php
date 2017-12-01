<?php
namespace Gilbertsoft\Warranty\Extension;

/*
 * This file is part of the "GS Warranty" Extension for TYPO3 CMS.
 *
 * Copyright (C) 2017 by Gilbertsoft (gilbertsoft.org)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For the full license information, please read the LICENSE file that
 * was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Use declarations
 */
use Gilbertsoft\Lib\Extension\AbstractConfigurator;
use Gilbertsoft\Lib\Utility\Typo3Mode;
use Gilbertsoft\Lib\Utility\Typo3Provider;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

/**
 * GS Warranty adapter class.
 *
 * USE:
 * The class is intended to be used without creating an instance of it.
 * So: Do not instantiate - call functions with "\Gilbertsoft\Warranty\Extension\Configurator::" prefixed the function name.
 * So use \Gilbertsoft\Warranty\Extension\Configurator::[method-name] to refer to the functions, eg. '\Gilbertsoft\Warranty\Extension\Configurator::localconf($_EXTNAME)'
 */
class Configurator extends AbstractConfigurator
{
    /**
     * Adapt Copyright Warranty
     *
     * @param string $extKey Extension Key
     * @return void
     */
    protected static function adaptWarranty($extKey)
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyProvider'] = 'Gilbertsoft';
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['loginCopyrightWarrantyURL'] = 'http://gilbertsoft.com/go/typo3/warranty';
    }

    /**
     * Adapt Backend Styling
     *
     * @param string $extKey Extension Key
     * @return void
     */
    protected static function adaptLogos($extKey)
    {
        // Configure TBE_STYLES (TYPO3 = 7.6)
        if (self::isVersion('7.6')) {
            $GLOBALS['TBE_STYLES']['logo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Images/Backend/gilbertsoft-t3-topbar@2x.png';
        }

        // Configure Backend Extension
        if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
        }

        // Login Logo (TYPO3 >= 7.6)
        if (self::isCompatVersion('7.6')) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-login.png';
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginHighlightColor'] = '#004A99';
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginBackgroundImage'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-background.jpg';
        }

        // Backend Logo (TYPO3 >= 8.7)
        if (self::isCompatVersion('8.7')) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['backendLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-topbar@2x.png';
        }

        if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
        }
    }

    protected static function registerToolbarItems($extKey)
    {
        $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1511960569] = \Gilbertsoft\Warranty\Backend\ToolbarItems\WarrantyLinkToolbarItem::class;
    }
    
    protected static function registerIcons($extKey)
    {
        $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
        $iconRegistry->registerIcon(
            'apps-toolbar-menu-warranty',
            SvgIconProvider::class,
            ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/apps-toolbar-menu-warranty.svg']
        );
    }

    /**
     * Adapts the backend
     *
     * @return void
     * @api
     */
    public static function localconf($extKey)
    {
        if (Typo3Mode::isBackend() && Typo3Provider::isGilbertsoft()) {
            self::registerToolbarItems($extKey);
        }
    }

    /**
     * Adapts the backend
     *
     * @return void
     * @api
     */
    public static function tables($extKey)
    {
        if (Typo3Mode::isBackend() && Typo3Provider::isGilbertsoft()) {
            self::registerIcons($extKey);
            self::adaptWarranty($extKey);
            self::adaptLogos($extKey);
        }
    }
}
