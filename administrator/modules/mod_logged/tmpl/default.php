<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_logged
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
?>
<div id="<?php echo str_replace(' ', '', $module->title) . $module->id; ?>">
	<div class="list-group list-group-flush">
		<?php foreach ($users as $user) : ?>
			<div class="list-group-item py-4">
				<div class="row align-items-center">
					<div class="col-auto">
						<div class="j-user-avatar">
							<span class="icon-user" area-hidden="true"></span>
						</div>
					</div>

					<div class="col-6 col-lg-3">
						<?php if (isset($user->editLink)) : ?>
							<a href="<?php echo $user->editLink; ?>">
								<strong><?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></strong>
							</a>
						<?php else : ?>
							<strong><?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></strong>
						<?php endif; ?>

						<div class="text-muted">
							<?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>
						</div>
					</div>

					<div class="d-none d-lg-block col-lg-3">
						<?php if ($user->client_id === null) : ?>
							<?php // Don't display a client ?>
						<?php elseif ($user->client_id) : ?>
							<?php echo Text::_('JADMINISTRATION'); ?>
						<?php else: ?>
							<?php echo Text::_('JSITE'); ?>
						<?php endif; ?>

						<div class="text-muted">
							<?php echo HTMLHelper::_('date', $user->time, Text::_('DATE_FORMAT_LC5')); ?>
						</div>
					</div>

					<div class="col-auto ml-auto">
						<form action="<?php echo $user->logoutLink; ?>" method="post" name="adminForm">
							<button type="submit" class="btn btn-link btn-sm m-n2">
								<span class="j-card-icon icon-exit"></span> <?php echo Text::_('JLOGOUT'); ?>
							</button>
						</form>
					</div>

				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
