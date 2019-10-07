<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_submenu
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
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


$app = JFactory::getApplication();
$user = $app->getIdentity();

$id = $module->id;

$canEdit = $user->authorise('core.edit', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');
$canChange  = $user->authorise('core.edit.state', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');

/** @var  \Joomla\CMS\Menu\MenuItem  $root */
?>
	<?php if (Factory::getUser()->authorise('core.edit', 'com_modules')) : ?>
	<?php endif; ?>
	<?php foreach ($root->getChildren() as $key => $child) : ?>
		<?php if ($child->hasChildren()) : ?>
			<ul class="mobile-quickmenu-items">
				<?php foreach ($child->getChildren() as $item) : ?>
					<li class="mobile-quickmenu-item">
						<?php $params = $item->getParams(); ?>
						<?php if($item->type == 'viewsite') : 
							$sitename = htmlspecialchars($app->get('sitename', ''), ENT_QUOTES, 'UTF-8');
							?>
							<a class="header-item-link" href="<?php echo Uri::root(); ?>" title="<?php echo Text::sprintf('MOD_FRONTEND_PREVIEW', $sitename); ?>" target="_blank">
								<span class="fas fa-external-link-square-alt" aria-hidden="true"></span>
								<span class="header-item-text">
									<?php echo Text::_('MOD_FRONTEND_VIEW_SITE'); ?>
								</span>
							</a>
						<?php else : ?>
							<a class="flex-grow-1" href="<?php echo $item->link; ?>" target="<?php echo $item->target; ?>">
								<?php if ($item->icon) : ?>
									<span class="<?php echo $item->icon;?>" aria-hidden="true"></span>
								<?php elseif (!empty($params->get('menu_image'))) : ?>
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
												<span class="fas fa-<?php echo $icon; ?> fa-xs" title="<?php echo htmlentities($title); ?>" aria-hidden="true"></span>
												<span class="sr-only"><?php echo  htmlentities($sronly); ?></span>
											</a>
										<?php endif; ?>
									</span>
								<?php endif; ?>
								<?php if ($item->ajaxbadge) : ?>
									<span class="menu-badge">
										<span class="fas fa-spin fa-spinner mt-1 system-counter" data-url="<?php echo $item->ajaxbadge; ?>"></span>
									</span>
								<?php endif; ?>
							</a>
							<?php if ($item->dashboard) : ?>
								<span class="menu-dashboard">
									<a href="<?php echo JRoute::_('index.php?option=com_cpanel&view=cpanel&dashboard=' . $item->dashboard); ?>">
										<span class="fas fa-th-large" title="<?php echo htmlentities(Text::_('MOD_MENU_DASHBOARD_LINK')); ?>"></span>
									</a>
								</span>
							<?php endif; ?>
						<?php endif; ?>	
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endforeach; ?>
