<?php
defined('TYPO3_MODE') || die('Access denied.');

if (class_exists('Gilbertsoft\Warranty\Extension\Configurator')) {
    \Gilbertsoft\Warranty\Extension\Configurator::tables($_EXTKEY);
}
