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
<div class="row" id="<?php echo str_replace(' ', '', $module->title) . $module->id; ?>">
	<?php foreach ($users as $user) : ?>
		<div class="col">
			<div class="j-card j-card-has-hover">
				<div class="j-card-header j-card-header-sm">
                    <h4 class="j-card-title">
						<?php if ($user->client_id === null) : ?>
							<?php // Don't display a client ?>
						<?php elseif ($user->client_id) : ?>
							<?php echo Text::_('JADMINISTRATION'); ?>
						<?php else: ?>
							<?php echo Text::_('JSITE'); ?>
						<?php endif; ?>
                    </h4>
                </div>

				<div class="j-card-body text-center">
					<div class="j-user-avatar mb-3">
						<span class="icon-user" area-hidden="true"></span>
					</div>
					<div>
						<?php if (isset($user->editLink)) : ?>
							<a href="<?php echo $user->editLink; ?>">
								<strong><?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></strong>
							</a>
						<?php else : ?>
							<strong><?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></strong>
						<?php endif; ?>
					</div>
					<div class="text-muted mb-3">
						<?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>
					</div>
					<div>
						<?php echo HTMLHelper::_('date', $user->time, Text::_('DATE_FORMAT_LC5')); ?>
					</div>
				</div>
				<div class="j-card-footer j-card-footer-lg">
					<div class="j-card-footer-item">
						<form action="<?php echo $user->logoutLink; ?>" method="post" name="adminForm">
							<button type="submit">
								<span class="j-card-icon fas fa-key"></span> <?php echo Text::_('JLOGOUT'); ?>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
