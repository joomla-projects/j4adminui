<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_categories
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\String\Inflector;

HTMLHelper::_('webcomponent', 'system/joomla-modal.min.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('behavior.multiselect');

$user      = Factory::getUser();
$userId    = $user->get('id');
$extension = $this->escape($this->state->get('filter.extension'));
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = ($listOrder == 'a.lft' && strtolower($listDirn) == 'asc');
$parts     = explode('.', $extension, 2);
$component = $parts[0];
$section   = null;

if (count($parts) > 1)
{
	$section = $parts[1];

	$inflector = Inflector::getInstance();

	if (!$inflector->isPlural($section))
	{
		$section = $inflector->toPlural($section);
	}
}

if ($saveOrder && !empty($this->items))
{
	$saveOrderingUrl = 'index.php?option=com_categories&task=categories.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
	HTMLHelper::_('draggablelist.draggable');
}
?>
<form action="<?php echo Route::_('index.php?option=com_categories&view=categories&extension=' . $this->state->get('filter.extension')); ?>" method="post" name="adminForm" id="adminForm">
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
					<table class="table j-list-table" id="categoryList">
						<caption id="captionTable" class="sr-only">
							<?php echo Text::_('COM_CATEGORIES_TABLE_CAPTION'); ?>, <?php echo Text::_('JGLOBAL_SORTED_BY'); ?>
						</caption>
						<thead>
							<tr>
								<td scope="col" class="text-center" style="width:  3rem">
									<?php echo HTMLHelper::_('grid.checkall'); ?>
								</td>
								<th scope="col" class="d-none d-md-table-cell" style="width:  3rem">
									<?php echo HTMLHelper::_('searchtools.sort', '', 'a.lft', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-caret-v'); ?>
								</th>
								<th scope="col" class="text-center" style="width:  3rem">
									<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
								</th>
								<th scope="col">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
								</th>
								<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_published')) : ?>
									<th scope="col" class="d-none d-xl-table-cell" style="width:  3rem">
										<span class="icon-publish text-success" aria-hidden="true" title="<?php echo Text::_('COM_CATEGORY_COUNT_PUBLISHED_ITEMS'); ?>"></span>
										<span class="sr-only"><?php echo Text::_('COM_CATEGORY_COUNT_PUBLISHED_ITEMS'); ?></span>
									</th>
								<?php endif; ?>
								<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_unpublished')) : ?>
									<th scope="col" class="d-none d-xl-table-cell" style="width:  3rem">
										<span class="icon-unpublish text-mute" aria-hidden="true" title="<?php echo Text::_('COM_CATEGORY_COUNT_UNPUBLISHED_ITEMS'); ?>"></span>
										<span class="sr-only"><?php echo Text::_('COM_CATEGORY_COUNT_UNPUBLISHED_ITEMS'); ?></span>
									</th>
								<?php endif; ?>
								<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_archived')) : ?>
									<th scope="col" class="d-none d-xl-table-cell" style="width:  3rem">
										<span class="icon-briefcase text-warning" aria-hidden="true" title="<?php echo Text::_('COM_CATEGORY_COUNT_ARCHIVED_ITEMS'); ?>"></span>
										<span class="sr-only"><?php echo Text::_('COM_CATEGORY_COUNT_ARCHIVED_ITEMS'); ?></span>
									</th>
								<?php endif; ?>
								<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_trashed')) : ?>
									<th scope="col" class="d-none d-xl-table-cell" style="width:  3rem">
										<span class="icon-trash text-danger" aria-hidden="true" title="<?php echo Text::_('COM_CATEGORY_COUNT_TRASHED_ITEMS'); ?>"></span>
										<span class="sr-only"><?php echo Text::_('COM_CATEGORY_COUNT_TRASHED_ITEMS'); ?></span>
									</th>
								<?php endif; ?>
								<th scope="col" class="d-none d-xl-table-cell" style="width: 10%">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'access_level', $listDirn, $listOrder); ?>
								</th>
								<?php if ($this->assoc) : ?>
									<th scope="col" class="d-none d-xl-table-cell" style="width: 10%">
										<?php echo HTMLHelper::_('searchtools.sort', 'COM_CATEGORY_HEADING_ASSOCIATION', 'association', $listDirn, $listOrder); ?>
									</th>
								<?php endif; ?>
								<?php if (Multilanguage::isEnabled()) : ?>
									<th scope="col" class="d-none d-xl-table-cell" style="width: 10%">
										<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language_title', $listDirn, $listOrder); ?>
									</th>
								<?php endif; ?>
								<th scope="col" class="d-none d-xl-table-cell" style="width: 3rem">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</th>
							</tr>
						</thead>
						<tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php endif; ?>>
							<?php foreach ($this->items as $i => $item) : ?>
								<?php
								$canEdit    = $user->authorise('core.edit',       $extension . '.category.' . $item->id);
								$canCheckin = $user->authorise('core.admin',      'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
								$canEditOwn = $user->authorise('core.edit.own',   $extension . '.category.' . $item->id) && $item->created_user_id == $userId;
								$canChange  = $user->authorise('core.edit.state', $extension . '.category.' . $item->id) && $canCheckin;

								// Get the parents of item for sorting
								if ($item->level > 1)
								{
									$parentsStr = '';
									$_currentParentId = $item->parent_id;
									$parentsStr = ' ' . $_currentParentId;
									for ($i2 = 0; $i2 < $item->level; $i2++)
									{
										foreach ($this->ordering as $k => $v)
										{
											$v = implode('-', $v);
											$v = '-' . $v . '-';
											if (strpos($v, '-' . $_currentParentId . '-') !== false)
											{
												$parentsStr .= ' ' . $k;
												$_currentParentId = $k;
												break;
											}
										}
									}
								}
								else
								{
									$parentsStr = '';
								}
								?>
								<tr class="row<?php echo $i % 2; ?>" data-dragable-group="<?php echo $item->parent_id; ?>" item-id="<?php echo $item->id ?>" parents="<?php echo $parentsStr ?>" level="<?php echo $item->level ?>">
									<td class="text-center">
										<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
									</td>
									<td class="text-center d-none d-md-table-cell">
										<?php
										$iconClass = '';
										if (!$canChange)
										{
											$iconClass = ' inactive';
										}
										elseif (!$saveOrder)
										{
											$iconClass = ' inactive" title="' . Text::_('JORDERINGDISABLED');
										}
										?>
										<span class="sortable-handler icon-move-v<?php echo $iconClass ?>" area-hidden="true"></span>
										<?php if ($canChange && $saveOrder) : ?>
											<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->lft; ?>">
										<?php endif; ?>
									</td>
									<td class="text-center">
										<?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'categories.', $canChange); ?>
									</td>
									<th scope="row">
										<?php echo LayoutHelper::render('joomla.html.treeprefix', array('level' => $item->level)); ?>
										<?php if ($item->checked_out) : ?>
											<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'categories.', $canCheckin); ?>
										<?php endif; ?>
										<?php if ($canEdit || $canEditOwn) : ?>
											<a href="<?php echo Route::_('index.php?option=com_categories&task=category.edit&id=' . $item->id . '&extension=' . $extension); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>">
												<?php echo $this->escape($item->title); ?></a>
										<?php else : ?>
											<?php echo $this->escape($item->title); ?>
										<?php endif; ?>
									</th>
									<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_published')) : ?>
										<td class="d-none d-xl-table-cell">
											<a title="<?php echo Text::_('COM_CATEGORY_COUNT_PUBLISHED_ITEMS'); ?>" href="<?php echo Route::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[category_id]=' . (int) $item->id . '&filter[published]=1' . '&filter[level]=1'); ?>">
												<u><?php echo $item->count_published; ?></u></a>
										</td>
									<?php endif; ?>
									<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_unpublished')) : ?>
										<td class="d-none d-xl-table-cell">
											<a title="<?php echo Text::_('COM_CATEGORY_COUNT_UNPUBLISHED_ITEMS'); ?>" href="<?php echo Route::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[category_id]=' . (int) $item->id . '&filter[published]=0' . '&filter[level]=1'); ?>">
												<u><?php echo $item->count_unpublished; ?></u></a>
										</td>
									<?php endif; ?>
									<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_archived')) : ?>
										<td class="d-none d-xl-table-cell">
											<a title="<?php echo Text::_('COM_CATEGORY_COUNT_ARCHIVED_ITEMS'); ?>" href="<?php echo Route::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[category_id]=' . (int) $item->id . '&filter[published]=2' . '&filter[level]=1'); ?>">
												<u><?php echo $item->count_archived; ?></u></a>
										</td>
									<?php endif; ?>
									<?php if (isset($this->items[0]) && property_exists($this->items[0], 'count_trashed')) : ?>
										<td class="d-none d-xl-table-cell">
											<a title="<?php echo Text::_('COM_CATEGORY_COUNT_TRASHED_ITEMS'); ?>" href="<?php echo Route::_('index.php?option=' . $component . ($section ? '&view=' . $section : '') . '&filter[category_id]=' . (int) $item->id . '&filter[published]=-2' . '&filter[level]=1'); ?>">
												<u><?php echo $item->count_trashed; ?></u></a>
										</td>
									<?php endif; ?>

									<td class="d-none d-xl-table-cell">
										<?php echo $this->escape($item->access_level); ?>
									</td>
									<?php if ($this->assoc) : ?>
										<td class="d-none d-xl-table-cell">
											<?php if ($item->association) : ?>
												<?php echo HTMLHelper::_('categoriesadministrator.association', $item->id, $extension); ?>
											<?php endif; ?>
										</td>
									<?php endif; ?>
									<?php if (Multilanguage::isEnabled()) : ?>
										<td class="d-none d-xl-table-cell">
											<?php echo LayoutHelper::render('joomla.content.language', $item); ?>
										</td>
									<?php endif; ?>
									<td class="d-none d-xl-table-cell">
										<?php echo (int) $item->id; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<?php // Load the batch processing form. ?>
					<?php if ($user->authorise('core.create', $extension)
						&& $user->authorise('core.edit', $extension)
						&& $user->authorise('core.edit.state', $extension)) : ?>
						<joomla-modal role="dialog" id="collapseModal" title="<?php echo Text::_('COM_CATEGORIES_BATCH_OPTIONS'); ?>" width="80vw" height="100%">
							<section>
								<?php echo $this->loadTemplate('batch_body'); ?>
							</section>
							<footer>
								<?php echo $this->loadTemplate('batch_footer'); ?>
							</footer>
						</joomla-modal>
					<?php endif; ?>
					
					<!-- load the pagination. -->
					<div class="j-pagination-footer">
						<?php echo LayoutHelper::render('joomla.searchtools.default.listlimit', array('view' => $this)); ?>
						<?php echo $this->pagination->getListFooter(); ?>
					</div>
				<?php endif; ?>


				<input type="hidden" name="extension" value="<?php echo $extension; ?>">
				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
