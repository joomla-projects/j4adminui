<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

HTMLHelper::_('behavior.core');
Text::script('COM_CPANEL_UNPUBLISH_MODULE_SUCCESS');
Text::script('COM_CPANEL_UNPUBLISH_MODULE_ERROR');

HTMLHelper::_('script', 'com_cpanel/admin-cpanel-default.min.js', array('version' => 'auto', 'relative' => true));

$user = Factory::getUser();

HTMLHelper::_('script', 'com_cpanel/admin-add_module.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'vendor/dragula/dragula.min.js', ['framework' => false, 'relative' => true]);
HTMLHelper::_('stylesheet', 'vendor/dragula/dragula.min.css', ['framework' => false, 'relative' => true, 'pathOnly' => false]);
HTMLHelper::_('script', 'mod_quickicon/quickicon-draggble.min.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'system/draggable.min.js', ['framework' => false, 'relative' => true]);

// $saveOrderingUrl = 'index.php?option=com_modules&task=modules.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
$saveOrderingUrl = 'index.php?option=com_modules&task=modules.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';

// Set up the bootstrap modal that will be used for all module editors
echo HTMLHelper::_(
	'bootstrap.renderModal',
	'moduleDashboardAddModal',
	array(
		'title'       => Text::_('COM_CPANEL_ADD_MODULE_MODAL_TITLE'),
		'backdrop'    => 'static',
		'url'         => Route::_('index.php?option=com_cpanel&task=addModule&function=jSelectModuleType&position=' . $this->escape($this->position)),
		'bodyHeight'  => '70',
		'modalWidth'  => '80',
		'footer'      => '<button type="button" class="button-cancel btn btn-sm btn-danger" data-dismiss="modal" data-target="#closeBtn" aria-hidden="true"><span class="icon-cancel" aria-hidden="true"></span>'
			. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
			. '<button type="button" class="button-save btn btn-sm btn-success hidden" data-target="#saveBtn" aria-hidden="true"><span class="icon-save" aria-hidden="true"></span>'
			. Text::_('JSAVE') . '</button>',
	)
);

?>
<div id="cpanel-modules">
	<div class="cpanel-modules js-draggable <?php echo $this->position; ?>" data-fields="order[],cid[]" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="asc" data-nested="false" data-drag_handler="handle">
		<?php // apear this div if not cpanel
		if($this->extension) : ?>
			<div class="card-columns">
		<?php endif; ?>

		<?php
		foreach ($this->modules as $module)
		{
			echo ModuleHelper::renderModule($module, array('style' => 'well'));
		}
		?>
		
		<?php if ($user->authorise('core.create', 'com_modules')) : ?>

		<?php // apear this div closing if not cpanel
		if($this->extension) : ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<a href="#moduleEditModal" data-toggle="modal" data-target="#moduleDashboardAddModal" role="button" class="cpanel-add-module text-center py-5 w-100 d-block">
			<div class="cpanel-add-module-icon text-center">
				<span class="fa fa-plus-square text-light mt-2"></span>
			</div>
			<span><?php echo Text::_('COM_CPANEL_ADD_DASHBOARD_MODULE'); ?></span>
		</a>
	</div>
	<?php endif; ?>
</div>
