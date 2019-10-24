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
use Joomla\CMS\Language\Text;

/**
 * @var  string  $id
 * @var  string  $onclick
 * @var  string  $class
 * @var  string  $text
 * @var  string  $btnClass
 * @var  string  $tagName
 * @var  string  $htmlAttributes
 * @var  string  $hasButtons
 * @var  string  $button
 * @var  string  $dropdownItems
 * @var  string  $caretClass
 * @var  string  $toggleSplit
 */
extract($displayData, EXTR_OVERWRITE);
?>
<?php if ($hasButtons && trim($button) !== ''): ?>
	<?php HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version'=> 'auto', 'relative' => true)); ?>
	<div id="<?php echo $id; ?>" class="joomla-dropdown-container" role="group">
		<?php if ($toggleSplit ?? true): ?>
			<div class="toolbar-btn-group">
				<?php echo $button; ?>
				<button type="button" class="<?php echo $caretClass ?? ''; ?> dropdown-toggle dropdown-toggle-split" data-target="<?php echo $id; ?>" data-display="static" aria-haspopup="true" aria-expanded="false">
					<span class="icon-chevron-down icon-md" area-hidden="true" title="<?php echo Text::_('JGLOBAL_TOGGLE_DROPDOWN'); ?>"></span>
				</button>
			</div>
		<?php else: ?>
			<?php echo $button; ?>
		<?php endif; ?>
		
		<?php if (trim($dropdownItems) !== ''): ?>
			<joomla-dropdown for="<?php echo $id; ?>">
				<?php echo $dropdownItems; ?>
			</joomla-dropdown>
		<?php endif; ?>
	</div>
<?php endif; ?>
