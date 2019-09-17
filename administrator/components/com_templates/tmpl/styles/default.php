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
HTMLHelper::_('webcomponent', 'system/joomla-dropdown.es6.min.js', array('version'=> 'auto', 'relative' => true));
HTMLHelper::_('webcomponent', 'system/joomla-callout.es6.min.js', array('version'=> 'auto', 'relative' => true));

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
								$canEdit   = $user->authorise('core.edit',       'com_templates');
								$canChange = $user->authorise('core.edit.state', 'com_templates');
							?>
								<div class="col-md-3">
									<div class="template-style j-card j-card-has-hover mb-4">
										<div class="j-card-media">
											<div class="template-thumbnail">
												<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
												<img src="<?php echo $item->thumbnail; ?>" alt="<?php echo $this->escape($item->title); ?>">
												<?php if ($clientId === 0) : ?>
													<div class="template-overlay">
														<a target="_blank" href="<?php echo Route::_( Uri::root() . 'index.php?tp=1&templateStyle=' . (int) $item->id); ?>" class="btn btn-primary btn-md">
															<i class="fas fa-eye"></i> &nbsp;Preview
														</a>
													</div>
												<?php endif; ?>
											</div>
										</div>
										<div class="j-card-item-group">
											<div class="j-card-item">
												<span class="fas fa-info-circle fa-fw mr-1" id="template-info-<?php echo $item->id; ?>"></span>
											</div>
											
											<div class="j-card-item">
												<span class="template-name">
													<?php if ($canEdit) : ?>
														<a href="<?php echo Route::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>">
															<?php echo ucfirst($this->escape($item->template)); ?>
														</a>
													<?php else : ?>
														<?php echo ucfirst($this->escape($item->template)); ?>
													<?php endif; ?>
												</span>
											</div>
											
											<?php if ($version = $item->xmldata->get('version')) : ?>
												<div class="j-card-item">
													<span class="template-version">v<?php echo $this->escape($version); ?></span>		
												</div>
											<?php endif; ?>
										</div>

										<span class="j-card-divider"></span>
										
										<div class="j-card-item-group">
											<div class="j-card-item">
												<div class="text-muted mb-1">
													Style
												</div>
												<?php echo $this->escape($item->title); ?>
											</div>
											<?php if ($author = $item->xmldata->get('author')) : ?>
												<div class="j-card-item">
													<div class="text-muted mb-1">
														Author
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

										<span class="j-card-divider"></span>

										<div class="j-card-item-group">
											<div class="j-card-item">
												<?php if ($canChange):?>
													<?php if ($item->home == '0') : ?>
														<a href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>','styles.setDefault')">
															<span class="fas fa-star fa-fw"></span> Set as Default
														</a>
													<?php else : ?>
														<a href="<?php echo Route::_('index.php?option=com_templates&task=styles.unsetDefault&cid[]=' . $item->id . '&' . Session::getFormToken() . '=1'); ?>">
															<span class="fas fa-star fa-fw"></span>
															<?php if ($item->image) : ?>
																<?php echo HTMLHelper::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => Text::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title)), true); ?>
															<?php endif; ?>
															<?php echo Text::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title); ?>
														</a>
													<?php endif; ?>
												<?php endif; ?>
											</div>
											<div class="j-card-item j-card-item-right">
												<a class="iconic-button" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.duplicate')">
															<span class="fas fa-clone fa-fw"></span>
														</a>
														<a class="iconic-button" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.delete')">
															<span class="fas fa-trash fa-fw"></span>
														</a>
											</div>
											<div class="j-card-item">
												content right
											</div>
										</div>
										<span class="j-card-divider"></span>
										<div class="j-card-btn-group">
											<a href="<?php echo Route::_('index.php?option=com_templates&view=template&id=' . (int) $item->e_id); ?>" class="btn btn-default">
												<i class="fas fa-code"></i> Edit Files
											</a>
											<?php if ($canEdit) : ?>
												<a href="<?php echo Route::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>" class="btn btn-primary">
													<i class="fas fa-cog"></i> Options
												</a>
											<?php endif; ?>
										</div>

										<div class="j-card-footer j-card-footer-lg">
											<div class="j-card-footer-item">
												<a href="#"> <i class="j-icon-lg fas fa-cloud-download-alt"></i> Details Information</a>
											</div>
										</div>
									</div>

									<div class="card template-style">
										<div class="list-group list-group-flush">
											<div class="list-group-item d-flex align-items-center">
												<!-- <?php if($item->home == '1') : ?>
													<span class="default-template mr-2">
														<span class="fas fa-star"></span>
													</span>
												<?php else : ?>
													<?php if ($item->image) : ?>
														<span class="default-template mr-2">
															<?php echo HTMLHelper::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => $item->language_title), true); ?>
														</span>
													<?php endif; ?>
												<?php endif; ?> -->
											</div>
										</div>
									</div>

								</div>

								<joomla-callout for="#template-info-<?php echo $item->id; ?>" action="hover" position="right">
									<div class="callout-title">Information</div>
									<div class="callout-content">
										<div class="admin-template-info">
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
