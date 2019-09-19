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
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

HTMLHelper::_('behavior.multiselect');

$user      = Factory::getUser();
$app       = Factory::getApplication();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$ordering  = ($listOrder == 'a.lft');
$saveOrder = ($listOrder == 'a.lft' && strtolower($listDirn) == 'asc');
$menuType  = (string) $app->getUserState('com_menus.items.menutype', '', 'string');


if ($saveOrder && $menuType && !empty($this->items))
{
	$saveOrderingUrl = 'index.php?option=com_menus&task=items.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
	HTMLHelper::_('draggablelist.draggable');
}

$assoc   = Associations::isEnabled() && $this->state->get('filter.client_id') == 0;

?>
<?php // Set up the filter bar. ?>
<form action="<?php echo Route::_('index.php?option=com_menus&view=items&menutype='); ?>" method="post" name="adminForm"
	  id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php  echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('selectorFieldName' => 'menutype'))); ?>
				<?php if (!empty($this->items)) : ?>
					<div class="container-fluid j-flex-table" id="itemList">
						<div id="captionTable" class="sr-only">
							<?php echo Text::_('COM_MENUS_ITEMS_TABLE_CAPTION'); ?>, <?php echo Text::_('JGLOBAL_SORTED_BY'); ?>
						</div>
						<div class="j-flex-table-row j-flex-table-header">
							<div class="j-flex-table-title-column">
								<div class="j-flex-table-title">
									<?php echo HTMLHelper::_('grid.checkall'); ?>
									<?php echo HTMLHelper::_('searchtools.sort', '', 'a.lft', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'fa fa-arrows-alt-v'); ?>
								</div>
								<div class="j-flex-table-title">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
								</div>
							</div>

							<div class="j-flex-table-content-column">
								<div class="j-flex-table-text">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</div>
								
								<div class="j-flex-table-text">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_MENUS_HEADING_MENU', 'menutype_title', $listDirn, $listOrder); ?>
								</div>
								
								<div class="j-flex-table-text">
									<?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
								</div>

								<?php if ($this->state->get('filter.client_id') == 0) : ?>
									<div class="j-flex-table-text">
										<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'a.access', $listDirn, $listOrder); ?>
									</div>
								<?php endif; ?>

								<?php if ($assoc) : ?>
									<div class="j-flex-table-text">
										<?php echo HTMLHelper::_('searchtools.sort', 'COM_MENUS_HEADING_ASSOCIATION', 'association', $listDirn, $listOrder); ?>
									</div>
								<?php endif; ?>

								<?php if (($this->state->get('filter.client_id') == 0) && (Multilanguage::isEnabled())) : ?>
									<div class="j-flex-table-text">
										<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
									</div>
								<?php endif; ?>

								<?php if ($this->state->get('filter.client_id') == 0) : ?>
									<div class="j-flex-table-text">
										<?php echo HTMLHelper::_('searchtools.sort', 'COM_MENUS_HEADING_HOME', 'a.home', $listDirn, $listOrder); ?>
									</div>
								<?php endif; ?>
							</div>
						</div><!-- / .j-flex-table-header -->
						<div class="js-draggable" <?php if ($saveOrder && $menuType) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php endif; ?>>
							<?php foreach($this->items as $i => $item) :
								$orderkey = array_search($item->id, $this->ordering[$item->parent_id]);
								$canCreate = $user->authorise('core.create', 'com_menus.menu.' . $item->menutype_id);
								$canEdit = $user->authorise('core.edit', 'com_menus.menu.' . $item->menutype_id);
								$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
								$canChange = $user->authorise('core.edit.state', 'com_menus.menu.' . $item->menutype_id) && $canCheckin;

								// Get the parents of item for sorting
								if ($item->level > 1)
								{
									$parentsStr       = '';
									$_currentParentId = $item->parent_id;
									$parentsStr       = ' ' . $_currentParentId;

									for ($j = 0; $j < $item->level; $j++)
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

							<div class="j-flex-table-row <?php echo ($item->level > 1 && $item->level < 10) ? 'j-flex-table-row-lavel-' . $item->level : ''; ?>" 
								<?php $item->level >= 10 ? 'style="margin-left: '. $item->level * 10 .'px"' : ''; ?>
								data-dragable-group="<?php echo $item->parent_id; ?> j-tr-level-<?php echo $item->level; ?>"
								item-id="<?php echo $item->id; ?>" parents="<?php echo $parentsStr; ?>"
								level="<?php echo $item->level; ?>">
								<div class="j-flex-table-title-column">
									<div class="j-flex-table-title">
										<span class="selectbox"><?php echo HTMLHelper::_('grid.id', $i, $item->id); ?></span>
										<?php if ($item->checked_out) : ?>
											<span class="checkout"><?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'items.', $canCheckin); ?></span>
										<?php endif; ?>

										<?php if ($menuType) : ?>
											<span class="order">
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
												<span class="sortable-handler<?php echo $iconClass ?>">
													<span class="fa fa-arrows-alt-v" aria-hidden="true"></span>
												</span>
												<?php if ($canChange && $saveOrder) : ?>
													<input type="text" style="display:none" name="order[]" size="5"
															value="<?php echo $orderkey + 1; ?>">
												<?php endif; ?>
											</span>
										<?php endif; ?>

										<?php if ($canEdit && !$item->protected) : ?>
											<a href="<?php echo Route::_('index.php?option=com_menus&task=item.edit&id=' . (int) $item->id); ?>"
												title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>">
												<?php echo $this->escape($item->title); ?></a>
										<?php else : ?>
											<?php echo $this->escape($item->title); ?>
										<?php endif; ?>
										<span class="small">
										<?php if ($item->type != 'url') : ?>
											<?php if (empty($item->note)) : ?>
												<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
											<?php else : ?>
												<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS_NOTE', $this->escape($item->alias), $this->escape($item->note)); ?>
											<?php endif; ?>
										<?php elseif ($item->type == 'url' && $item->note) : ?>
											<?php echo Text::sprintf('JGLOBAL_LIST_NOTE', $this->escape($item->note)); ?>
										<?php endif; ?>
										</span>
										<?php echo HTMLHelper::_('menus.visibility', $item->params); ?>
										<div title="<?php echo $this->escape($item->path); ?>">
											<span class="small"
													title="<?php echo isset($item->item_type_desc) ? htmlspecialchars($this->escape($item->item_type_desc), ENT_COMPAT, 'UTF-8') : ''; ?>">
												<?php echo $this->escape($item->item_type); ?></span>
										</div>
										<?php if ($item->type === 'component' && !$item->enabled) : ?>
											<div>
												<span class="badge badge-secondary">
													<?php echo Text::_($item->enabled === null ? 'JLIB_APPLICATION_ERROR_COMPONENT_NOT_FOUND' : 'COM_MENUS_LABEL_DISABLED'); ?>
												</span>
											</div>
										<?php endif; ?>
									</div>
								</div><!-- / .j-flex-table-title-column -->

								<div class="j-flex-table-content-column">
									<div class="j-flex-table-text d-none d-sm-block">
										<?php echo (int) $item->id; ?>
									</div>

									<div class="j-flex-table-text d-none d-sm-block">
										<?php echo $this->escape($item->menutype_title ?: ucwords($item->menutype)); ?>
									</div>

									<div class="j-flex-table-text d-none d-sm-block">
										<?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'items.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
									</div>

									<?php if ($this->state->get('filter.client_id') === 0) : ?>
										<div class="j-flex-table-text d-none d-sm-block">
											<?php echo $this->escape($item->access_level); ?>	
										</div>
									<?php endif; ?>

									<?php if ($this->state->get('filter.client_id') == 0 && Multilanguage::isEnabled()) : ?>
										<div class="j-flex-table-text d-none d-sm-block">
											<?php echo LayoutHelper::render('joomla.content.language', $item); ?>
										</div>
									<?php endif; ?>

									<?php if ($assoc) : ?>
										<div class="j-flex-table-text d-none d-sm-block">
											<?php if ($item->association) : ?>
												<?php echo HTMLHelper::_('menus.association', $item->id); ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									
									<?php if ($this->state->get('filter.client_id') == 0) : ?>
										<div class="j-flex-table-text d-none d-sm-block">
											<?php if ($item->type == 'component') : ?>
												<?php if ($item->language == '*' || $item->home == '0') : ?>
													<?php echo HTMLHelper::_('jgrid.isdefault', $item->home, $i, 'items.', ($item->language != '*' || !$item->home) && $canChange && !$item->protected); ?>
												<?php elseif ($canChange) : ?>
													<a href="<?php echo Route::_('index.php?option=com_menus&task=items.unsetDefault&cid[]=' . $item->id . '&' . Session::getFormToken() . '=1'); ?>">
														<?php if ($item->language_image) : ?>
															<?php echo HTMLHelper::_('image', 'mod_languages/' . $item->language_image . '.gif', $item->language_title, array('title' => Text::sprintf('COM_MENUS_GRID_UNSET_LANGUAGE', $item->language_title)), true); ?>
														<?php else : ?>
															<span class="badge badge-secondary"
																	title="<?php echo Text::sprintf('COM_MENUS_GRID_UNSET_LANGUAGE', $item->language_title); ?>"><?php echo $item->language_sef; ?></span>
														<?php endif; ?>
													</a>
												<?php else : ?>
													<?php if ($item->language_image) : ?>
														<?php echo HTMLHelper::_('image', 'mod_languages/' . $item->language_image . '.gif', $item->language_title, array('title' => $item->language_title), true); ?>
													<?php else : ?>
														<span class="badge badge-secondary"
																title="<?php echo $item->language_title; ?>"><?php echo $item->language_sef; ?></span>
													<?php endif; ?>
												<?php endif; ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div><!-- / .j-flex-table-body -->
							<?php endforeach; ?>
						</div>
					</div><!-- / .j-flex-table -->

					<?php // Load the batch processing form if user is allowed ?>
					<?php if ($user->authorise('core.create', 'com_menus') || $user->authorise('core.edit', 'com_menus')) : ?>
						<?php echo HTMLHelper::_(
							'bootstrap.renderModal',
							'collapseModal',
							array(
								'title'  => Text::_('COM_MENUS_BATCH_OPTIONS'),
							'footer' => $this->loadTemplate('batch_footer')
							),
							$this->loadTemplate('batch_body')
						); ?>
					<?php endif; ?>
				<?php endif; ?>
				
				<?php // load the pagination. ?>
				<div class="j-pagination-footer">
					<?php echo LayoutHelper::render('joomla.searchtools.default.listlimit', array('view' => $this)); ?>
					<?php echo $this->pagination->getListFooter(); ?>
				</div>

				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
