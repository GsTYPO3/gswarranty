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


/**
 * GS Warranty provider class.
 *
 * USE:
 * The class is intended to be used without creating an instance of it.
 * So: Do not instantiate - call functions with "\Gilbertsoft\TYPO3\Warranty\Utility\Provider::" prefixed the function name.
 * So use \Gilbertsoft\TYPO3\Warranty\Utility\Provider::[method-name] to refer to the functions, eg. '\Gilbertsoft\TYPO3\Warranty\Utility\Provider::getName()'
 */
class Provider
{
    /**
     * @var string
     */
    protected static $name = null;

    /**
     * Returns the provider name loaded by getenv
     *
     * @return string
     * @api
     */
    public static function getName()
    {
        if (is_null(static::$name)) {
            static::$name = getenv('TYPO3_PROVIDER') ?: (getenv('REDIRECT_TYPO3_PROVIDER') ?: '');
        }
        return static::$name;
    }

    /**
     * Returns TRUE if the provider is Gilbertsoft
     *
     * @return bool
     * @api
     */
    public static function isGilbertsoft()
    {
        return static::getName() === 'Gilbertsoft';
    }
}
