<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_accessibility
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

// include helper file
require_once __DIR__ . '/helper.php';

//includes js and css
$doc        = JFactory::getDocument();
$doc->addStylesheet(JURI::root(true) . '/administrator/modules/' . $module->module . '/style.css');
$doc->addScript(JURI::root(true) . '/administrator/modules/' . $module->module . '/script.js');

require ModuleHelper::getLayoutPath('mod_accessibility', $params->get('layout', 'default'));