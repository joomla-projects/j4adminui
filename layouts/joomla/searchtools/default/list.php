<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;

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
	<div class="ordering-select d-none d-xl-block">
		<?php foreach ($list as $fieldName => $field) : ?>
			<?php if($fieldName !== 'list_limit') : ?>
				<div class="js-stools-field-list">
					<div class="js-stools-field-list-content j-card">
						<?php if($fieldName === 'list_fullordering') : ?>
							<span class="js-stools-sort-by-label"><?php echo JText::_('JGLOBAL_ORDER_BY'); ?></span>
						<?php endif; ?>
						<div class="js-stools-list-inner">
							<span class="sr-only"><?php echo $field->label; ?></span>
							<?php echo $field->input; ?>
						</div>
					</div>
					<?php if($fieldName === 'list_fullordering') : ?>
						<button type="button" class="btn btn-link js-stools-order-toggler hasTooltip" title="<?php echo !empty($orderDirn) && strtoupper($orderDirn) === 'ASC' ? Text::_('JGLOBAL_ORDER_DESCENDING_DIRN') : Text::_('JGLOBAL_ORDER_ASCENDING_DIRN'); ?>"><i class="duotone icon-lg <?php echo !empty($orderDirn) && strtoupper($orderDirn) === 'ASC' ? 'icon-descending' : 'icon-ascending'; ?>"></i></button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
