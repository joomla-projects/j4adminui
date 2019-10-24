<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$this->fieldset = 'jbasic';
?>

<div id="fieldset-display" class="j-card options-grid-form options-grid-form-full mb-4">
	<div class="j-card-header">
		<?php echo Text::_('JGLOBAL_FIELDSET_DISPLAY_OPTIONS'); ?>
	</div>
	<div class="j-card-body">
		<?php echo LayoutHelper::render('joomla.edit.fieldset', $this); ?>
	</div>
</div>
