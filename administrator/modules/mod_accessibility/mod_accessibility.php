<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_accessibility
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Helper\ModuleHelper;

// Include js
HTMLHelper::_('script', 'mod_accessibility/accessibility.min.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', 'mod_accessibility/style.css', ['relative' => true]);

require ModuleHelper::getLayoutPath('mod_accessibility', $params->get('layout', 'default'));
