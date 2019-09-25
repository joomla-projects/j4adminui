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
use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

HTMLHelper::_('behavior.core');
Text::script('COM_CPANEL_UNPUBLISH_MODULE_SUCCESS');
Text::script('COM_CPANEL_UNPUBLISH_MODULE_ERROR');

HTMLHelper::_('script', 'com_cpanel/admin-cpanel-default.min.js', array('version' => 'auto', 'relative' => true));

$user = Factory::getUser();

HTMLHelper::_('webcomponent', 'system/joomla-modal.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('script', 'com_cpanel/admin-add_module.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'vendor/dragula/dragula.min.js', ['framework' => false, 'relative' => true]);
HTMLHelper::_('stylesheet', 'vendor/dragula/dragula.min.css', ['framework' => false, 'relative' => true, 'pathOnly' => false]);
HTMLHelper::_('script', 'mod_quickicon/quickicon-draggble.min.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'system/draggable.min.js', ['framework' => false, 'relative' => true]);


// $saveOrderingUrl = 'index.php?option=com_modules&task=modules.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
$saveOrderingUrl = 'index.php?option=com_modules&task=modules.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';

?>
<div id="cpanel-modules">
	<div class="cpanel-modules <?php echo $this->position; ?>" data-fields="order[],cid[]" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="asc" data-nested="false" data-drag_handler="handle">
		
		<div class="row js-draggable">
			<?php
				foreach ($this->modules as $module)
				{
					$style = 'card';
					if( $module->module == 'mod_quickicon' )
					{
						$style = 'simple';
					}
					$params = new Registry($module->params);
					$bootstrap_size = $params->get('bootstrap_size', 12);
					$columns = ($bootstrap_size == 0) ? 12 : $bootstrap_size;
					?>
					<div class="col-<?php echo $columns; ?>">
						<?php echo ModuleHelper::renderModule($module, array('style' => $style)); ?>
					</div>
					<?php
				}
			?>
		</div>
		
		<?php if ($user->authorise('core.create', 'com_modules')) : ?>
	</div>
</div>
<div class="row justify-content-center mt-4">
	<div class="col-md-11">
		<a href="#moduleEditModal" data-href="#moduleDashboardAddModal" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" role="button">
			<span class="fas fa-plus mr-3"></span> <?php echo Text::_('COM_CPANEL_ADD_DASHBOARD_MODULE'); ?>
		</a>
	</div>
	<?php endif; ?>
</div>

<joomla-modal id="moduleDashboardAddModal" title="<?php echo Text::_('COM_CPANEL_ADD_MODULE_MODAL_TITLE'); ?>" width="80vw" height="400px" iframe="http://localhost<?php echo Route::_('index.php?option=com_cpanel&task=addModule&function=jSelectModuleType&position=' . $this->escape($this->position)); ?>">
	<section>&nbsp;</section>
	<footer>
		<button type="button" class="button-cancel btn btn-sm btn-danger" data-dismiss aria-hidden="true"><span class="icon-cancel" aria-hidden="true"></span>
			<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?> </button>
		<button type="button" class="button-save btn btn-sm btn-success hidden" data-target="#saveBtn" aria-hidden="true"><span class="icon-save" aria-hidden="true"></span>
			<?php echo Text::_('JSAVE'); ?> </button>
	</footer>
</joomla-modal>