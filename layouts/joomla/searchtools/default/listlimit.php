<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

$data = $displayData;

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

// Load the form list fields
$list = $data['view']->filterForm->getGroup('list');
$listLimit = !empty($list['list_limit']) ? $list['list_limit'] :  array();

$defaultLimit = !empty($data['options']['defaultLimit']) ? $data['options']['defaultLimit'] : Factory::getApplication()->get('list_limit', 20);

$state = $data['view']->get('State');
$limit = $state->get('list.limit', $defaultLimit);
HTMLHelper::_('script', 'system/pagination.es6.min.js', array('version'=> 'auto', 'relative' => true));

?>
<?php if ($list) : ?>
	<div class="ordering-select">
        <?php if(!empty($listLimit) && count((array)$listLimit->options) > 0) : ?>
            <div class="limit-list">
                <joomla-pagination class="js-stools-list-group">
                    <li class="pagination-link listlimit-title" text="<?php echo JText::_('JSHOW'); ?>"></li>
                    <?php foreach($listLimit->options as $listOption) : ?>
                        <li class="pagination-link js-stools-field-limit-link" activeClass="<?php echo $limit === $listOption->value ? 'active' : ''; ?>" value="<?php echo $listOption->value; ?>" text="<?php echo $listOption->text; ?>"></li>
                    <?php endforeach; ?>
                </joomla-pagination>
                <input type="hidden" name="<?php echo $listLimit->name; ?>" class="js-stools-limit-list" value="<?php echo $limit; ?>">
            </div>
        <?php endif; ?>
	</div>
<?php endif; ?>