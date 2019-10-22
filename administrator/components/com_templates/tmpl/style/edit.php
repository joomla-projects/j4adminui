<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.tabstate');

$this->useCoreUI = true;

$user = Factory::getUser();
?>

<form action="<?php echo Route::_('index.php?option=com_templates&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="style-form" class="form-validate">

	<div class="form-no-margin options-grid-form">
		<div class="row">
			<div class="col-lg-5">
				<?php echo $this->form->renderField('title'); ?>
			</div>
			<div class="col-lg-3">
				<?php echo $this->form->renderField('home'); ?>
			</div>
		</div>
	</div>

	<div>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('JDETAILS')); ?>
			<div class="j-card">
				<div class="j-card-header">
					<h2 class="j-card-title">
						<?php echo Text::_($this->item->template); ?>
						<span class="badge badge-success">
							<?php echo $this->item->client_id == 0 ? Text::_('JSITE') : Text::_('JADMINISTRATOR'); ?>
						</span>
						<small class="d-block mt-2">
							<?php echo Text::_($this->item->xml->description); ?>
							<?php
							$this->fieldset = 'description';
							$description = LayoutHelper::render('joomla.edit.fieldset', $this);
							?>
							<?php if ($description) : ?>
								<p class="readmore">
									<a href="#" onclick="document.querySelector('#tab-description').click();">
										<?php echo Text::_('JGLOBAL_SHOW_FULL_DESCRIPTION'); ?>
									</a>
								</p>
							<?php endif; ?>
						</small>
					</h2>
				</div>
				<?php if($this->form->getFieldset('basic')) : ?>
					<div class="card-body">
						<div class="form-vertical">
							<?php echo $this->form->renderFieldSet('basic'); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php if ($description) : ?>
			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'description', Text::_('JGLOBAL_FIELDSET_DESCRIPTION')); ?>
				<fieldset id="fieldset-description" class="options-grid-form options-grid-form-full">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_DESCRIPTION'); ?></legend>
					<div>
					<?php echo $description; ?>
					</div>
				</fieldset>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>
		<?php endif; ?>

		<?php
		$this->fieldsets = array();
		$this->ignore_fieldsets = array('basic', 'description');
		echo LayoutHelper::render('joomla.edit.params', $this);
		?>

		<?php if ($user->authorise('core.edit', 'com_menus') && $this->item->client_id == 0 && $this->canDo->get('core.edit.state')) : ?>
			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'assignment', Text::_('COM_TEMPLATES_MENUS_ASSIGNMENT')); ?>
			<div id="fieldset-assignment" class="options-grid-form options-grid-form-full">
				<div class="sr-only"><?php echo Text::_('COM_TEMPLATES_MENUS_ASSIGNMENT'); ?></div>
				<div>
				<?php echo $this->loadTemplate('assignment'); ?>
				</div>
				</div>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>
		<?php endif; ?>

		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

		<?php
		$this->fields = array(
			'client_id',
			'template'
		);
		?>
		<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
		<input type="hidden" name="task" value="">
		<?php echo HTMLHelper::_('form.token'); ?>
	</div>
</form>
