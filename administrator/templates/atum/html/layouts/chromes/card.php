<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Atum
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

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
	$headerClass = !empty($params->get('header_class')) ? ' class="' . htmlspecialchars($params->get('header_class')) . '"' : '';

	// Get the module icon
	$headerIcon = '';

	$margin = Factory::getLanguage()->isRtl() ? ' ml-2' : ' mr-2';

	if (!empty($params->get('header_icon')))
	{
		$headerIcon = '<span class="' . htmlspecialchars($params->get('header_icon')) .  $margin . '" aria-hidden="true"></span>';
	}
	?>
	<div class="module-wrapper">
		<<?php echo $moduleTag; ?> class="<?php echo $moduleClassSfx; ?>">
			<div class="mb-3">
				<?php echo $module->content; ?>
			</div>
		</<?php echo $moduleTag; ?>>
	</div>
<?php endif; ?>
