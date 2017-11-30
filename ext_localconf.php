<?php
defined('TYPO3_MODE') || die('Access denied.');

if (TYPO3_MODE === 'BE') {
    \Gilbertsoft\Warranty\Utility\Adapter::localconf($_EXTKEY);
}
