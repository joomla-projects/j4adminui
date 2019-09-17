<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$form  = $displayData->getForm();
$alias = $form->getValue('alias', '');

?>
<div class="alias-wrap">
	<div class="alias-text">
		<div class="control-group alias-text">
			<div class="control-label">
				<label id="jform_alias-lbl" for="jform_alias"><?php echo JText::_('JALIAS'); ?></label>
			</div>
			<div class="controls">
				<span><?php echo $alias; ?></span>
			</div>
		</div>
	</div>

	<div class="alias-edit d-none">
		<?php echo $form->renderField('alias'); ?>
	</div>

	<a id="edit-alias" href="javascript:void(0);"><i class="fas fa-edit"></i></a>
</div>