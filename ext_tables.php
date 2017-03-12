<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {
		/***************
		 * Make the extension configuration accessible
		 */
		if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey])) {
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);
		}

		/***************
		 * Backend Styling
		 */
		if (TYPO3_MODE == 'BE') {
			/**
			 * Configure TBE_STYLES (TYPO3 = 7)
			 */
			$GLOBALS['TBE_STYLES']['logo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Images/Backend/gilbertsoft-t3-topbar.png';

			/**
			 * Configure Backend Extension
			 */
			if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
				$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
			}
			// Login Logo (TYPO3 >= 7)
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['loginLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-login.png';

			// Backend Logo (TYPO3 >= 8)
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']['backendLogo'] = 'EXT:' . $extKey . '/Resources/Public/Images/Backend/gilbertsoft-t3-topbar.png';

			if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'])) {
				$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend'] = serialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['backend']);
			}
		}

		/***************
		 * Reset extConf array to avoid errors
		 */
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey])) {
			$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey] = serialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);
		}

		/***************
		 * Add static files
		 */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'GS Warranty');

    },
    $_EXTKEY
);
