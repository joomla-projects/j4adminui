<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$data = $displayData;

// Load the form list fields
$list = $data['view']->filterForm->getGroup('list');
// echo '<xmp>';
// print_r($list);
// echo '</xmp>';die();
?>
<?php if ($list) : ?>
	<div class="ordering-select">
		<?php foreach ($list as $fieldName => $field) : ?>
			<?php if($fieldName !== 'list_limit') : ?>
				<div class="js-stools-field-list">
					<div class="js-stools-list-inner">
						<span class="sr-only"><?php echo $field->label; ?></span>
						<?php if($fieldName === 'list_fullordering') : ?>
							<span class="js-stools-sort-by-label"><?php echo JText::_('JGLOBAL_ORDER_BY'); ?></span>
						<?php endif; ?>
						<?php echo $field->input; ?>
					</div>
					
					<?php if($fieldName === 'list_fullordering') : ?>
						<button type="button" class="btn js-stools-order-toggler"><i class="fa fa-sort-amount-down-alt"></i></button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
