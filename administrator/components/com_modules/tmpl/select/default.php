<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$app = Factory::getApplication();

$function  = $app->input->getCmd('function');

if ($function) :
	HTMLHelper::_('script', 'com_modules/admin-select-modal.js', ['version' => 'auto', 'relative' => true]);
endif;
?>

<h2 class="mb-3"><?php echo Text::_('COM_MODULES_TYPE_CHOOSE'); ?></h2>
<div id="new-modules-list">
	<div class="row">
		<?php foreach ($this->items as &$item) : ?>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<div class="j-card mb-4">
					<?php // Prepare variables for the link. ?>
					<?php $link = 'index.php?option=com_modules&task=module.add&client_id=' . $this->state->get('client_id', 0) . $this->modalLink . '&eid=' . $item->extension_id; ?>
					<?php $name = $this->escape($item->name); ?>
					<?php $desc = HTMLHelper::_('string.truncate', $this->escape(strip_tags($item->desc)), 200); ?>

					<div class="j-card-header">
						<strong><?php echo $name; ?></strong>
					</div>

					<div class="j-card-body">
						<p class="text-muted m-0">
							<?php echo $desc; ?>
						</p>
					</div>

					<div class="j-card-footer">
						<div class="j-card-footer-item">
							<a href="<?php echo Route::_($link); ?>" class="<?php echo $function ? ' select-link" data-function="' . $this->escape($function) : ''; ?>" class="j-card-link">
								<?php echo Text::_('COM_MODULES_SELECT'); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
