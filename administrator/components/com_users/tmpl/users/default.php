<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Access\Access;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\String\PunycodeHelper;

HTMLHelper::_('webcomponent', 'system/joomla-modal.min.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('behavior.tabstate');

$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$loggeduser = Factory::getUser();
$tfa        = PluginHelper::isEnabled('twofactorauth');

?>
<form action="<?php echo Route::_('index.php?option=com_users&view=users'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php
				// Search tools bar
				echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
				?>
				<?php if (empty($this->items)) : ?>
					<div class="j-alert j-alert-info d-flex mt-4">
						<div class="j-alert-icon-wrap"><span class="icon-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span></div>
						<div class="j-alert-info-wrap"><?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?></div>
					</div>
				<?php else : ?>
					<table class="table j-list-table" id="userList">
						<caption id="captionTable" class="sr-only">
							<?php echo Text::_('COM_USERS_USERS_TABLE_CAPTION'); ?>, <?php echo Text::_('JGLOBAL_SORTED_BY'); ?>
						</caption>
						<thead>
							<tr>
								<td style="width:1%" class="text-center">
									<?php echo HTMLHelper::_('grid.checkall'); ?>
								</td>
								<th scope="col">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_USERS_HEADING_NAME', 'a.name', $listDirn, $listOrder); ?>
								</th>
								<th scope="col" class="text-center">
									<?php echo Text::_('COM_USERS_DEBUG_PERMISSIONS'); ?>
								</th>
								<th scope="col" style="width:10%; " class="d-none d-md-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_USERNAME', 'a.username', $listDirn, $listOrder); ?>
								</th>
								<th scope="col" style="width:5%;" class="text-center d-none d-lg-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_USERS_HEADING_ENABLED', 'a.block', $listDirn, $listOrder); ?>
								</th>
								<th scope="col" style="width:5%;" class="text-center d-md-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_USERS_HEADING_ACTIVATED', 'a.activation', $listDirn, $listOrder); ?>
								</th>
								<?php if ($tfa) : ?>
								<th scope="col" style="width:5%" class="text-center d-none d-md-table-cell">
									<?php echo Text::_('COM_USERS_HEADING_TFA'); ?>
								</th>
								<?php endif; ?>
								<th scope="col" style="width:12%" class="d-none d-md-table-cell">
									<?php echo Text::_('COM_USERS_HEADING_GROUPS'); ?>
								</th>
								<th scope="col" style="width:12%;" class="d-none d-xl-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_EMAIL', 'a.email', $listDirn, $listOrder); ?>
								</th>
								<th scope="col" style="width:12%" class="d-none d-xl-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_USERS_HEADING_LAST_VISIT_DATE', 'a.lastvisitDate', $listDirn, $listOrder); ?>
								</th>
								<th scope="col" style="width:12%" class="d-none d-xl-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_USERS_HEADING_REGISTRATION_DATE', 'a.registerDate', $listDirn, $listOrder); ?>
								</th>
								<th scope="col" style="width:5%" class="d-none d-md-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($this->items as $i => $item) :
							$canEdit   = $this->canDo->get('core.edit');
							$canChange = $loggeduser->authorise('core.edit.state',	'com_users');

							// If this group is super admin and this user is not super admin, $canEdit is false
							if ((!$loggeduser->authorise('core.admin')) && Access::check($item->id, 'core.admin'))
							{
								$canEdit   = false;
								$canChange = false;
							}
						?>
							<tr class="row<?php echo $i % 2; ?>">
								<td class="text-center">
									<?php if ($canEdit || $canChange) : ?>
										<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
									<?php endif; ?>
								</td>
								<th class="text-nowrap" scope="row">
									<div class="name break-word">
									<?php if ($canEdit) : ?>
										<a href="<?php echo Route::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::sprintf('COM_USERS_EDIT_USER', $this->escape($item->name)); ?>">
											<?php echo $this->escape($item->name); ?></a>
									<?php else : ?>
										<?php echo $this->escape($item->name); ?>
									<?php endif; ?>
									</div>
									<div class="btn-group">
										<?php echo HTMLHelper::_('users.addNote', $item->id); ?>
										<?php if ($item->note_count > 0) : ?>
										<button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="sr-only"><?php echo Text::_('JGLOBAL_TOGGLE_DROPDOWN'); ?></span>
										</button>
										<div class="dropdown-menu">
											<?php echo HTMLHelper::_('users.filterNotes', $item->note_count, $item->id); ?>
											<?php echo HTMLHelper::_('users.notes', $item->note_count, $item->id); ?>
										</div>
										<?php endif; ?>
									</div>
									<?php echo HTMLHelper::_('users.notesModal', $item->note_count, $item->id); ?>
									<?php if ($item->requireReset == '1') : ?>
										<span class="badge badge-warning"><?php echo Text::_('COM_USERS_PASSWORD_RESET_REQUIRED'); ?></span>
									<?php endif; ?>
								</th>
								<td class="text-center d-none d-lg-table-cell">
									<a href="<?php echo Route::_('index.php?option=com_users&view=debuguser&user_id=' . (int) $item->id); ?>" class="btn btn-secondary btn-sm">
										<span class="icon-list-thin" aria-hidden="true"></span>
										<span class="sr-only"><?php echo Text::_('COM_USERS_DEBUG_PERMISSIONS'); ?></span>
									</a>
								</td>
								<td class="break-word d-none d-md-table-cell">
									<?php echo $this->escape($item->username); ?>
								</td>
								<td class="text-center d-md-table-cell">
									<?php $self = $loggeduser->id == $item->id; ?>
									<?php if ($canChange) : ?>
										<?php echo HTMLHelper::_('jgrid.state', HTMLHelper::_('users.blockStates', $self), $item->block, $i, 'users.', !$self); ?>
									<?php else : ?>
										<?php echo HTMLHelper::_('jgrid.state', HTMLHelper::_('users.blockStates', $self), $item->block, $i, 'users.', false);; ?>
									<?php endif; ?>
								</td>
								<td class="text-center d-md-table-cell">
									<?php
									$activated = empty( $item->activation) ? 0 : 1;
									echo HTMLHelper::_('jgrid.state', HTMLHelper::_('users.activateStates'), $activated, $i, 'users.', (boolean) $activated);
									?>
								</td>
								<?php if ($tfa) : ?>
								<td class="text-center d-none d-md-table-cell tbody-icon">
									<?php if (!empty($item->otpKey)) : ?>
										<span class="icon-publish" aria-hidden="true"></span>
										<span class="sr-only"><?php echo Text::_('COM_USERS_TFA_ACTIVE'); ?></span>
									<?php else : ?>
										<span class="icon-unpublish" aria-hidden="true"></span>
										<span class="sr-only"><?php echo Text::_('COM_USERS_TFA_NOTACTIVE'); ?></span>
									<?php endif; ?>
								</td>
								<?php endif; ?>
								<td class="d-none d-md-table-cell">
									<?php if (substr_count($item->group_names, "\n") > 1) : ?>
										<span tabindex="0"><?php echo Text::_('COM_USERS_USERS_MULTIPLE_GROUPS'); ?></span>
										<div role="tooltip" id="tip<?php echo $i; ?>">
											<strong><?php echo Text::_('COM_USERS_HEADING_GROUPS'); ?></strong>
											<ul><li><?php echo str_replace("\n", '</li><li>', $item->group_names); ?></li></ul>
										</div>
									<?php else : ?>
										<?php echo nl2br($item->group_names); ?>
									<?php endif; ?>
								</td>
								<td class="d-none d-xl-table-cell break-word">
									<?php echo PunycodeHelper::emailToUTF8($this->escape($item->email)); ?>
								</td>
								<td class="d-none d-xl-table-cell">
									<?php if ($item->lastvisitDate != $this->db->getNullDate()) : ?>
										<?php echo HTMLHelper::_('date', $item->lastvisitDate, Text::_('DATE_FORMAT_LC6')); ?>
									<?php else : ?>
										<?php echo Text::_('JNEVER'); ?>
									<?php endif; ?>
								</td>
								<td class="d-none d-xl-table-cell">
									<?php echo HTMLHelper::_('date', $item->registerDate, Text::_('DATE_FORMAT_LC6')); ?>
								</td>
								<td class="d-none d-md-table-cell">
									<?php echo (int) $item->id; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- load the pagination. -->
					<div class="j-pagination-footer">
						<?php echo LayoutHelper::render('joomla.searchtools.default.listlimit', array('view' => $this)); ?>
						<?php echo $this->pagination->getListFooter(); ?>
					</div>

					<?php // Load the batch processing form if user is allowed ?>
					<?php if ($loggeduser->authorise('core.create', 'com_users')
						&& $loggeduser->authorise('core.edit', 'com_users')
						&& $loggeduser->authorise('core.edit.state', 'com_users')) : ?>
							<joomla-modal role="dialog" id="collapseModal" title="<?php echo Text::_('COM_USERS_BATCH_OPTIONS'); ?>" width="80vw" height="100%">
								<section>
									<?php echo $this->loadTemplate('batch_body'); ?>
								</section>
								<footer>
									<?php echo $this->loadTemplate('batch_footer'); ?>
								</footer>
							</joomla-modal>
					<?php endif; ?>
				<?php endif; ?>

				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
