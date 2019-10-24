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
				<div class="clearfix mt-5 mb-4"></div>
				<?php if ($this->total > 0) : ?>
					<div id="styleList">
						<div class="row">
							<?php foreach ($this->items as $i => $item) :
								$canCreate = $user->authorise('core.create',     'com_templates');
								$canDelete = $user->authorise('core.delete',     'com_templates');
								$canEdit   = $user->authorise('core.edit',       'com_templates');
								$canChange = $user->authorise('core.edit.state', 'com_templates');
							?>
								<div class="col-lg-6 col-xl-4">
									<div class="template-style<?php echo ($item->home == '1') ? ' active' : ''; ?> j-card j-card-has-hover mb-4">
										<div class="j-card-header">
											<h4 class="j-card-title d-flex align-items-center">
												<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
												<span class="template-name ml-3">
													<?php if ($canEdit) : ?>
														<a href="<?php echo Route::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>">
															<?php echo ucfirst($this->escape($item->template)); ?>
														</a>
													<?php else : ?>
														<?php echo ucfirst($this->escape($item->template)); ?>
													<?php endif; ?>
												</span>
												<?php if ($version = $item->xmldata->get('version')) : ?>
													<span class="template-version small text-muted ml-2">v<?php echo $this->escape($version); ?></span>
												<?php endif; ?>
												<?php if (($item->home != '0' && $item->home != '1') &&  $item->image):?>
													<span class="ml-2">
														<?php echo HTMLHelper::_('image', 'mod_languages/' . $item->image . '.gif', $item->language_title, array('title' => Text::sprintf('COM_TEMPLATES_STYLES_PAGES_ALL_LANGUAGE', $this->escape($item->language_title))), true); ?>
													</span>
												<?php elseif ($item->assigned > 0) : ?>
													<span class="ml-2">
														<span class="icon-batch duotone" area-hidden="true" title="<?php echo Text::sprintf('COM_TEMPLATES_STYLES_PAGES_SELECTED', $this->escape($item->assigned)); ?>"></span>
													</span>
												<?php endif; ?>	
											</h4>
											<?php if ($canCreate || $canDelete): ?>
											<div class="j-card-header-right">
												<span id="template-info-<?php echo $item->id; ?>" class="j-card-header-icon icon-info-circle icon-md mr-n2" area-hidden="true" role="link"></span>
												<?php if ($clientId === 0) : ?>
												<a href="<?php echo Route::_( Uri::root() . 'index.php?tp=1&templateStyle=' . (int) $item->id); ?>" target="_blank" class="j-card-header-icon" title="<?php echo Text::_('COM_TEMPLATES_PREVIEW'); ?>">
													<span class="icon-eye-open icon-md" area-hidden="true"></span>
												</a>
												<?php endif; ?>
											</div>
											<?php endif; ?>
										</div>

										<div class="j-card-media">
											<div class="template-thumbnail">
												<img src="<?php echo $item->thumbnail; ?>" alt="<?php echo $this->escape($item->title); ?>">
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
												<div class="d-flex">
													<?php if($canCreate  || $canDelete) : ?>
													<div class="mr-auto">
														<?php if($canCreate) : ?>
														<a class="btn btn-link" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.duplicate')">
															<span class="icon-copy" aria-hidden="true" title="<?php echo Text::_('COM_TEMPLATES_STYLE_DUPLICATE'); ?>"></span>
														</a>
														<?php endif; ?>

														<?php if($canDelete) : ?>
														<a class="btn btn-link" href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>', 'styles.delete')">
															<span class="icon-trash" aria-hidden="true" title="<?php echo Text::_('COM_TEMPLATES_STYLE_DELETE'); ?>"></span>
														</a>
														<?php endif; ?>
													</div>
													<?php endif; ?>

													<div>
														<a href="<?php echo Route::_('index.php?option=com_templates&view=template&id=' . (int) $item->e_id); ?>" class="btn btn-link">
															<?php echo Text::_('COM_TEMPLATES_TEMPLATE_EDIT_FILES'); ?>
														</a>
														<a href="<?php echo Route::_('index.php?option=com_templates&task=style.edit&id=' . (int) $item->id); ?>" title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->title)); ?>" class="btn btn-link ml-3">
															<span class="icon-options-cog" area-hidden="true"></span> <?php echo Text::_('COM_TEMPLATES_STYLE_OPTIONS'); ?>
														</a>
													</div>
												</div>
											</div>
											
											<div class="j-card-footer d-flex align-items-center p-4">
												<?php if ($item->home == '0') : ?>
													<a href="javascript:void(0);" onclick="return Joomla.listItemTask('cb<?php echo $i; ?>','styles.setDefault')" class="btn btn-secondary btn-block">
														<span class="icon-star" area-hidden="true"></span> <?php echo Text::_('COM_TEMPLATES_STYLE_SET_DEFAULT'); ?>
													</a>
												<?php elseif ($item->home == '1'):?>
													<strong class="text-success btn btn-transparent">
														<span class="icon-check-circle icon-md mr-2" area-hidden="true"></span> <?php echo Text::_('COM_TEMPLATES_STYLE_IS_DEFAULT'); ?>
													</strong>
												<?php elseif ($canChange):?>
													<a href="<?php echo Route::_('index.php?option=com_templates&task=styles.unsetDefault&cid[]=' . $item->id . '&' . Session::getFormToken() . '=1'); ?>" class="btn btn-secondary btn-block">
														<?php echo Text::sprintf('COM_TEMPLATES_GRID_UNSET_LANGUAGE', $item->language_title); ?>
													</a>
												<?php else : ?>
													<span class="btn btn-transparent">
														<?php echo Text::sprintf('COM_TEMPLATES_STYLES_PAGES_ALL_LANGUAGE', $this->escape($item->language_title)); ?>
													</span>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>

								<!-- Style Information -->
								<joomla-callout for="#template-info-<?php echo $item->id; ?>" action="hover" position="bottom">
									<div class="callout-title"><?php echo Text::_('COM_TEMPLATES_STYLE_INFO'); ?></div>
									<div class="callout-content">
										<div class="template-info">
											<ul class="list-group list-group-flush">
												<li class="list-group-item px-0">
													<span class="text-muted"><?php echo Text::_('COM_TEMPLATES_CREATED'); ?>: </span> <?php echo $this->escape($item->xmldata->get('creationDate')); ?>
												</li>
												
												<?php if ($author = $item->xmldata->get('author')) : ?>
													<li class="list-group-item px-0">
													<span class="text-muted"><?php echo Text::_('COM_TEMPLATES_AUTHOR'); ?>: </span><?php echo $this->escape($author); ?>
													</li>
												<?php endif; ?>
												
												<?php if ($email = $item->xmldata->get('authorEmail')) : ?>
													<li class="list-group-item px-0">
														<span class="text-muted"><?php echo Text::_('COM_TEMPLATES_AUTHOR_EMAIL'); ?>: </span> <?php echo $this->escape($email); ?>
													</li>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								</joomla-callout>
							<?php endforeach; ?>
						</div>
					</div>
	
					<!-- load the pagination. -->
					<div class="j-pagination-footer mt-4">
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

<!-- Load template install modal  -->
<?php 
echo HTMLHelper::_(
	'webcomponent.renderModal',
	'ModalInstallTemplate',
	array(
		'title'       => Text::_('PLG_INSTALLER_PACKAGEINSTALLER_UPLOAD_INSTALL_JOOMLA_EXTENSION'),
		'height'      => '75vh',
		'width'       => '85vw',
		'bodyHeight'  => 70,
		'modalWidth'  => 80,
		'footer'      => '<button type="button" class="btn btn-secondary" data-dismiss="modal">'
							. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>',
	),
	$this->loadTemplate('modal_install')
);
?>