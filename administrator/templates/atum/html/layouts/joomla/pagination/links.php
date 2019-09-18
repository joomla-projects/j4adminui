<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

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

?>
<?php if($totalPages > 1) : ?>
    <joomla-pagination 
        total-visible="7"
        next-icon="fa fa-angle-right"
        prev-icon="fa fa-angle-left"
        first-icon="fa fa-angle-double-left"
        last-icon="fa fa-angle-double-right"
        navbtns-state="icon"
        disable-btns=""
        input-name="<?php echo $list['prefix']; ?>limitstart"
        pagination="true"
        limit="<?php echo $list['limit']; ?>"
    >
        <?php for($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="pagination-item <?php echo $i === (($limitStart / $list['limit']) + 1) ? 'active': ''; ?>" value="<?php echo $i; ?>" style="display: none;" ><?php echo $i; ?></li>
        <?php endfor; ?>
    </joomla-pagination>
    <?php if ($showLimitStart) : ?>
        <input type="hidden" name="<?php echo $list['prefix']; ?>limitstart" id="<?php echo $list['prefix']; ?>limitstart" value="<?php echo $list['limitstart']; ?>">
    <?php endif; ?>
<?php endif; ?>
