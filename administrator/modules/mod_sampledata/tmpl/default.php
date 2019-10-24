<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_sampledata
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('bootstrap.framework');
HTMLHelper::_('form.csrf');
HTMLHelper::_('script', 'mod_sampledata/sampledata-process.js', ['version' => 'auto', 'relative' => true]);

Text::script('MOD_SAMPLEDATA_CONFIRM_START');
Text::script('MOD_SAMPLEDATA_ITEM_ALREADY_PROCESSED');
Text::script('MOD_SAMPLEDATA_INVALID_RESPONSE');

$app->getDocument()->addScriptOptions(
	'sample-data',
	[
		'icon' => Uri::root(true) . '/media/system/images/ajax-loader.gif'
	]
);
?>
<?php if ($items) : ?>
	<div id="sample-data-wrapper" class="list-group list-group-flush">
		<?php foreach($items as $i => $item) : ?>
			<div class="list-group-item py-4 sampledata-<?php echo $item->name; ?>">
				<div class="d-flex">
					<span class="icon-<?php echo $item->icon; ?> icon-fw mr-3" aria-hidden="true"></span>
					<div class="w-100">
						<div class="d-flex w-100 justify-content-between">
							<h4 class="mb-1"><?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?></h4>
							<button type="button" class="btn btn-link btn-sm apply-sample-data" data-type="<?php echo $item->name; ?>" data-steps="<?php echo $item->steps; ?>">
								<span class="icon-upload" aria-hidden="true"></span> <?php echo Text::_('JLIB_INSTALLER_INSTALL'); ?>
								<span class="sr-only"><?php echo $item->title; ?></span>
							</button>
						</div>
						<p class="mt-1 mb-0 text-muted"><?php echo $item->description; ?></p>
						<?php // Progress bar ?>
						<div class="sampledata-progress-<?php echo $item->name; ?> mt-3 d-none">
							<div class="progress">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"></div>
							</div>
						</div>

						<?php // Progress messages ?>
						<div class="sampledata-progress-<?php echo $item->name; ?> mt-3 d-none">
							<ul class="list-unstyled"></ul>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<div class="j-alert j-alert-warning">
		<span class="icon-warning" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('WARNING'); ?></span>
		<?php echo Text::_('MOD_SAMPLEDATA_NOTAVAILABLE'); ?>
	</div>
<?php endif; ?>
