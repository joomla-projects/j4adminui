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

$title = $form->getField('title') ? 'title' : ($form->getField('name') ? 'name' : '');

?>
<div class="row title-alias form-no-margin mb-3">
	<div class="col-lg-7">
		<?php echo $title ? $form->renderField($title) : ''; ?>
	</div>
	<div class="col-lg-5">
		<?php echo $form->renderField('alias'); ?>
	</div>
</div>