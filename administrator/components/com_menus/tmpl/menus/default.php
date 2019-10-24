<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_menus
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.multiselect');

$uri       = Uri::getInstance();
$return    = base64_encode($uri);
$user      = Factory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$modMenuId = (int) $this->get('ModMenuId');
$itemIds   = [];

foreach ($this->items as $item)
{
	if ($user->authorise('core.edit', 'com_menus'))
	{
		$itemIds[] = $item->id;
	}
}

$this->document->addScriptOptions('menus-default', ['items' => $itemIds]);
HTMLHelper::_('jquery.framework');
HTMLHelper::_('script', 'com_menus/admin-menus-default.min.js', ['version' => 'auto', 'relative' => true], ['defer' => 'defer']);
HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version' => 'auto', 'relative' => true));
?>
<form action="<?php echo Route::_('index.php?option=com_menus&view=menus'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('filterButton' => false))); ?>
				<?php if (empty($this->items)) : ?>
					<div class="j-alert j-alert-info d-flex mt-4">
						<div class="j-alert-icon-wrap"><span class="icon-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span></div>
						<div class="j-alert-info-wrap"><?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?></div>
					</div>
				<?php else : ?>
					<table class="table j-list-table" id="menuList">
						<caption id="captionTable" class="sr-only">
							<?php echo Text::_('COM_MENUS_MENUS_TABLE_CAPTION'); ?>, <?php echo Text::_('JGLOBAL_SORTED_BY'); ?>
						</caption>
						<thead>
							<tr>
								<td class="text-center" style="width: 3rem;">
									<?php echo HTMLHelper::_('grid.checkall'); ?>
								</td>
								<th scope="col" class="text-center" style="width: 3rem;">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</th>
								<th scope="col">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
								</th>
								<th scope="col" class="d-none d-xl-table-cell" style="width:10%;">
									<span class="icon-publish text-primary" aria-hidden="true"></span>
									<?php echo Text::_('COM_MENUS_HEADING_PUBLISHED_ITEMS'); ?>
								</th>
								<th scope="col" class="d-none d-xl-table-cell" style="width:10%;">
									<span class="icon-unpublish text-warning" aria-hidden="true"></span>
									<?php echo Text::_('COM_MENUS_HEADING_UNPUBLISHED_ITEMS'); ?>
								</th>
								<th scope="col" class="d-none d-xl-table-cell" style="width:10%;">
									<span class="icon-trash text-danger" aria-hidden="true"></span>
									<?php echo Text::_('COM_MENUS_HEADING_TRASHED_ITEMS'); ?>
								</th>
								<th scope="col" class="d-none d-md-table-cell" style="width:10%;">
									<span class="icon-modules" aria-hidden="true"></span>
									<?php echo Text::_('COM_MENUS_HEADING_LINKED_MODULES'); ?>
								</th>
								<th scope="col" class="text-center" style="width:3rem;">
									<?php echo Text::_('COM_MENUS_MENUS'); ?>
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($this->items as $i => $item) :
							$canEdit        = $user->authorise('core.edit',   'com_menus.menu.' . (int) $item->id);
							$canManageItems = $user->authorise('core.manage', 'com_menus.menu.' . (int) $item->id);
						?>
							<tr class="row<?php echo $i % 2; ?>">
								<td class="text-center">
									<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
								</td>
								<td class="text-center">
									<?php echo $item->id; ?>
								</td>
								<td>
									<div class="name break-word">
										<?php if ($canEdit) : ?>
											<a href="<?php echo Route::_('index.php?option=com_menus&task=menu.edit&id=' . $item->id); ?>">
												<span class="sr-only"><?php echo Text::_('COM_MENUS_EDIT_MENU'); ?></span><?php echo $this->escape($item->title); ?>
											</a>
										<?php else : ?>
											<?php echo $this->escape($item->title); ?>
										<?php endif; ?>
										<?php if (!empty($item->description)) : ?>
											<small class="small d-none d-md-inline">
												(<?php echo $this->escape($item->description); ?>)
											</small>
										<?php endif; ?>
									</div>
								</td>								
								<td class="d-none d-xl-table-cell">
									<?php if ($canManageItems) : ?>
										<a href="<?php echo Route::_('index.php?option=com_menus&view=items&menutype=' . $item->menutype . '&filter[published]=1'); ?>">
											<u><?php echo $item->count_published; ?></u></a>
									<?php else : ?>
										<span class="">
											<?php echo $item->count_published; ?></span>
									<?php endif; ?>
								</td>
								<td class="d-none d-xl-table-cell">
									<?php if ($canManageItems) : ?>
										<a href="<?php echo Route::_('index.php?option=com_menus&view=items&menutype=' . $item->menutype . '&filter[published]=0'); ?>">
											<u><?php echo $item->count_unpublished; ?></u></a>
									<?php else : ?>
										<span class="">
											<?php echo $item->count_unpublished; ?></span>
									<?php endif; ?>
								</td>
								<td class="d-none d-xl-table-cell">
									<?php if ($canManageItems) : ?>
										<a class="" href="<?php echo Route::_('index.php?option=com_menus&view=items&menutype=' . $item->menutype . '&filter[published]=-2'); ?>">
											<u><?php echo $item->count_trashed; ?></u></a>
									<?php else : ?>
										<span class="">
											<?php echo $item->count_trashed; ?></span>
									<?php endif; ?>
								</td>
								<td class="d-none d-md-table-cell">
									<?php if (isset($this->modules[$item->menutype])) : ?>
										<div class="joomla-dropdown-container">
											<a href="javascript:;" class="btn btn-secondary btn-sm j-has-dropdown" data-target="menuTypeModule<?php echo $item->id; ?>">
												<?php echo Text::_('COM_MENUS_MODULES'); ?>
												<span class="icon-arrow-down-4" area-hidden="true"></span>
											</a>
											<joomla-dropdown for="menuTypeModule<?php echo $item->id; ?>">
												<?php foreach ($this->modules[$item->menutype] as &$module) : ?>
													<?php if ($user->authorise('core.edit', 'com_modules.module.' . (int) $module->id)) : ?>
														<?php $link = Route::_('index.php?option=com_modules&task=module.edit&id=' . $module->id . '&return=' . $return . '&tmpl=component&layout=modal'); ?>
														<li>
															<a href="javascript:;" class="dropdown-item" data-href="#moduleEdit<?php echo $module->id; ?>Modal" data-toggle="modal" title="<?php echo Text::_('COM_MENUS_EDIT_MODULE_SETTINGS'); ?>">
																<?php echo Text::sprintf('COM_MENUS_MODULE_ACCESS_POSITION', $this->escape($module->title), $this->escape($module->access_title), $this->escape($module->position)); ?>
															</a>
														</li>
													<?php else : ?>
														<li><span class="dropdown-item"><?php echo Text::sprintf('COM_MENUS_MODULE_ACCESS_POSITION', $this->escape($module->title), $this->escape($module->access_title), $this->escape($module->position)); ?></span></li>
													<?php endif; ?>
												<?php endforeach; ?>
											</joomla-dropdown>
										</div>
										<?php foreach ($this->modules[$item->menutype] as &$module) : ?>
											<?php if ($user->authorise('core.edit', 'com_modules.module.' . (int) $module->id)) : ?>
												<?php $link = Route::_('index.php?option=com_modules&task=module.edit&id=' . $module->id . '&return=' . $return . '&tmpl=component&layout=modal'); ?>
												<?php echo HTMLHelper::_(
														'webcomponent.renderModal',
														'moduleEdit' . $module->id . 'Modal',
														array(
															'title'       => Text::_('COM_MENUS_EDIT_MODULE_SETTINGS'),
															'backdrop'    => 'static',
															'keyboard'    => false,
															'closeButton' => false,
															'url'         => $link,
															'height'      => '75vh',
															'width'       => '85vw',
															'bodyHeight'  => 70,
															'modalWidth'  => 80,
															'footer'      => '<button type="button" class="btn btn-danger" data-dismiss="modal"'
																	. ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleEdit' . $module->id . 'Modal\', buttonSelector: \'#closeBtn\'})">'
																	. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
																	. '<button type="button" class="btn btn-success"'
																	. ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleEdit' . $module->id . 'Modal\', buttonSelector: \'#saveBtn\'})">'
																	. Text::_('JSAVE') . '</button>'
																	. '<button type="button" class="btn btn-success"'
																	. ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleEdit' . $module->id . 'Modal\', buttonSelector: \'#applyBtn\'})">'
																	. Text::_('JAPPLY') . '</button>',
														)
													); ?>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php elseif ($modMenuId) : ?>
										<?php $link = Route::_('index.php?option=com_modules&task=module.add&eid=' . $modMenuId . '&params[menutype]=' . $item->menutype . '&tmpl=component&layout=modal'); ?>
										<button type="button" class="btn btn-primary" data-toggle="modal" data-href="#moduleAddModal"><?php echo Text::_('COM_MENUS_ADD_MENU_MODULE'); ?></button>
										<?php echo HTMLHelper::_(
												'webcomponent.renderModal',
												'moduleAddModal',
												array(
													'title'       => Text::_('COM_MENUS_ADD_MENU_MODULE'),
													'backdrop'    => 'static',
													'keyboard'    => false,
													'closeButton' => false,
													'url'         => $link,
													'height'      => '75vh',
													'width'       => '85vw',
													'bodyHeight'  => 70,
													'modalWidth'  => 80,
													'footer'      => '<button type="button" class="btn btn-secondary" data-dismiss="modal"'
															. ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleAddModal\', buttonSelector: \'#closeBtn\'})">'
															. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
															. '<button type="button" class="btn btn-primary"'
															. ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleAddModal\', buttonSelector: \'#saveBtn\'})">'
															. Text::_('JSAVE') . '</button>'
															. '<button type="button" class="btn btn-success"'
															. ' onclick="Joomla.iframeButtonClick({iframeSelector: \'#moduleAddModal\', buttonSelector: \'#applyBtn\'})">'
															. Text::_('JAPPLY') . '</button>',
												)
											); ?>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<?php if ($canManageItems) : ?>
										<a href="<?php echo Route::_('index.php?option=com_menus&view=items&menutype=' . $item->menutype); ?>">
											<span class="duotone icon-eye-open icon-lg" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('COM_MENUS_MENUS'); ?></span>
										</a>
									<?php endif; ?>
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
				<?php endif; ?>
				

				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
