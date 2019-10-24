<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_content
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Module\Content\Administrator\Helper\ModContentHelper;

$model = $app->bootComponent('com_content')->getMVCFactory()->createModel('Articles', 'Administrator', ['ignore_request' => true]);
$latests = ModContentHelper::getList($params, $model);
$popular = ModContentHelper::getPopular($params, $model);

require \Joomla\CMS\Helper\ModuleHelper::getLayoutPath('mod_content', $params->get('layout', 'default'));
