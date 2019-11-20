<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_config
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;

// Load tooltips behavior
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.tabstate');
HTMLHelper::_('script', 'com_modules/admin-module-edit_assignment.min.js', array('version' => 'auto', 'relative' => true));

// Load JS message titles
Text::script('ERROR');
Text::script('WARNING');
Text::script('NOTICE');
Text::script('MESSAGE');
?>

<form action="<?php echo Route::_('index.php?option=com_config'); ?>" id="application-form" method="post" name="adminForm" class="d-flex form-validate" data-cancel-task="config.cancel.component">
	<!-- Begin Sidebar -->
	<div id="sidebar" class="com-config-sidebar">
		<button class="btn btn-sm btn-secondary my-2 options-menu d-md-none" type="button" data-toggle="collapse" data-target=".sidebar-nav" aria-controls="sidebar-nav" aria-expanded="false" aria-label="<?php echo Text::_('JTOGGLE_SIDEBAR_MENU'); ?>">
			<span class="icon-menu-3 duotone" aria-hidden="true"></span>
			<?php echo Text::_('JTOGGLE_SIDEBAR_MENU'); ?>
		</button>
		<div class="sidebar-nav my-2">
			<?php echo $this->loadTemplate('navigation'); ?>
			<?php
			// Display the submenu position modules
			$this->submenumodules = ModuleHelper::getModules('submenu');
			foreach ($this->submenumodules as $submenumodule)
			{
				$output = ModuleHelper::renderModule($submenumodule);
				$params = new Registry($submenumodule->params);
				echo $output;
			}
			?>
		</div>
	</div>
	<!-- End Sidebar -->
	<!-- Begin Content -->
	<div class="com-config-content">
		<joomla-tab>
			<section  id="page-site" name="<?php echo Text::_('JSITE'); ?>">
				<?php echo $this->loadTemplate('site'); ?>
				<?php echo $this->loadTemplate('metadata'); ?>
				<?php echo $this->loadTemplate('seo'); ?>
				<?php echo $this->loadTemplate('cookie'); ?>
			</section>
			<section id="page-system" name="<?php echo Text::_('COM_CONFIG_SYSTEM'); ?>">
				<?php echo $this->loadTemplate('system'); ?>
				<?php echo $this->loadTemplate('debug'); ?>
				<?php echo $this->loadTemplate('cache'); ?>
				<?php echo $this->loadTemplate('session'); ?>
			</section>
			<section id="page-server" name="<?php echo Text::_('COM_CONFIG_SERVER'); ?>">
				<?php echo $this->loadTemplate('server'); ?>
				<?php echo $this->loadTemplate('locale'); ?>
				<?php echo $this->loadTemplate('ftp'); ?>
				<?php echo $this->loadTemplate('proxy'); ?>
				<?php echo $this->loadTemplate('database'); ?>
				<?php echo $this->loadTemplate('mail'); ?>
			</section>
			<section id="page-filters" name="<?php echo Text::_('COM_CONFIG_TEXT_FILTERS'); ?>">
				<?php echo $this->loadTemplate('filters'); ?>
			</section>
			<?php if ($this->ftp) : ?>
				<section id="page-ftp" name="<?php echo Text::_('COM_CONFIG_FTP_SETTINGS'); ?>">
					<?php echo $this->loadTemplate('ftplogin'); ?>
				</section>
			<?php endif; ?>
			<section id="page-permissions" name="<?php echo Text::_('COM_CONFIG_PERMISSIONS'); ?>">
				<?php echo $this->loadTemplate('permissions'); ?>
			</section>
		</joomla-tab>
		<input type="hidden" name="task" value="">
		<?php echo HTMLHelper::_('form.token'); ?>
	</div>
	<!-- End Content -->
</form>
