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

namespace Gilbertsoft\Warranty\Backend\ToolbarItems;

use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * GS Warranty WarrantyLinkToolbarItem class.
 */
class WarrantyLinkToolbarItem implements ToolbarItemInterface
{
    /**
     * @return bool
     */
    public function checkAccess()
    {
        if ($GLOBALS['BE_USER']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getItem()
    {
        $view = $this->getFluidTemplateObject('WarrantyLinkToolbarItem.html');
        $view->assignMultiple([
                'link'  => 'https://gilbertsoft.com/go/typo3/warranty',
                'title' => 'Gilbertsoft Support',
                'iconIdentifier'  => 'apps-toolbar-menu-warranty',
                'iconSize'  => 'small',
            ]);

        return $view->render();
    }

    /**
     * @return bool
     */
    public function hasDropDown()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getDropDown()
    {
        return '';
    }

    /**
     * @return array
     */
    public function getAdditionalAttributes()
    {
        return [];
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return 79;
    }

    /**
     * Returns a new standalone view, shorthand function
     *
     * @param string $filename Which templateFile should be used.
     * @return StandaloneView
     */
    protected function getFluidTemplateObject($filename)
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths(['EXT:backend/Resources/Private/Layouts']);

        if (\Gilbertsoft\Warranty\Utility\Adapter::isCompatVersion('8.7')) {
            $view->setPartialRootPaths(['EXT:backend/Resources/Private/Partials/ToolbarItems']);
        } else {
            $view->setPartialRootPaths(['EXT:gswarranty/Resources/Private/Partials/ToolbarItems']);
        }

        $view->setTemplateRootPaths(['EXT:gswarranty/Resources/Private/Templates/ToolbarItems']);
        $view->setTemplate($filename);

        return $view;
    }
}
