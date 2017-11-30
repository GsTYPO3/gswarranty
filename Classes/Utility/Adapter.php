<?php

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

namespace Gilbertsoft\Warranty\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

/**
 * GS Warranty adapter class.
 *
 * USE:
 * The class is intended to be used without creating an instance of it.
 * So: Do not instantiate - call functions with "\Gilbertsoft\Warranty\Utility\Adapter::" prefixed the function name.
 * So use \Gilbertsoft\Warranty\Utility\Adapter::[method-name] to refer to the functions, eg. '\Gilbertsoft\Warranty\Utility\Adapter::run($_EXTNAME)'
 */
class Adapter
{
    /**
     * @var integer
     */
    protected static $version = null;

    /**
     * Returns the TYPO3 version as integer
     *
     * @return integer
     * @api
     */
    protected static function getTypo3Version()
    {
        if (is_null(static::$version)) {
            static::$version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch);
        }
        return static::$version;
    }

    /**
     * Returns TRUE if the current TYPO3 version (or compatibility version) is compatible to the input version
     * Notice that this function compares branches, not versions (4.0.1 would be > 4.0.0 although they use the same compat_version)
     *
     * @param string $verNumberStr Minimum branch number required (format x.y / e.g. "4.0" NOT "4.0.0"!)
     * @return bool Returns TRUE if this setup is compatible with the provided version number
     * @todo Still needs a function to convert versions to branches
     */
    public static function isVersion($branchNumberStr)
    {
        return (static::getTypo3Version() == \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger($branchNumberStr));
    }

    /**
     * Returns TRUE if the current TYPO3 version (or compatibility version) is compatible to the input version
     * Notice that this function compares branches, not versions (4.0.1 would be > 4.0.0 although they use the same compat_version)
     *
     * @param string $verNumberStr Minimum branch number required (format x.y / e.g. "4.0" NOT "4.0.0"!)
     * @return bool Returns TRUE if this setup is compatible with the provided version number
     * @todo Still needs a function to convert versions to branches
     */
    public static function isCompatVersion($branchNumberStr)
    {
        return static::getTypo3Version() >= \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger($branchNumberStr);
    }

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
        if (static::isVersion('7.6')) {
            $GLOBALS['TBE_STYLES']['logo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Images/Backend/gilbertsoft-t3-topbar@2x.png';
        }

        // Configure Backend Extension
        if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
        }

        // Login Logo (TYPO3 >= 7.6)
        if (static::isCompatVersion('7.6')) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-login.png';
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginHighlightColor'] = '#004A99';
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginBackgroundImage'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-background.jpg';
        }

        // Backend Logo (TYPO3 >= 8.7)
        if (static::isCompatVersion('8.7')) {
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
        if ((TYPO3_MODE === 'BE') && Provider::isGilbertsoft())
        {
            static::registerToolbarItems($extKey);
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
        if ((TYPO3_MODE === 'BE') && Provider::isGilbertsoft())
        {
            static::registerIcons($extKey);
            static::adaptWarranty($extKey);
            static::adaptLogos($extKey);
        }
    }
}
