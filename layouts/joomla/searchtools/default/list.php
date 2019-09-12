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
$state = $data['view']->get('State');

$orderDirn = 'asc';
if (isset($list['list_fullordering'])) {
	$orderDirn = explode(' ', $state->get('list.fullordering', $list['list_fullordering']->getAttribute('default')))[1];
}

?>
<?php if ($list) : ?>
	<div class="ordering-select">
		<?php foreach ($list as $fieldName => $field) : ?>
			<?php if($fieldName !== 'list_limit') : ?>
				<div class="js-stools-field-list">
					<?php if($fieldName === 'list_fullordering') : ?>
						<span class="js-stools-sort-by-label"><?php echo JText::_('JGLOBAL_ORDER_BY'); ?></span>
					<?php endif; ?>
					<div class="js-stools-list-inner">
						<span class="sr-only"><?php echo $field->label; ?></span>
						<?php echo $field->input; ?>
					</div>
				</div>
				<?php if($fieldName === 'list_fullordering') : ?>
					<button type="button" class="btn js-stools-order-toggler"><i class="fa <?php echo !empty($orderDirn) && strtoupper($orderDirn) === 'ASC' ? 'fa-sort-amount-up-alt' : 'fa-sort-amount-down-alt'; ?>"></i></button>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
