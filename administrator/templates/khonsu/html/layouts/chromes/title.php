<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Khonsu
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * Module chrome for rendering the module in a submenu
 */

defined('_JEXEC') or die;

$module  = $displayData['module'];
//module for card header
if ($module->content) : ?>
	<div class="j-card-header"><h6><?php echo $module->title; ?></h6></div>
	<?php echo $module->content; ?>
<?php endif; ?>
