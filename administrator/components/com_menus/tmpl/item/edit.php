<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_menus
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

HTMLHelper::_('behavior.core');
HTMLHelper::_('behavior.tabstate');
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

$this->useCoreUI = true;

Text::script('ERROR');
Text::script('JGLOBAL_VALIDATION_FORM_FAILED');

$this->document->addScriptOptions('menu-item', ['itemId' => (int) $this->item->id]);
HTMLHelper::_('script', 'com_menus/admin-item-edit.min.js', ['version' => 'auto', 'relative' => true], ['defer' => 'defer']);
HTMLHelper::_('webcomponent', 'system/joomla-accordion.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-callout.min.js', array('version'=> 'auto', 'relative' => true));

$assoc = Associations::isEnabled();
$hasAssoc = ($this->form->getValue('language', null, '*') !== '*');
$input = Factory::getApplication()->input;

// In case of modal
$isModal  = $input->get('layout') === 'modal';
$layout   = $isModal ? 'modal' : 'edit';
$tmpl     = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';
$clientId = $this->state->get('item.client_id', 0);
$lang     = Factory::getLanguage()->getTag();

// Load mod_menu.ini file when client is administrator
if ($clientId === 1)
{
	Factory::getLanguage()->load('mod_menu', JPATH_ADMINISTRATOR, null, false, true);
}
?>
<form action="<?php echo Route::_('index.php?option=com_menus&view=item&client_id=' . $clientId . '&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

	<div class="row">
		<div class="col-lg-9">
			<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>
			<?php // Add the translation of the menu item title when client is administrator ?>
			<?php if ($clientId === 1 && $this->item->id != 0) : ?>
				<div class="form-inline form-inline-header">
					<div class="control-group">
						<div class="control-label">
							<label for="menus_title_translation"><?php echo Text::sprintf('COM_MENUS_TITLE_TRANSLATION', $lang); ?></label>
						</div>
						<div class="controls">
							<input id="menus_title_translation" class="form-control" value="<?php echo Text::_($this->item->title); ?>" readonly="readonly" type="text">
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'details')); ?>

			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_MENUS_ITEM_DETAILS')); ?>
				<div class="j-card">
					<div class="j-card-body">
					<?php
					echo $this->form->renderField('type');

					if ($this->item->type == 'alias')
					{
						echo $this->form->renderField('aliasoptions', 'params');
					}

					if ($this->item->type == 'separator')
					{
						echo $this->form->renderField('text_separator', 'params');
					}

					echo $this->form->renderFieldset('request');

					if ($this->item->type == 'url')
					{
						$this->form->setFieldAttribute('link', 'readonly', 'false');
						$this->form->setFieldAttribute('link', 'required', 'true');
					}

					echo $this->form->renderField('link');

					if ($this->item->type == 'alias')
					{
						echo $this->form->renderField('alias_redirect', 'params');
					}

					echo $this->form->renderField('browserNav');
					echo $this->form->renderField('template_style_id');

					if (!$isModal && $this->item->type == 'container')
					{
						echo $this->loadTemplate('container');
					}
					?>
					</div>
				</div>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php
			$this->fieldsets = array();
			$this->ignore_fieldsets = array('aliasoptions', 'request', 'menu-options', 'page-options', 'metadata', 'item_associations');
			echo LayoutHelper::render('joomla.edit.params', $this);
			?>

			<?php if (!$isModal && $assoc && $this->state->get('item.client_id') != 1) : ?>
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

			<?php if (!empty($this->modules)) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'modules', Text::_('COM_MENUS_ITEM_MODULE_ASSIGNMENT')); ?>
				<div id="fieldset-modules" class="j-card options-grid-form options-grid-form-full">
					<div class="j-card-header">
						<?php echo Text::_('COM_MENUS_ITEM_MODULE_ASSIGNMENT'); ?>
					</div>
					<div class="j-card-body">
						<?php echo $this->loadTemplate('modules'); ?>
					</div>
				</div>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
		</div>

		<div class="col-lg-3">
			<joomla-accordion toggle="true" animation="true">
				<section class="accordion-item show" id="menu-editor-basic" name="<?php echo Text::_('COM_MENUS_BASIC_LABEL'); ?>" icon="icon-info-circle">
					<?php
					// Set main fields.
					$this->fields = array(
						'id',
						'client_id',
						'menutype',
						'parent_id',
						'menuordering',
						'published',
						'publish_up',
						'publish_down',
						'home',
						'access',
						'language',
						'note',
					);

					if ($this->item->type != 'component')
					{
						$this->fields = array_diff($this->fields, array('home'));
						$this->form->setFieldAttribute('publish_up', 'showon', '');
						$this->form->setFieldAttribute('publish_down', 'showon', '');
					}

					echo LayoutHelper::render('joomla.edit.global', $this);
					
					?>
				</section>
				
				<?php if($this->form->getFieldset('metadata')) : ?>
				<section class="accordion-item" id="menu-editor-metadata" name="<?php echo Text::_('JGLOBAL_FIELDSET_SEO_OPTIONS'); ?>" icon="icon-search">
					<div class="form-vertical form-no-margin">
						<?php echo $this->form->renderFieldSet('metadata'); ?>
					</div>
				</section>
				<?php endif; ?>

				<?php if($this->form->getFieldset('menu-options')) : ?>
				<section class="accordion-item" id="menu-editor-linktype" name="<?php echo Text::_('COM_MENUS_LINKTYPE_OPTIONS_LABEL'); ?>" icon="icon-external-link">
					<div class="form-vertical form-no-margin">
						<?php echo $this->form->renderFieldSet('menu-options'); ?>
					</div>
				</section>
				<?php endif; ?>

				<?php if($this->form->getFieldset('page-options')) : ?>
				<section class="accordion-item" id="menu-editor-page-options" name="<?php echo Text::_('COM_MENUS_PAGE_OPTIONS_LABEL'); ?>" icon="icon-info-circle">
					<div class="form-vertical form-no-margin">
						<?php echo $this->form->renderFieldSet('page-options'); ?>
					</div>
				</section>
				<?php endif; ?>
			</joomla-accordion>
		</div>
	</div>

	<input type="hidden" name="task" value="">
	<input type="hidden" name="forcedLanguage" value="<?php echo $input->get('forcedLanguage', '', 'cmd'); ?>">
	<input type="hidden" name="menutype" value="<?php echo $input->get('menutype', '', 'cmd'); ?>">
	<?php echo $this->form->getInput('component_id'); ?>
	<?php echo HTMLHelper::_('form.token'); ?>
	<input type="hidden" id="fieldtype" name="fieldtype" value="">
</form>
