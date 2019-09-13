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

$user      = Factory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo Route::_('index.php?option=com_templates&view=templates'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('selectorFieldName' => 'client_id'))); ?>
				<?php if ($this->total > 0) : ?>
					<div id="template-mgr">
						<div class="row">
							<?php foreach ($this->items as $i => $item) : ?>
								<div class="col-sm-3">
									<div class="admin-template">
										<div class="admin-template-header">
											<a href="<?php echo Route::_('index.php?option=com_templates&view=template&id=' . (int) $item->extension_id . '&file=' . $this->file); ?>">
												<?php echo Text::sprintf('COM_TEMPLATES_TEMPLATE_DETAILS', ucfirst($item->name)); ?>
											</a>
											
											<?php if ($version = $item->xmldata->get('version')) : ?>
												<div><?php echo $this->escape($version); ?></div>
											<?php endif; ?>

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
										<div class="admin-template-thumbnail">
											<?php echo HTMLHelper::_('templates.thumb', $item->element, $item->client_id); ?>
											<?php echo HTMLHelper::_('templates.thumbModal', $item->element, $item->client_id); ?>
										</div>

										<div class="admin-template-footer">
											<?php if ($this->pluginState) : ?>
											Override
												<td class="d-none d-md-table-cell text-center">
													<?php if (!empty($item->updated)) : ?>
														<span class="badge badge-warning"><?php echo Text::plural('COM_TEMPLATES_N_CONFLICT', $item->updated); ?></span>
													<?php else : ?>
														<span class="badge badge-success"><?php echo Text::_('COM_TEMPLATES_UPTODATE'); ?></span>
													<?php endif; ?>
												</td>
											<?php endif; ?>
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
