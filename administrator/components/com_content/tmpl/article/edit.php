<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/** @var \Joomla\Component\Content\Administrator\View\Article\HtmlView $this */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

HTMLHelper::_('script', 'com_contenthistory/admin-history-versions.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('webcomponent', 'system/joomla-accordion.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-callout.min.js', array('version'=> 'auto', 'relative' => true));

$this->configFieldsets  = array('editorConfig');
$this->hiddenFieldsets  = array('basic-limited');
$fieldsetsInImages = ['image-intro', 'image-full'];
$fieldsetsInLinks = ['linka', 'linkb', 'linkc'];
$this->ignore_fieldsets = array_merge(array('jmetadata', 'item_associations'), $fieldsetsInImages, $fieldsetsInLinks);
$this->useCoreUI = true;

// Create shortcut to parameters.
$params = clone $this->state->get('params');
$params->merge(new Registry($this->item->attribs));

$app = Factory::getApplication();
$input = $app->input;

$assoc = Associations::isEnabled();
$hasAssoc = ($this->form->getValue('language', null, '*') !== '*');

// In case of modal
$isModal = $input->get('layout') === 'modal';
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') == 'component' ? '&tmpl=component' : '';
?>

<form action="<?php echo Route::_('index.php?option=com_content&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="row">
		<div class="col-lg-9">
			<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>

			<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'general')); ?>

			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'general', Text::_('COM_CONTENT_ARTICLE_CONTENT')); ?>
				<fieldset class="adminform">
					<?php echo $this->form->getLabel('articletext'); ?>
					<?php echo $this->form->getInput('articletext'); ?>
				</fieldset>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php $this->show_options = $params->get('show_article_options', 1); ?>
			<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

			<?php if (!$isModal && $assoc) : ?>
				<?php if ($hasAssoc) : ?>
					<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'associations', Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS')); ?>
					<div id="fieldset-associations" class="options-grid-form options-grid-form-full j-card">
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

			<?php if ($this->canDo->get('core.admin')) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'permissions', Text::_('COM_CONTENT_FIELDSET_RULES')); ?>
				<div  id="fieldset-editor" class="options-grid-form options-grid-form-full j-card w-100 mb-4">
					<div class="j-card-header">
						<?php echo Text::_('COM_CONTENT_SLIDER_EDITOR_CONFIG'); ?>
					</div>
					<div class="j-card-body">
						<?php echo $this->form->renderFieldset('editorConfig'); ?>
					</div>
				</div>

				<div id="fieldset-rules" class="options-grid-form options-grid-form-full">
					<?php echo $this->form->getInput('rules'); ?>
				</div>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
			
		</div>

		<div class="col-lg-3">
			<joomla-accordion toggle="true" animation="true">
				<section class="accordion-item show" id="article-basic" name="<?php echo Text::_('COM_CONTENT_FIELDSET_BASIC'); ?>" icon="icon-info-circle">
					<?php echo LayoutHelper::render('joomla.edit.global', $this); ?>
				</section>

				<?php // Do not show the images options if the edit form is configured not to. ?>
				<?php if ($params->get('show_urls_images_backend') == 1) : ?>
					<section class="accordion-item" id="article-images" name="<?php echo Text::_('COM_CONTENT_FIELDSET_IMAGES'); ?>" icon="icon-media">
						<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'general')); ?>
						<?php foreach ($fieldsetsInImages as $fieldset) : ?>
							<?php echo HTMLHelper::_('uitab.addTab', 'myTab', $fieldset, Text::_($this->form->getFieldsets()[$fieldset]->label)); ?>
								<div class="form-vertical form-no-margin">
									<?php echo $this->form->renderFieldset($fieldset); ?>
								</div>
							<?php echo HTMLHelper::_('uitab.endTab'); ?>
						<?php endforeach; ?>
						<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
					</section>
				<?php endif; ?>
				
				<section class="accordion-item" id="article-seo" name="<?php echo Text::_('JGLOBAL_FIELDSET_SEO_OPTIONS'); ?>" icon="icon-search">
					<div class="form-vertical form-no-margin">
						<?php echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
					</div>
				</section>

				<?php // Do not show the links options if the edit form is configured not to. ?>
				<?php if ($params->get('show_urls_images_backend') == 1) : ?>
					<section class="accordion-item" id="article-links" name="<?php echo Text::_('COM_CONTENT_FIELDSET_URLS'); ?>" icon="icon-external-link">
						<div class="form-vertical form-no-margin">
						<?php foreach ($fieldsetsInLinks as $fieldset) : ?>
							<?php echo $this->form->renderFieldset($fieldset); ?>
						<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php // Do not show the publishing options if the edit form is configured not to. ?>
				<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
					<section class="accordion-item" id="article-publishingdata" name="<?php echo Text::_('JGLOBAL_FIELDSET_PUBLISHING'); ?>" icon="icon-calendar">
						<div class="form-vertical form-no-margin">
							<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
						</div>
					</section>
				<?php endif; ?>
			</joomla-accordion>
		</div>
	</div>

	<?php // Creating 'id' hiddenField to cope with com_associations sidebyside loop ?>
	<?php if ($params->get('show_publishing_options', 1) == 0) : ?>
		<?php $hidden_fields = $this->form->getInput('id'); ?>
		<div class="hidden"><?php echo $hidden_fields; ?></div>
	<?php endif; ?>

	<input type="hidden" name="task" value="">
	<input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>">
	<input type="hidden" name="forcedLanguage" value="<?php echo $input->get('forcedLanguage', '', 'cmd'); ?>">
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
