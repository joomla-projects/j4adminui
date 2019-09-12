<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<div class="registration<?php echo $this->pageclass_sfx; ?>">
	<div class="row justify-content-center">
		<div class="col-md-9 col-lg-6">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<div class="page-header">
					<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
				</div>
			<?php endif; ?>

			<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
				<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
					<?php $fields = $this->form->getFieldset($fieldset->name); ?>
					<?php if (count($fields)) : ?>
						<?php foreach ($fields as $field) : ?>
							<?php if ($field->hidden) : ?>
								<?php echo $field->input; ?>
							<?php else : ?>
								<div class="form-group">
									<div class="d-none"><?php echo $field->label; ?></div>
									<?php echo ($field->__set('hint', JText::_($field->getAttribute('label')))); ?>
									<?php echo $field->input; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<div>
				<button type="submit" class="btn btn-primary mt-4 validate">Register Now</button>
				<input type="hidden" name="option" value="com_users">
				<input type="hidden" name="task" value="registration.register">
			</div>
			<?php echo JHtml::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
