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

$id      = empty($displayData['id']) ? '' : (' id="' . $displayData['id'] . '"');
$target  = empty($displayData['target']) ? '' : (' target="' . $displayData['target'] . '"');
$onclick = empty($displayData['onclick']) ? '' : (' onclick="' . $displayData['onclick'] . '"');

if (isset($displayData['ajaxurl'])) {
	$size = 'small';
	$dataUrl = 'data-url="' . $displayData['ajaxurl'] . '"';
} else {
	$size = 'big';
	$dataUrl = '';
}

// The title for the link (a11y)
$title = empty($displayData['title']) ? '' : (' title="' . $this->escape($displayData['title']) . '"');

// The information
$text = empty($displayData['text']) ? '' : ('<span class="j-links-link">' . $displayData['text'] . '</span>');

$tmp = [];

// Set id and class pulse for update icons
if ($id && ($displayData['id'] === 'plg_quickicon_joomlaupdate'
	|| $displayData['id'] === 'plg_quickicon_extensionupdate'
	|| $displayData['id'] === 'plg_quickicon_privacycheck'
	|| $displayData['id'] === 'plg_quickicon_overridecheck'
	|| !empty($displayData['class'])))
{
	$tmp[] = 'pulse';
}

// Add the button class
if (!empty($displayData['class']))
{
	$tmp[] = $this->escape($displayData['class']);
}

// Make the class string
$class = !empty($tmp) ? implode(' ', array_unique($tmp)) : '';
?>
<div class="col-lg-3" data-dragable-group="none">
	<div <?php echo $id; ?> class="jcard jcard-has-hover mb-4 <?php echo $class; ?>" data-quick-icon>
		<div class="jcard-header jcard-header-sm">
			<div class="jcard-header-right">
				<span class="order jcard-header-icon fas fa-ellipsis-h"></span>
			</div>
		</div>
		<div class="jcard-overview-box">
			<div class="jcard-overview-icon j-warning">
				<i class="<?php echo $displayData['image']; ?>"></i>
			</div>
			<div class="jcard-overview-content">
				65
				<?php // Name indicates the component
				if (isset($displayData['name'])): ?>
					<sub <?php echo isset($displayData['ajaxurl']) ? ' aria-hidden="true"' : ''; ?>>
						<?php echo Text::_($displayData['name']); ?>
					</sub>
				<?php endif; ?>
			</div>
		</div>

		<?php // Add the link to the edit-form
		if (isset($displayData['linkadd'])): ?>
			<div class="jcard-footer jcard-footer-lg">
				<div class="jcard-footer-item">
					<a href="<?php echo $displayData['linkadd']; ?>">
						<span class="fa fa-plus jcard-icon" aria-hidden="true"></span>
						<span class="sr-only"><?php echo Text::_($displayData['name'] . '_ADD_SRONLY'); ?></span>
						<span aria-hidden="true"><?php echo Text::_($displayData['name'] . '_ADD'); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>

		<!-- <div class="card-body">
			<div class="d-flex align-items-center">
				<div class="quickicon-icon">
					<div class="<?php echo $displayData['image']; ?> fa-2x" aria-hidden="true"></div>
				</div>
				
				<?php if (isset($displayData['ajaxurl'])) : ?>
					<div class="quickicon-amount" <?php echo $dataUrl ?> aria-hidden="true">
						<span class="fa fa-spinner" aria-hidden="true"></span>
					</div>
					<div class="quickicon-sr-desc sr-only"></div>
				<?php endif; ?>

				
			</div>
			
			<?php // Information or action from plugins
			if (isset($displayData['text'])): ?>
				<div class="quickicon-text d-flex align-items-center">
					<?php echo $text; ?>
				</div>
			<?php endif; ?>
			<a href="<?php echo $displayData['link']; ?>"<?php echo $target . $onclick . $title; ?>" class="stretched-link"><span class="sr-only"><?php echo $title; ?></span></a>
		</div> -->
		<input type="hidden" name="sub_module_name[]" value="<?php echo Text::_($displayData['name']); ?>" class="width-20 text-area-order">
	</div>
</div>
