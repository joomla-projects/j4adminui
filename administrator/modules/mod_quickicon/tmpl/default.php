<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_quickicon
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

HTMLHelper::_('script', 'mod_quickicon/quickicon.min.js', ['version' => 'auto', 'relative' => true]);

$saveOrderingUrl = 'index.php?option=com_modules&task=Module.saveParamsOrderAjax&format=json&' . Session::getFormToken() . '=1';

$html = HTMLHelper::_('icons.buttons', $buttons);
?>
<?php if (!empty($html)) : ?>
	<nav class="quick-icons js-enable-dragula" aria-label="<?php echo Text::_('MOD_QUICKICON_NAV_LABEL') . ' ' . $module->title; ?>" data-containers=".quickicon-draggable-container" data-fields="sub_module_name[],module_id" data-url-quickicon="<?php echo $saveOrderingUrl; ?>">
		<div class="row quickicon-draggable-container">
			<?php echo $html; ?>
			<input type="hidden" value="<?php echo $module->id ?>" name="module_id">
		</div>
	</nav>
<?php endif; ?>
