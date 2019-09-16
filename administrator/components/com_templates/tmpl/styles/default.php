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
									<div class="card template-style">
										<div class="card-header d-flex align-items-center">
											<div class="flex-grow-1">
												<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
												<?php if($item->home == '1') : ?>
													<span class="default-template">
														<span class="fas fa-star"></span>
													</span>
												<?php else : ?>
													<?php if ($item->image) : ?>
														<?php echo HTMLHelper::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => $item->language_title), true); ?>
													<?php endif; ?>
												<?php endif; ?>
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
													<span class="template-version">v<?php echo $this->escape($version); ?></span>
												<?php endif; ?>
											</div>
											<div class="flex-shrink-1">
												<div class="mdc-card__action-icons m-n2">
													<button id="showCollout<?php echo $item->id; ?>" class="mdc-icon-button">
														<i class="fas fa-info-circle"></i>
													</button>

													<joomla-callout for="#showCollout<?php echo $item->id; ?>" dismiss="true" position="bottom">
														<div class="callout-title">Title</div>
														<div class="callout-content">
															<div class="admin-template-info">
																<?php echo $this->escape($item->xmldata->get('creationDate')); ?>
																<?php if ($author = $item->xmldata->get('author')) : ?>
																	<div><?php echo $this->escape($author); ?></div>
																<?php else : ?>
																	&mdash;
																<?php endif; ?>
																<?php if ($email = $item->xmldata->get('authorEmail')) : ?>
																	<div><?php echo $this->escape($email); ?></div>
																<?php endif; ?>
																<?php if ($url = $item->xmldata->get('authorUrl')) : ?>
																	<div><a href="<?php echo $this->escape($url); ?>"><?php echo $this->escape($url); ?></a></div>
																<?php endif; ?>
															</div>
														</div>
														<a href="#" class="callout-link" target="blank">Learn more</a>
													</joomla-callout>

													<div class="joomla-dropdown-container">
														<button id="dropdownList<?php echo $item->id; ?>" class="mdc-icon-button">
															<span class="fas fa-ellipsis-h"></span>
														</button>
														<joomla-dropdown for="#dropdownList<?php echo $item->id; ?>">
															<?php if ($canChange):?>
																<?php if ($item->home == '0') : ?>
																	<a class="dropdown-item" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>','styles.setDefault')">
																		<span class="fas fa-star fa-fw"></span> Set as Default
																	</a>
																<?php else : ?>
																	<a href="<?php echo Route::_('index.php?option=com_templates&task=styles.unsetDefault&cid[]=' . $item->id . '&' . Session::getFormToken() . '=1'); ?>" class="dropdown-item">
																		<span class="fas fa-star fa-fw"></span>
																		<?php if ($item->image) : ?>
																			<?php echo HTMLHelper::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => Text::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title)), true); ?>
																		<?php endif; ?>
																		<?php echo Text::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title); ?>
																	</a>
																<?php endif; ?>
															<?php endif; ?>

															<a class="dropdown-item" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.duplicate')">
																<span class="fas fa-clone fa-fw"></span> Duplicate Style
															</a>
															<a class="dropdown-item" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.delete')">
																<span class="fas fa-trash fa-fw"></span> Delete Style
															</a>
														</joomla-dropdown>
													</div>
												</div>
											</div>
										</div>

										<div class="template-thumbnail">
											<img src="<?php echo $item->thumbnail; ?>" alt="<?php echo $this->escape($item->title); ?>">
											<?php if ($clientId === 0) : ?>
												<div class="template-overlay">
													<a target="_blank" href="<?php echo Route::_( Uri::root() . 'index.php?tp=1&templateStyle=' . (int) $item->id); ?>" class="btn btn-primary btn-md">
														<i class="fas fa-eye"></i> &nbsp;Preview
													</a>
												</div>
											<?php endif; ?>
										</div>

										<ul class="list-group list-group-flush">
											<li class="list-group-item"><span>Style:</span> <?php echo $this->escape($item->title); ?></li>
											<?php if ($author = $item->xmldata->get('author')) : ?>
												<li class="list-group-item">
													<?php if ($url = $item->xmldata->get('authorUrl')) : ?>
														<div>
															<span>
																Author:
															</span>
															<a target="_blank" rel="nofollow" href="<?php echo $this->escape($url); ?>">
																<?php echo $this->escape($author); ?>
															</a>
														</div>
													<?php else: ?>
														<span>
															Author:
														</span>
														<?php echo $this->escape($author); ?>
													<?php endif; ?>
												</li>
											<?php endif; ?>
										</ul>
										<div class="card-footer d-flex">
											<div class="col text-center">
												<a href="<?php echo Route::_('index.php?option=com_templates&view=template&id=' . (int) $item->e_id); ?>" class="card-link">
													<i class="fas fa-code"></i> Edit Files
												</a>
											</div>
											<div class="col text-center">
												<?php if ($canEdit) : ?>
													<a href="<?php echo Route::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>" class="card-link">
														<i class="fas fa-cog"></i> Options
													</a>
												<?php endif; ?>
											</div>
										</div>
									</div>

								</div>
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
