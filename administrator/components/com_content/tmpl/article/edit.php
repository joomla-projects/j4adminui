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
use Joomla\CMS\Language\Multilanguage;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

HTMLHelper::_('script', 'com_contenthistory/admin-history-versions.js', ['version' => 'auto', 'relative' => true]);

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
$isModal = $input->get('layout') == 'modal' ? true : false;
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';

// Generate article view URL
$articleUrl = '';
$articleUrlClass = 'inactive';
if($this->item->id > 0) 
{
	// URL link to article
	$articleUrl = Route::_(JURI::root() . \ContentHelperRoute::getArticleRoute($this->item->id, $this->item->catid, $this->item->language));
	$articleUrlClass = 'active';
}

?>

<form action="<?php echo Route::_('index.php?option=com_content&layout=' . $layout . $tmpl . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

	<div class="article-title-info-wrapper">
		<div class="row align-items-center">
			<div class="col-lg-9">
				<div class="form-no-margin form-title-wrap">
					<?php echo LayoutHelper::render('joomla.edit.title', $this); ?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="jcard">
					<div class="jcard-header artilce-preview-link">
						<span class="link-info"><i class="fas fa-eye"></i><?php echo JText::_('COM_CONTENT_VIEW_ARTICLE'); ?></span>
						<a class="field-view-url <?php echo $articleUrlClass; ?>" target="_blank" href="<?php echo $articleUrl; ?>"><span class="icon fas fa-external-link-alt"></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-9">
			<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'general')); ?>

			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'general', Text::_('COM_CONTENT_ARTICLE_CONTENT')); ?>
				<div class="item-title">
					<?php echo $this->form->getLabel('articletext'); ?>
					<?php echo $this->form->getInput('articletext'); ?>
				</div>
				
				<?php // Do not show the images and links options if the edit form is configured not to. ?>
				<?php if ($params->get('show_urls_images_backend') == 1) : ?>
					<!-- images and links -->
					<div class="images-and-links-wrap">
						<?php echo HTMLHelper::_('uitab.startTabSet', 'imageTab', array('active' => 'introimage')); ?>
							<!-- intro images -->
							<?php echo HTMLHelper::_('uitab.addTab', 'imageTab', 'introimage', JText::_('COM_CONTENT_FIELD_INTRO_LABEL')); ?>
								<div class="intro-image-wrap form-no-margin card">
									<div class="card-body">
										<div class="row">
											<div class="col-lg-4">
												<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'image_intro' ),'data' => $this)); ?>
											</div>

											<div class="col-lg-8">
												<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'image_intro_alt', 'image_intro_caption', 'float_intro'),'data' => $this)); ?>
											</div>
										</div>
									</div>
								</div>
							<?php echo HTMLHelper::_('uitab.endTab'); ?>
							<!-- full images -->
							<?php echo HTMLHelper::_('uitab.addTab', 'imageTab', 'fullimage', JText::_('COM_CONTENT_FIELD_FULL_LABEL')); ?>
								<div class="full-image-wrap form-no-margin card">
									<div class="card-body">
										<div class="row">
											<div class="col-lg-4">
												<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'image_fulltext' ),'data' => $this)); ?>
											</div>

											<div class="col-lg-8">
												<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'image_fulltext_alt', 'image_fulltext_caption', 'float_fulltext'),'data' => $this)); ?>
											</div>
										</div>
									</div>
								</div>
							<?php echo HTMLHelper::_('uitab.endTab'); ?>
							<!-- links -->
							<?php echo HTMLHelper::_('uitab.addTab', 'imageTab', 'links', JText::_('COM_CONTENT_FIELD_URLS_OPTIONS')); ?>

								<div class="urls-wrap px-3 form-no-margin card">
									<div class="row">
										<div class="col-lg-6">
											<h3 class="mt-3"><?php echo JText::_('COM_CONTENT_FIELD_URLA_LABEL'); ?></h3>
											<?php
												$this->fieldset = 'linka';
												echo LayoutHelper::render('joomla.edit.fieldset', $this);
											?>
										</div>
										<div class="col-lg-6">
											<h3 class="mt-3"><?php echo JText::_('COM_CONTENT_FIELD_URLB_LABEL'); ?></h3>
											<?php
												$this->fieldset = 'linkb';
												echo LayoutHelper::render('joomla.edit.fieldset', $this);
											?>
										</div>
										<div class="col-lg-6">
											<h3 class="mt-3"><?php echo JText::_('COM_CONTENT_FIELD_URLC_LABEL'); ?></h3>
											<?php
												$this->fieldset = 'linkc';
												echo LayoutHelper::render('joomla.edit.fieldset', $this);
											?>
										</div>
									</div>
								</div>
							<?php echo HTMLHelper::_('uitab.endTab'); ?>
						<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
					</div>
				<?php endif; ?>
				
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php $this->show_options = $params->get('show_article_options', 1); ?>
			<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

			<?php // Do not show the publishing options if the edit form is configured not to. ?>
			<?php if ($params->get('show_publishing_options', 1) == 1) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('COM_CONTENT_FIELDSET_PUBLISHING')); ?>
				<div class="row">
					<div class="col-12 col-lg-6">
						<fieldset id="fieldset-publishingdata" class="options-grid-form options-grid-form-full">
							<legend><?php echo Text::_('JGLOBAL_FIELDSET_PUBLISHING'); ?></legend>
							<div>
								<?php echo LayoutHelper::render('joomla.edit.publishingdata', $this); ?>
							</div>
						</fieldset>
					</div>
					<div class="col-12 col-lg-6">
						<fieldset id="fieldset-metadata" class="options-grid-form options-grid-form-full">
							<legend><?php echo Text::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?></legend>
							<div>
							<?php echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
							</div>
						</fieldset>
					</div>
				</div>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php if (!$isModal && $assoc) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'associations', Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS')); ?>
				<?php if ($hasAssoc) : ?>
					<fieldset id="fieldset-associations" class="options-grid-form options-grid-form-full">
					<legend><?php echo Text::_('JGLOBAL_FIELDSET_ASSOCIATIONS'); ?></legend>
					<div>
					<?php echo LayoutHelper::render('joomla.edit.associations', $this); ?>
					</div>
					</fieldset>
				<?php endif; ?>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php elseif ($isModal && $assoc) : ?>
				<div class="hidden"><?php echo LayoutHelper::render('joomla.edit.associations', $this); ?></div>
			<?php endif; ?>

			<?php if ($this->canDo->get('core.admin')) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'editor', Text::_('COM_CONTENT_SLIDER_EDITOR_CONFIG')); ?>
				<fieldset id="fieldset-editor" class="form-no-margin options-grid-form">
					<legend><?php echo Text::_('COM_CONTENT_SLIDER_EDITOR_CONFIG'); ?></legend>
					<div>
						<?php echo $this->form->renderFieldset('editorConfig'); ?>
					</div>
				</fieldset>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php if ($this->canDo->get('core.admin')) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'permissions', Text::_('COM_CONTENT_FIELDSET_RULES')); ?>
				<fieldset id="fieldset-rules" class="options-grid-form options-grid-form-full">
					<legend><?php echo Text::_('COM_CONTENT_FIELDSET_RULES'); ?></legend>
					<div>
					<?php echo $this->form->getInput('rules'); ?>
					</div>
				</fieldset>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

			<?php // Creating 'id' hiddenField to cope with com_associations sidebyside loop ?>
			<?php if ($params->get('show_publishing_options', 1) == 0) : ?>
				<?php $hidden_fields = $this->form->getInput('id'); ?>
				<div class="hidden"><?php echo $hidden_fields; ?></div>
			<?php endif; ?>

			<input type="hidden" name="task" value="">
			<input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>">
			<input type="hidden" name="forcedLanguage" value="<?php echo $input->get('forcedLanguage', '', 'cmd'); ?>">
			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
		<div class="col-lg-3 mt-5">
			<!-- alias, status, category -->
			<div class="form-no-margin jcard">
				<div class="jcard-body p-4">
					<?php echo LayoutHelper::render('joomla.edit.alias', $this); ?>
					<!-- featured & status -->
					<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'featured', 'transition', array('parent', 'parent_id'), array('published', 'state', 'enabled') ), 'data' => $this)); ?>
				</div>
			</div>

			<!-- category -->
			<div class="form-inline-group mt-4">
				<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'category', 'catid' ), 'data' => $this)); ?>
			</div>
			<!-- tags -->
			<div class="control-group">
				<p class="mt-4"><?php echo Text::_('COM_CONTENT_FIELD_SHOW_TAGS_LABEL'); ?></p>
				<?php echo $this->form->getInput('tags'); ?>
			</div>
				
			<?php if (Multilanguage::isEnabled()) : ?>
				<!-- language -->
				<div class="form-inline-group mt-4">
					<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'language' ), 'data' => $this)); ?>
				</div>
			<?php endif; ?>
			<!-- created -->
			<div class="form-inline-group mt-4">
				<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'created' ), 'data' => $this)); ?>
			</div>
			<!-- access -->
			<div class="form-inline-group mt-4">
				<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'access' ), 'data' => $this)); ?>
			</div>
			<!-- metadata -->
			<p><?php echo Text::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'); ?></p>
			<div class="bg-white px-3 mt-4 form-no-margin card">
				<?php echo LayoutHelper::render('joomla.edit.metadata', $this); ?>
			</div>
		</div>
	</div>
</form>
