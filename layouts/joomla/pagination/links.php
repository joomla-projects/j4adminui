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
use Joomla\Registry\Registry;
use Joomla\CMS\HTML\HTMLHelper;

$list  = $displayData['list'];
$pages = $list['pages'];

HTMLHelper::_('webcomponent', 'system/joomla-pagination.es6.min.js', array('version'=> 'auto', 'relative' => true));

$options = new Registry($displayData['options']);


$showLimitBox   = $options->get('showLimitBox', false);
$showPagesLinks = $options->get('showPagesLinks', true);
$showLimitStart = $options->get('showLimitStart', true);
$totalPages = ceil($list['total'] / $list['limit']);
$limitStart = $list['limitstart'];

$showResultFrom = (($limitStart / $list['limit'])) * $list['limit'] + 1;
$showResultTo = (($limitStart / $list['limit']) + 1) * $list['limit'];
if ($showResultTo > $list['total']) {
$showResultTo = $list['total'];
}
$resultMsg = Text::sprintf('JGLOBAL_SHOW_PAGINATION_MSG', $showResultFrom, $showResultTo, $list['total']);

?>
<?php if($totalPages > 1) : ?>
<joomla-pagination 
	class="j-pagination"
	total-visible="7"
	next-icon="icon-chevron-right"
	prev-icon="icon-chevron-left"
	first-icon="icon-first"
	last-icon="icon-last"
	navbtns-state="icon"
	disable-btns=""
	input-selector="#<?php echo $list['prefix']; ?>limitstart"
	pagination="true"
	limit="<?php echo $list['limit']; ?>"
	result-msg="<?php echo $resultMsg; ?>"
>
	<?php for($i = 1; $i <= $totalPages; $i++) : ?>
		<li class="pagination-item <?php echo $i === (($limitStart / $list['limit']) + 1) ? 'active': ''; ?>" value="<?php echo $i; ?>" style="display: none;" ><?php echo $i; ?></li>
	<?php endfor; ?>
</joomla-pagination>
<?php if ($showLimitStart) : ?>
	<input type="hidden" name="<?php echo $list['prefix']; ?>limitstart" id="<?php echo $list['prefix']; ?>limitstart" value="<?php echo $list['limitstart']; ?>">
<?php endif; ?>
<?php endif; ?>
