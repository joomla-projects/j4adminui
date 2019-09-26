<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  mod_extension_updates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\ExtensionUpdates\Administrator\Helper\ExtensionUpdatesHelper;

$extensionContents = ExtensionUpdatesHelper::extractExtensionsContent();

// Render the module
require ModuleHelper::getLayoutPath('mod_extension_updates', $params->get('layout', 'default'));
