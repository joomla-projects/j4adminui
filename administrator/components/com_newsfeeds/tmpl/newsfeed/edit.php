<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('script', 'com_contenthistory/admin-history-versions.js', ['version' => 'auto', 'relative' => true]);

$app   = Factory::getApplication();
$input = $app->input;

$assoc = Associations::isEnabled();
$hasAssoc = ($this->form->getValue('language', null, '*') !== '*');

// Fieldsets to not automatically render by /layouts/joomla/edit/params.php
$this->ignore_fieldsets = array('images', 'jbasic', 'jmetadata', 'item_associations');
$this->useCoreUI = true;

// In case of modal
$isModal = $input->get('layout') === 'modal';
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo Route::_('index.php?option=com_newsfeeds&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="newsfeed-form" class="form-validate">

	<div class="row">
		<div class="col-lg-9">
			<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>

			<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'details')); ?>

			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', empty($this->item->id) ? Text::_('COM_NEWSFEEDS_NEW_NEWSFEED') : Text::_('COM_NEWSFEEDS_EDIT_NEWSFEED')); ?>
			<div class="j-card">
				<div class="j-card-body">
					<div class="form-vertical">
						<?php echo $this->form->renderField('link'); ?>
						<?php echo $this->form->renderField('description'); ?>
					</div>
				</div>
			</div>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'images', Text::_('JGLOBAL_FIELDSET_OPTIONS')); ?>
				<div id="fieldset-image" class="j-card options-grid-form options-grid-form-full mb-4">
					<div class="j-card-header">
						<?php echo Text::_('JGLOBAL_FIELDSET_IMAGE_OPTIONS'); ?>
					</div>
					<div class="j-card-body">
						<?php foreach ($this->form->getGroup('images') as $field) : ?>
							<?php echo $field->renderField(); ?>
						<?php endforeach; ?>
					</div>
				</div>
				<?php echo $this->loadTemplate('display'); ?>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
				<div id="fieldset-publishingdata" class="j-card options-grid-form options-grid-form-full mb-4">
					<div class="j-card-header">
						<?php echo Text::_('JGLOBAL_FIELDSET_PUBLISHING'); ?>
					</div>
					<div class="j-card-body">
						<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
					</div>
				</div>
				<div id="fieldset-metadata" class="j-card options-grid-form options-grid-form-full">
					<div class="j-card-header">
						<?php echo Text::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?>
					</div>
					<div class="j-card-body">
						<?php echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
					</div>
				</div>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php if (!$isModal && $assoc) : ?>
				<?php if ($hasAssoc) : ?>
					<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'associations', Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS')); ?>
					<div id="fieldset-associations" class="j-card options-grid-form options-grid-form-full">
						<div class="j-card-header">
							<?php echo Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS'); ?>
						</div>
						<div class="j-card-body">
							<?php echo LayoutHelper::render('joomla.edit.associations', $this); ?>
						</div>
					</div>
					<?php echo HTMLHelper::_('uitab.endTab'); ?>
				<?php endif; ?>
			<?php elseif ($isModal && $assoc) : ?>
				<div class="hidden"><?php echo LayoutHelper::render('joomla.edit.associations', $this); ?></div>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
		</div>

		<div class="col-lg-3">
			<div class="j-card">
				<div class="j-card-body">
					<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
				</div>
			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="">
	<input type="hidden" name="forcedLanguage" value="<?php echo $input->get('forcedLanguage', '', 'cmd'); ?>">
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
