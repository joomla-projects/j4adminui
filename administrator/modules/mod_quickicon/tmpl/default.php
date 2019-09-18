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

$saveOrderingUrl = 'index.php?option=com_modules&task=modules.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
HTMLHelper::_('draggablelist.draggable');
$html = HTMLHelper::_('icons.buttons', $buttons);
print_r('1')
?>
<?php if (!empty($html)) : ?>
	<nav class="quick-icons" aria-label="<?php echo Text::_('MOD_QUICKICON_NAV_LABEL') . ' ' . $module->title; ?>">
		<div class="row" class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="asc" data-nested="true">
			<?php echo $html; ?>
		</div>
	</nav>
<?php endif; ?>
