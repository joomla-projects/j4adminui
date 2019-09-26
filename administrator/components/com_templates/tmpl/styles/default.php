<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
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
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-callout.min.js', array('version'=> 'auto', 'relative' => true));

$user      = Factory::getUser();
$clientId = (int) $this->state->get('client_id', 0);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo Route::_('index.php?option=com_templates&view=styles'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('selectorFieldName' => 'client_id'))); ?>
				<div class="clearfix mt-4 mb-4"></div>
				<?php if ($this->total > 0) : ?>
					<div id="styleList">
						<div class="row">
							<?php foreach ($this->items as $i => $item) :
								$canCreate = $user->authorise('core.create',     'com_templates');
								$canDelete = $user->authorise('core.delete',     'com_templates');
								$canEdit   = $user->authorise('core.edit',       'com_templates');
								$canChange = $user->authorise('core.edit.state', 'com_templates');
							?>
								<div class="col-md-3">
									<div class="template-style<?php echo ($item->home == '1') ? ' active' : ''; ?> j-card j-card-has-hover mb-4">
										
										<div class="j-card-header">
											<h4 class="j-card-title">
												<span class="mr-1">
													<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
												</span>
												<span class="j-card-icon fas fa-info-circle" id="template-info-<?php echo $item->id; ?>"></span>
												<span class="template-name">
													<?php if ($canEdit) : ?>
														<a href="<?php echo Route::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>">
															<?php echo ucfirst($this->escape($item->template)); ?>
														</a>
													<?php else : ?>
														<?php echo ucfirst($this->escape($item->template)); ?>
													<?php endif; ?>
												</span>
												<?php if ($version = $item->xmldata->get('version')) : ?>
													<span class="template-version small text-muted">v<?php echo $this->escape($version); ?></span>
												<?php endif; ?>
											</h4>
											<?php if ($canCreate || $canDelete): ?>
											<div class="j-card-header-right">
												<div class="joomla-dropdown-container">
													<a href="javascript:void(0);" id="template-style-actions-<?php echo $item->id; ?>"><span class="j-card-header-icon fas fa-ellipsis-h" area-hidden="true"></span></a>
													<joomla-dropdown for="#template-style-actions-<?php echo $item->id; ?>">
														<?php if($canCreate) : ?>
														<a class="dropdown-item" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.duplicate')">
															<span class="fas fa-clone fa-fw" aria-hidden="true"></span> <?php echo Text::_('COM_TEMPLATES_STYLE_DUPLICATE'); ?>
														</a>
														<?php endif; ?>

														<?php if($canDelete) : ?>
														<a class="dropdown-item" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.delete')">
															<span class="fas fa-trash fa-fw" aria-hidden="true"></span> <?php echo Text::_('COM_TEMPLATES_STYLE_DELETE'); ?>
														</a>
														<?php endif; ?>
													</joomla-dropdown>
												</div>
											</div>
											<?php endif; ?>
										</div>

										<div class="j-card-media">
											<div class="template-thumbnail">
												<img src="<?php echo $item->thumbnail; ?>" alt="<?php echo $this->escape($item->title); ?>">
												<?php if ($clientId === 0) : ?>
													<div class="j-card-media-overlay align-items-center justify-content-center">
														<a href="<?php echo Route::_( Uri::root() . 'index.php?tp=1&templateStyle=' . (int) $item->id); ?>" target="_blank" class="btn btn-default">
															<i class="fas fa-eye"></i> &nbsp;Preview
														</a>
													</div>
												<?php endif; ?>
											</div>
										</div>

										<div class="list-group list-group-flush">
											<div class="list-group-item">
												<div class="row">
													<div class="col">
														<div class="text-muted mb-1">
															<?php echo Text::_('COM_TEMPLATES_STYLE'); ?>
														</div>
														<?php echo $this->escape($item->title); ?>
													</div>

													<?php if ($author = $item->xmldata->get('author')) : ?>
														<div class="col">
															<div class="text-muted mb-1">
																<?php echo Text::_('COM_TEMPLATES_AUTHOR'); ?>
															</div>
															<?php if ($url = $item->xmldata->get('authorUrl')) : ?>
																<a target="_blank" href="<?php echo $this->escape($url); ?>">
																	<?php echo $this->escape($author); ?>
																</a>
															<?php else: ?>
																<?php echo $this->escape($author); ?>
															<?php endif; ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
											
											<div class="list-group-item">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1">
														<?php if ( $item->home != '0' && $item->image) : ?>
															<span class="fas fa-language fa-fw mr-2" area-hidden="true" aria-label="<?php echo Text::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title); ?>" title="<?php echo Text::sprintf('COM_TEMPLATES_STYLE_SET_GRID_DEFAULT', $item->language_title); ?>"></span>
														<?php endif; ?>
														<?php echo Text::_('COM_TEMPLATES_STYLE_SET_DEFAULT'); ?>
													</div>

													<div>
														<?php if ($item->home == '0') : ?>
															<a href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>','styles.setDefault')" class="template-toggle-style">
																<span class="switcher-wrap">
																	<span class="switcher-alt" area-hidden="true"></span> <span><?php echo Text::_('JNO'); ?></span>
																</span>
															</a>
														<?php else : ?>
															<a href="<?php echo Route::_('index.php?option=com_templates&task=styles.unsetDefault&cid[]=' . $item->id . '&' . Session::getFormToken() . '=1'); ?>" class="template-toggle-style">
																<span class="switcher-wrap">
																	<span class="switcher-alt checked" area-hidden="true"></span> <span><?php echo Text::_('JYES'); ?></span>
																</span>
															</a>
														<?php endif; ?>
													</div>
												</div>
											</div>

											<?php if ($canEdit) : ?>
												<div class="list-group-item py-4">
													<div class="j-card-btn-group">
														<a href="<?php echo Route::_('index.php?option=com_templates&view=template&id=' . (int) $item->e_id); ?>" class="btn btn-default">
															<i class="fas fa-code"></i> Edit Files
														</a>
														<a href="<?php echo Route::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>" class="btn btn-primary">
															<i class="fas fa-cog"></i> Options
														</a>
													</div>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- Style Information Callout -->
								<joomla-callout for="#template-info-<?php echo $item->id; ?>" action="hover" position="bottom">
									<div class="callout-title">Information</div>
									<div class="callout-content p-0">
										<div class="template-info">
											<ul class="list-group list-group-flush">
												<li class="list-group-item">
													<span class="text-muted">Created: </span> <?php echo $this->escape($item->xmldata->get('creationDate')); ?>
												</li>
												
												<?php if ($author = $item->xmldata->get('author')) : ?>
													<li class="list-group-item">
													<span class="text-muted">Author: </span><?php echo $this->escape($author); ?>
													</li>
												<?php endif; ?>
												
												<?php if ($email = $item->xmldata->get('authorEmail')) : ?>
													<li class="list-group-item">
														<span class="text-muted">Author Email: </span> <?php echo $this->escape($email); ?>
													</li>
												<?php endif; ?>

												<?php if ($url = $item->xmldata->get('authorUrl')) : ?>
													<li class="list-group-item">
														<span class="text-muted">Author Website: </span> <a href="<?php echo $this->escape($url); ?>"><?php echo $this->escape($url); ?></a>
													</li>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								</joomla-callout>
							<?php endforeach; ?>
						</div>
					</div>

					<?php // load the pagination. ?>
					<?php echo $this->pagination->getListFooter(); ?>

				<?php endif; ?>

				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
