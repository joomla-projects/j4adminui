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
// Load JavaScript message titles
Text::script('ERROR');
Text::script('WARNING');
Text::script('NOTICE');
Text::script('MESSAGE');

Text::script('COM_CPANEL_UNPUBLISH_MODULE_SUCCESS');
Text::script('COM_CPANEL_UNPUBLISH_MODULE_ERROR');

HTMLHelper::_('script', 'com_cpanel/admin-cpanel-default.min.js', array('version' => 'auto', 'relative' => true));

$user = Factory::getUser();

HTMLHelper::_('script', 'com_cpanel/admin-add_module.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('script', 'vendor/dragula/dragula.min.js', ['framework' => false, 'relative' => true]);
HTMLHelper::_('stylesheet', 'vendor/dragula/dragula.min.css', ['framework' => false, 'relative' => true, 'pathOnly' => false]);
HTMLHelper::_('script', 'mod_quickicon/cpanel-draggble.min.js', ['version' => 'auto', 'relative' => true]);

$saveOrderingUrl = 'index.php?option=com_modules&task=module.saveModuleOrderDashboard&format=json&tmpl=component&' . Session::getFormToken() . '=1';

?>
<div id="cpanel-modules">
	<div class="cpanel-modules <?php echo $this->position; ?>">
		<?php
			if (!empty($this->modules['quickicon']))
			{
				foreach ($this->modules['quickicon'] as $quickicon)
				{
					echo ModuleHelper::renderModule($quickicon, array('style' => 'simple'));
				}
			}
		?>
		<div class="row js-enable-dragula" data-fields="order[],cid[],position[]" data-containers="#cpanel-left-col,#cpanel-right-col" data-url-card="<?php echo $saveOrderingUrl; ?>" data-direction="asc" data-nested="true" data-drag_handler="handle">
			<div class="col-12 col-md-6" id="cpanel-left-col" data-position="left">
				<?php if (!empty($this->modules['left_column'])): ?>
						<?php
							foreach($this->modules['left_column'] as $module)
							{
								echo ModuleHelper::renderModule($module, array('style' => 'card'));
							}
						?>
				<?php endif; ?>
			</div>
			<div class="col-12 col-md-6" id="cpanel-right-col" data-position="right">
				<?php if (!empty($this->modules['right_column'])): ?>
						<?php
							foreach($this->modules['right_column'] as $module)
							{
								echo ModuleHelper::renderModule($module, array('style' => 'card'));
							}
						?>
				<?php endif; ?>
			</div>
		</div>

		<?php if ($user->authorise('core.create', 'com_modules')) : ?>
			<div>
				<a href="#moduleEditModal" data-href="#moduleDashboardAddModal" class="btn btn-secondary btn-xl btn-block add-module-btn" data-toggle="modal" role="button">
					<span class="icon-new mr-3"></span> <?php echo Text::_('COM_CPANEL_ADD_DASHBOARD_MODULE'); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
	
</div>

<?php 
echo HTMLHelper::_(
	'webcomponent.renderModal',
	'moduleDashboardAddModal',
	array(
		'title'       => Text::_('COM_CPANEL_ADD_MODULE_MODAL_TITLE'),
		'backdrop'    => 'static',
		'url'         => Route::_('index.php?option=com_cpanel&task=addModule&function=jSelectModuleType&position=' . $this->escape($this->position)),
		'height'      => '75vh',
		'width'       => '85vw',
		'class'		  => 'j-modal-gray',
		'bodyHeight'  => 75,
		'modalWidth'  => 85,
		'footer'      => '<button type="button" class="button-cancel btn btn-sm btn-danger" data-dismiss aria-hidden="true"><span class="icon-cancel" aria-hidden="true"></span>'. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') .'</button>
						<button type="button" class="button-save btn btn-sm btn-success hidden" data-target="#saveBtn" aria-hidden="true"><span class="icon-save" aria-hidden="true"></span>'. Text::_('JSAVE') .' </button>',
	)
);
?>
