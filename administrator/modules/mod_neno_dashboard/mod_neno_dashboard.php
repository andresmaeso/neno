<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_neno_dashboard
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//Adding Language files
$lang = JFactory::getLanguage();
$lang->load('com_neno', JPATH_ADMINISTRATOR, $lang->getTag(), true);

//Get Items 
$languageData = NenoHelper::getLanguageConfigurationData();

 require JModuleHelper::getLayoutPath('mod_neno_dashboard', $layout='default');