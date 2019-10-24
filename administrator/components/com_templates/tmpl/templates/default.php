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
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('webcomponent', 'system/joomla-callout.min.js', array('version'=> 'auto', 'relative' => true));

$user      = Factory::getUser();
$clientId = (int) $this->state->get('client_id', 0);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo Route::_('index.php?option=com_templates&view=templates'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('selectorFieldName' => 'client_id'))); ?>
				<?php if ($this->total > 0) : ?>
					<div id="template-mgr" class="mt-4">
						<div class="row">
							<?php foreach ($this->items as $i => $item) : ?>
								<div class="col-sm-6 col-lg-4 col-xl-3">
									<div class="admin-template j-card j-card-has-hover mb-4">
										<div class="j-card-header">
											<h4 class="j-card-title">
												<span class="template-name">
													<a href="<?php echo Route::_('index.php?option=com_templates&view=template&id=' . (int) $item->extension_id . '&file=' . $this->file); ?>">
														<?php echo ucfirst($item->name); ?>
													</a>
												</span>
												<?php if ($version = $item->xmldata->get('version')) : ?>
													<span class="template-version small text-muted">v<?php echo $this->escape($version); ?></span>
												<?php endif; ?>
												<span id="template-info-<?php echo $item->extension_id; ?>" class="j-card-icon icon-info-circle ml-1" area-hidden="true"></span>
											</h4>
										</div>

										<div class="j-card-media">
											<div class="template-thumbnail">
												<img src="<?php echo $item->thumbnail; ?>" alt="<?php echo $this->escape($item->title); ?>">
											</div>
										</div>
									</div>

									<!-- Template Information -->
									<joomla-callout for="#template-info-<?php echo $item->extension_id; ?>" action="hover" position="bottom">
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

													<?php if ($url = $item->xmldata->get('authorUrl')) : ?>
														<li class="list-group-item px-0">
															<span class="text-muted"><?php echo Text::_('COM_TEMPLATES_AUTHOR_WEBSITE'); ?>: </span> <a href="<?php echo $this->escape($url); ?>"><?php echo $this->escape($url); ?></a>
														</li>
													<?php endif; ?>

													<?php if ($this->pluginState) : ?>
														<li class="list-group-item px-0">
															<span class="text-muted">Override: </span>
															<?php if (!empty($item->updated)) : ?>
																<span class="badge badge-warning"><?php echo Text::plural('COM_TEMPLATES_N_CONFLICT', $item->updated); ?></span>
															<?php else : ?>
																<span class="badge badge-success"><?php echo Text::_('COM_TEMPLATES_UPTODATE'); ?></span>
															<?php endif; ?>
														</li>
													<?php endif; ?>
												</ul>
											</div>
										</div>
									</joomla-callout>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

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
