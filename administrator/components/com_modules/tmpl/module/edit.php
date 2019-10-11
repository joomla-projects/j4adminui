<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
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
use Joomla\CMS\Language\Multilanguage;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.combobox');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.tabstate');

$hasContent = isset($this->item->xml->customContent);
$hasContentFieldName = 'content';

// For a later improvement
if ($hasContent)
{
	$hasContentFieldName = 'content';
}

// Get Params Fieldsets
$this->fieldsets = $this->form->getFieldsets('params');
$this->useCoreUI = true;

Text::script('JYES');
Text::script('JNO');
Text::script('JALL');
Text::script('JTRASHED');

Factory::getDocument()->addScriptOptions('module-edit', ['itemId' => $this->item->id, 'state' => (int) $this->item->id == 0 ? 'Add' : 'Edit']);
HTMLHelper::_('script', 'com_modules/admin-module-edit.min.js', array('version' => 'auto', 'relative' => true));

$input = Factory::getApplication()->input;

// In case of modal
$isModal = $input->get('layout') == 'modal' ? true : false;
$layout  = $isModal ? 'modal' : 'edit';
$tmpl    = $isModal || $input->get('tmpl', '', 'cmd') === 'component' ? '&tmpl=component' : '';

?>

<form action="<?php echo Route::_('index.php?option=com_modules&layout=' . $layout . $tmpl . '&client_id=' . $this->form->getValue('client_id') . '&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="module-form" class="form-validate">

	<div class="row">
		<div class="col-lg-9">
			<div class="form-no-margin form-title-wrap">
				<?php echo LayoutHelper::render('joomla.edit.title', $this); ?>
			</div>		

			<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'general')); ?>

			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'general', Text::_('COM_MODULES_MODULE')); ?>

				<div class="j-card">
					<?php if ($this->item->xml) : ?>
						<?php if ($this->item->xml->description) : ?>
							<div class="j-card-header">
								<h2 class="j-card-title">
									<?php
									if ($this->item->xml)
									{
										echo ($text = (string) $this->item->xml->name) ? Text::_($text) : $this->item->module;
									}
									else
									{
										echo Text::_('COM_MODULES_ERR_XML');
									}
									?>
									<span class="badge badge-success">
										<?php echo $this->item->client_id == 0 ? Text::_('JSITE') : Text::_('JADMINISTRATOR'); ?>
									</span>
									<small class="d-block mt-2">
										<?php
										$this->fieldset    = 'description';
										$short_description = Text::_($this->item->xml->description);
										$this->fieldset    = 'description';
										$long_description  = LayoutHelper::render('joomla.edit.fieldset', $this);

										if (!$long_description)
										{
											$truncated = JHtmlString::truncate($short_description, 550, true, false);

											if (strlen($truncated) > 500)
											{
												$long_description  = $short_description;
												$short_description = JHtmlString::truncate($truncated, 250);

												if ($short_description == $long_description)
												{
													$long_description = '';
												}
											}
										}
										?>
										<?php echo $short_description; ?>
										<?php if ($long_description) : ?>
											<span class="readmore d-block j-card-link">
												<a href="#" onclick="document.querySelector('#tab-description').click();">
													<?php echo Text::_('JGLOBAL_SHOW_FULL_DESCRIPTION'); ?>
												</a>
											</span>
										<?php endif; ?>
									</small>
								</h2>
							</div>
						<?php endif; ?>
					<?php else : ?>
						<div class="p-3">
							<div class="j-alert j-alert-danger">
								<span class="icon-warning" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('ERROR'); ?></span>
								<?php echo Text::_('COM_MODULES_ERR_XML'); ?>
							</div>
						</div>
					<?php endif; ?>
					<div class="j-card-body">
						<?php
						if ($hasContent)
						{
							echo $this->form->getInput($hasContentFieldName);
						}
						$this->fieldset = 'basic';
						$html = LayoutHelper::render('joomla.edit.fieldset', $this);
						echo $html;
						?>
					</div>
				</div>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>

			<?php if (isset($long_description) && $long_description != '') : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'description', Text::_('JGLOBAL_FIELDSET_DESCRIPTION')); ?>
					<div class="j-card">
						<div class="j-card-body">
							<?php echo $long_description; ?>
						</div>
					</div>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php if ($this->item->client_id == 0) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'assignment', Text::_('COM_MODULES_MENU_ASSIGNMENT')); ?>
				<fieldset id="fieldset-assignment">
					<?php echo $this->loadTemplate('assignment'); ?>
				</fieldset>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php
				$this->fieldsets        = array();
				$this->ignore_fieldsets = array('basic', 'description');
				echo LayoutHelper::render('joomla.edit.params', $this);
			?>

			<?php if ($this->canDo->get('core.admin')) : ?>
				<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'permissions', Text::_('COM_MODULES_FIELDSET_RULES')); ?>
				<fieldset id="fieldset-permissions" class="options-grid-form options-grid-form-full">
					<?php echo $this->form->getInput('rules'); ?>
				</fieldset>
				<?php echo HTMLHelper::_('uitab.endTab'); ?>
			<?php endif; ?>

			<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

			<input type="hidden" name="task" value="">
			<input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>">
			<?php echo HTMLHelper::_('form.token'); ?>
			<?php echo $this->form->getInput('module'); ?>
			<?php echo $this->form->getInput('client_id'); ?>
		</div>

		<div class="col-lg-3">
			<?php
			// Set main fields.
			$this->fields = array(
				'showtitle',
				'published',
				'position',
				'ordering',
				'access',
				'publish_up',
				'publish_down',
				'language',
				'note'
			);
			?>
			<!-- if site modules -->
			<?php if ($this->item->client_id == 0) : ?>
				<!-- title & status -->
				<div class="j-card form-no-margin">
					<div class="j-card-body">
						<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'showtitle', 'published' ), 'data' => $this)); ?>
					</div>
				</div>
				<!-- possition -->
				<div class="form-inline-group mt-4">
					<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'position' ), 'data' => $this)); ?>
				</div>
				<!-- ordering -->
				<div class="form-inline-group mt-4">
					<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'ordering' ), 'data' => $this)); ?>
				</div>
				<!-- access -->
				<div class="form-inline-group mt-4">
					<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'access' ), 'data' => $this)); ?>
				</div>
				<!-- schedule -->
				<p class="mt-4"><?php echo JText::_('COM_MODULE_PUBLISH_SCHEDULE'); ?></p>
				<div class="j-card form-no-margin">
					<div class="j-card-body">
						<div class="row">
							<div class="col-sm-6">
								<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'publish_up' ), 'data' => $this)); ?>
							</div>
							<div class="col-sm-6">
								<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'publish_down' ), 'data' => $this)); ?>
							</div>
						</div>
					</div>
				</div>
				<!-- language -->
				<?php if (Multilanguage::isEnabled()) : ?>
					<div class="form-inline-group mt-4">
						<?php echo LayoutHelper::render('joomla.edit.fields', array( 'fields' => array( 'language' ), 'data' => $this)); ?>
					</div>
				<?php endif; ?>
					<!-- note -->
					<div class="control-group">
						<p class="mt-4"><?php echo JText::_('COM_MODULES_FIELD_NOTE_LABEL'); ?></p>
						<?php echo $this->form->getInput('note'); ?>
					</div>
			<?php else : ?>
				<?php echo LayoutHelper::render('joomla.edit.admin_modules', $this); ?>
			<?php endif; ?>		
		</div>
	</div>

</form>
