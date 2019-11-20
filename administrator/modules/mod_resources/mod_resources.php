<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  mod_resources
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

// Render the module
require ModuleHelper::getLayoutPath('mod_resources', $params->get('layout', 'default'));
