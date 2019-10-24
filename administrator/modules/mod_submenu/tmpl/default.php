<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_submenu
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('script', 'com_cpanel/admin-system-loader.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version'=> 'auto', 'relative' => true));

$bootstrapSize 		= (int) $params->get('bootstrap_size', 6);
$columns 			= (int) ($bootstrapSize ? $bootstrapSize : 3) / 3;
$columnSize 		= 12 / $columns;
$columnsSmall 		= (int) ($bootstrapSize ? $bootstrapSize : 4) / 4;
$columnSizeSmall 	= 12 / $columnsSmall;
$app 				= Factory::getApplication();
$user 				= $app->getIdentity();

$id 				= $module->id;

$canEdit 			= $user->authorise('core.edit', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');
$canChange 			= $user->authorise('core.edit.state', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');

/** @var  \Joomla\CMS\Menu\MenuItem  $root */
?>
	<?php if (Factory::getUser()->authorise('core.edit', 'com_modules')) : ?>
	<?php endif; ?>
	<?php foreach ($root->getChildren() as $key => $child) : ?>
		<?php if ($child->hasChildren()) : ?>
			<div class="j-card mb-4">
				<div class="j-card-header">
					<h3 class="j-card-title">
						<?php if ($child->icon) : ?>
							<span class="j-card-icon icon-<?php echo $child->icon; ?>" aria-hidden="true"></span>
						<?php endif; ?>
						<?php echo Text::_($child->title); ?>
					</h3>

					<div class="j-card-header-right">
						<?php if ($canEdit || $canChange) : ?>
							<?php $dropdownPosition = Factory::getLanguage()->isRTL() ? 'left' : 'right'; ?>
							<div class="joomla-dropdown-container">
								<a href="javascript:;" class="j-card-header-icon" data-target="dropdownMenuButton-<?php echo $id . '-' . $key; ?>">
									<span class="icon-ellipsis-h" aria-hidden="true"></span>
									<span class="sr-only"><?php echo Text::_('JACTION_EDIT') . ' ' . $module->title; ?></span>
								</a>
								<joomla-dropdown for="dropdownMenuButton-<?php echo $id . '-' . $key; ?>">
									<?php if ($canEdit) : ?>
										<?php $uri = Uri::getInstance(); ?>
										<?php $url = Route::_('index.php?option=com_modules&task=module.edit&id=' . $id . '&return=' . base64_encode($uri)); ?>
										<a class="dropdown-item" href="<?php echo $url; ?>"><?php echo Text::_('JACTION_EDIT'); ?></a>
									<?php endif; ?>
									<?php if ($canChange) : ?>
										<button type="button" class="dropdown-item unpublish-module" data-module-id="<?php echo $id; ?>"><?php echo Text::_('JACTION_UNPUBLISH'); ?></button>
									<?php endif; ?>
								</joomla-dropdown>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="j-card-body p-0">
					<ul class="list-group list-group-flush">
						<?php foreach ($child->getChildren() as $item) : ?>
							<li class="list-group-item d-flex align-items-center">
								<?php $params = $item->getParams(); ?>
								<?php // Only if Menu-show = true
									if ($params->get('menu_show', 1)) : ?>
									<?php
									if (!empty($params->get('menu_image'))) :
										$image = htmlspecialchars($params->get('menu_image'), ENT_QUOTES, 'UTF-8');
										$class = htmlspecialchars($params->get('menu_image_css'), ENT_QUOTES, 'UTF-8');
										$alt = $params->get('menu_text') ? '' : htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');
									endif;
									?>
									<a class="flex-grow-1" href="<?php echo $item->link; ?>" target="<?php echo $item->target; ?>">
										<?php if (!empty($params->get('menu_image'))) : ?>
											<?php echo HTMLHelper::_('image', $image, $alt, 'class="' . $class . '"'); ?>
										<?php endif; ?>
										<?php echo ($params->get('menu_text', 1)) ? Text::_($item->title) : ''; ?>
										<?php if ($params->get('menu-quicktask', false)) : ?>
											<span class="menu-quicktask">
												<?php
												$link = $params->get('menu-quicktask-link');
												$icon = $params->get('menu-quicktask-icon', 'plus');

												$title = $params->get('menu-quicktask-title');

												if (empty($params->get('menu-quicktask-title')))
												{
													$title = Text::_('MOD_MENU_QUICKTASK_NEW');
													$sronly = Text::_($item->title) . ' - ' . Text::_('MOD_MENU_QUICKTASK_NEW');
												}

												$permission = $params->get('menu-quicktask-permission');
												$scope = $item->scope !== 'default' ? $item->scope : null;
												?>
												<?php if (!$permission || $user->authorise($permission, $scope)) : ?>
													<a href="<?php echo $link; ?>">
														<span class="icon-<?php echo $icon; ?> icon-xs" title="<?php echo htmlentities($title); ?>" aria-hidden="true"></span>
														<span class="sr-only"><?php echo  htmlentities($sronly); ?></span>
													</a>
												<?php endif; ?>
											</span>
										<?php endif; ?>
										<?php if ($item->ajaxbadge) : ?>
											<span class="menu-badge">
												<span class="icon-spin icon-spinner mt-1 system-counter" data-url="<?php echo $item->ajaxbadge; ?>"></span>
											</span>
										<?php endif; ?>
									</a>
									<?php if ($item->dashboard) : ?>
										<span class="menu-dashboard">
											<a href="<?php echo JRoute::_('index.php?option=com_cpanel&view=cpanel&dashboard=' . $item->dashboard); ?>">
												<span class="icon-menu" title="<?php echo htmlentities(Text::_('MOD_MENU_DASHBOARD_LINK')); ?>"></span>
											</a>
										</span>
									<?php endif; ?>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
