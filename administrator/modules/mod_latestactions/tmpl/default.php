<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_latestactions
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>
<div id="<?php echo str_replace(' ', '', $module->title) . $module->id; ?>">
	<?php if (count($list)) : ?>
		<ul class="list-group list-group-flush">
		<?php foreach ($list as $i => $item) : ?>
			<li class="list-group-item py-4">
				<h5 class="text-muted">
					<?php echo HTMLHelper::_('date', $item->log_date, Text::_('DATE_FORMAT_LC5')); ?>
				</h5>
				<?php echo $item->message; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<div class="col">
			<div class="j-card">
				<div class="j-card-body">
					<p class="text-warning m-0">
						<?php echo Text::_('MOD_LATEST_ACTIONS_NO_MATCHING_RESULTS'); ?>
					</p>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
