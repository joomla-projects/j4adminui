<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Khonsu
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

HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version'=> 'auto', 'relative' => true));

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];


if ($module->content) :
	$id = $module->id;

	// Permission checks
	$user    = Factory::getUser();
	$canEdit = $user->authorise('core.edit', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');
	$canChange  = $user->authorise('core.edit.state', 'com_modules.module.' . $id) && $user->authorise('core.manage', 'com_modules');

	$moduleTag      = $params->get('module_tag', 'div');
	$bootstrapSize  = (int) $params->get('bootstrap_size', 6);
	$moduleClass    = ($bootstrapSize) ? 'col-md-' . $bootstrapSize : 'col-md-12';
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h2'));
	$moduleClassSfx = $params->get('moduleclass_sfx', '');

	// Temporarily store header class in variable
	$headerClass = !empty($params->get('header_class')) ? ' ' . htmlspecialchars($params->get('header_class')) . '"' : '';

	// Get the module icon
	$headerIcon = '';

	$margin = Factory::getLanguage()->isRtl() ? ' ml-2' : ' mr-2';
	?>
	<div class="module-wrapper mb-4" data-dragable-group="dashboard_module">
		<<?php echo $moduleTag; ?> class="j-card <?php echo $moduleClassSfx; ?>">
			<?php if ($canEdit || $canChange || $headerIcon || $module->showtitle) : ?>
				<div class="j-card-header handle">
					<h3 class="j-card-title<?php echo $headerClass; ?>">
						<span class="j-card-icon icon-move duotone" area-hidden="true"></span>
						<?php if ($module->showtitle) :
							echo $headerIcon . htmlspecialchars($module->title);
						endif; ?>
					</h3>

					<div class="j-card-header-right">
						<button type="button" class="j-card-header-icon joomla-collapse-card-body" aria-expanded="true" aria-label="<?php echo Text::_('JTOGGLE_CARD_MSG');?>" data-target="module-<?php echo $id; ?>">
							<span class="toggle-icon icon-chevron-up"></span>	
						</button>
						<?php if ($canEdit || $canChange) : ?>
							<?php $dropdownPosition = Factory::getLanguage()->isRTL() ? 'left' : 'right'; ?>
							<div class="joomla-dropdown-container">
								<a href="javascript:;" class="j-card-header-icon" data-target="dropdownMenuButton-<?php echo $id; ?>">
									<span class="icon-ellipsis-h" aria-hidden="true"></span>
									<span class="sr-only"><?php echo Text::_('JACTION_EDIT') . ' ' . $module->title; ?></span>
								</a>
								<joomla-dropdown for="dropdownMenuButton-<?php echo $id; ?>">
									<?php if ($canEdit) : ?>
										<?php $uri = Uri::getInstance(); ?>
										<?php $url = Route::_('index.php?option=com_modules&task=module.edit&id=' . $id . '&return=' . base64_encode($uri)); ?>
										<a class="dropdown-item" href="<?php echo $url; ?>"><span class="icon-edit" aria-hidden="true"></span> <?php echo Text::_('JACTION_EDIT'); ?></a>
									<?php endif; ?>
									<?php if ($canChange) : ?>
										<button type="button" class="dropdown-item unpublish-module" data-module-id="<?php echo $id; ?>"><span class="icon-eye-close" aria-hidden="true"></span> <?php echo Text::_('JACTION_UNPUBLISH'); ?></button>
									<?php endif; ?>
								</joomla-dropdown>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="j-module-content" id="module-<?php echo $id; ?>">
				<?php echo $module->content; ?>
			</div>
		</<?php echo $moduleTag; ?>>
		<input type="hidden" value="<?php echo $id; ?>" name="cid[]">
		<input type="hidden" value="<?php echo isset($module->ordering) ? $module->ordering: 0; ?>" name="order[]">
		<input type="hidden" value="<?php echo $params->get('column_position', 0); ?>" name="position[]">
	</div>
<?php endif; ?>
