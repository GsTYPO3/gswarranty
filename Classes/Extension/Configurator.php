<?php
namespace Gilbertsoft\Warranty\Extension;

/*
 * This file is part of the "GS Warranty" Extension for TYPO3 CMS.
 *
 * Copyright (C) 2017-2019 by Gilbertsoft (gilbertsoft.org)
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
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        // Get backend configuration
        if (class_exists('TYPO3\CMS\Core\Configuration\ExtensionConfiguration')) {
            try {
                $extensionConfiguration = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class);
                $backendConfiguration = $extensionConfiguration->get('backend');
            } catch (\TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException $e) {
                $backendConfiguration = [];
            }
        } else {
            if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
                $backendConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
            } else {
                $backendConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'];
            }
            $backendConfiguration = $backendConfiguration ?? [];
        }

        // Login Logo (TYPO3 >= 7.6)
        if (self::isCompatVersion('7.6')) {
            $backendConfiguration['loginLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-login.png';
            $backendConfiguration['loginHighlightColor'] = '#004A99';
            $backendConfiguration['loginBackgroundImage'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-background.jpg';
        }

        // Backend Logo (TYPO3 >= 8.7)
        if (self::isCompatVersion('8.7')) {
            $backendConfiguration['backendLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-topbar@2x.png';
        }

        // Save backend configuration
        if (class_exists('TYPO3\CMS\Core\Configuration\ExtensionConfiguration')) {
            try {
                $extensionConfiguration->set('backend', '', $backendConfiguration);
            } catch (\TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException $e) {
            }
        } else {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize($backendConfiguration);
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
