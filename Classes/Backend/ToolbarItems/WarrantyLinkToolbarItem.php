<?php

/*
 * This file is part of the GS Warranty TYPO3 Extension.
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


/**
 * GS Warranty WarrantyLinkToolbarItem class.
 */
class WarrantyLinkToolbarItem implements \TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface
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
        $gilbertsoftUrl = 'https://gilbertsoft.com/go/typo3/warranty';

        return '
            <a href="' . $gilbertsoftUrl . '" target="_blank">
                <span title="Gilbertsoft Support">
                    <span class="icon icon-size-small icon-state-default icon-apps-toolbar-menu-gilbertsoft">
                        <span class="icon-markup">
                            <svg  version="1.1" id="Gilbertsoft" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" width="32" height="19.238"
								 viewBox="0 0 32 19.238" overflow="visible" enable-background="new 0 0 32 19.238" xml:space="preserve">
							<g>
								<path fill="#E9E9F3" d="M17.342,1.044l-0.936,3.237c-1.368-0.896-3.087-1.345-5.156-1.345c-2.208,0-4.001,0.775-5.378,2.327
									c-1.325,1.482-1.987,3.354-1.987,5.617c0,1.533,0.475,2.813,1.426,3.836c0.985,1.057,2.252,1.584,3.802,1.584
									c0.945,0,1.556-0.061,1.834-0.182l1.04-4.928H8.046l0.612-2.937h7.551l-2.132,10.151c-1.326,0.555-2.986,0.832-4.979,0.832
									c-2.842,0-5.043-0.66-6.603-1.977C0.832,15.848,0,13.754,0,10.979c0-3.373,1.018-6.053,3.053-8.039C5.07,0.98,7.768,0,11.146,0
									C13.475,0,15.541,0.349,17.342,1.044z"/>
								<path fill="#E9E9F3" d="M32,0.822l-0.887,3.077c-1.25-0.642-2.541-0.963-3.871-0.963c-0.799,0-1.484,0.156-2.059,0.467
									c-0.712,0.381-1.068,0.934-1.068,1.66c0,0.787,0.551,1.531,1.654,2.233c1.895,1.223,2.91,1.899,3.05,2.029
									c1.103,0.988,1.655,2.221,1.655,3.695c0,2.141-0.77,3.744-2.307,4.813c-1.328,0.936-3.111,1.404-5.352,1.404
									c-1.641,0-3.412-0.346-5.314-1.039l0.965-3.172c1.852,0.85,3.373,1.273,4.563,1.273c0.982,0,1.8-0.234,2.452-0.701
									c0.738-0.529,1.108-1.264,1.108-2.201c0-0.902-0.553-1.705-1.655-2.406c-1.017-0.633-2.032-1.268-3.05-1.9
									c-1.103-0.91-1.654-2.067-1.654-3.473c0-1.847,0.712-3.273,2.135-4.279C23.624,0.446,25.226,0,27.17,0
									C29.018,0,30.629,0.274,32,0.822z"/>
							</g>
							</svg>
                        </span>
                    </span>
                </span>
            </a>';
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
        return array();
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return 79;
    }
}
