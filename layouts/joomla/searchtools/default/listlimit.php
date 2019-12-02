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

?>
<?php if(!empty($list) && isset($list['list_limit'])) : ?>
	<div class="ordering-select d-none d-sm-block">
		<div class="j-list-limit">
			<div class="j-list-limit-label" id="list_limit_lbl">
				<?php echo Text::_('JGLOBAL_ITEM_PER_PAGE'); ?>
			</div>
			<div class="j-list-limit-input" aria-labelledby="list_limit_lbl">
				<?php echo $list['list_limit']->input; ?>
			</div>
		</div>
	</div>
<?php endif; ?>