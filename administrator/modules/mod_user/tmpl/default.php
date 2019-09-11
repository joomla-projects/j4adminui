<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_user
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

$hideLinks = $app->input->getBool('hidemainmenu');
?>

<div class="header-item-content header-profile">
	<button id="header-user-dropdown" class="header-dropdown-button <?php echo ($hideLinks ? 'disabled' : ''); ?>" type="button" <?php echo ($hideLinks ? 'disabled' : ''); ?> title="<?php echo Text::_('MOD_USER_MENU'); ?>">
        <span class="header-user-icon fas fa-user"></span>
		<span class="header-user-name"><?php echo $user->name; ?></span>
        <span class="fa fa-angle-down" aria-hidden="true"></span>
	</button>


	<!--

	@TODO: User menu dropdown must be completed

	<div>
		<div class="dropdown-header"><?php /*echo $user->name; */?></div>
		<?php /*$uri   = Uri::getInstance(); */?>
		<?php /*$route = 'index.php?option=com_users&task=user.edit&id=' . $user->id . '&return=' . base64_encode($uri); */?>
		<div class="dropdown-item">
			<a href="<?php /*echo Route::_($route); */?>">
				<span class="fa fa-user"></span>
				<?php /*echo Text::_('MOD_USER_EDIT_ACCOUNT'); */?>
			</a>
		</div>
		<div class="dropdown-item">
			<?php /*// TODO: route to accessibility settings */?>
			<a href="#">
				<span class="fa fa-universal-access"></span>
				<?php /*echo Text::_('MOD_USER_ACCESSIBILITY_SETTINGS'); */?>
			</a>
		</div>
		<div class="dropdown-item">
			<?php /*$route = 'index.php?option=com_login&task=logout&amp;' . Session::getFormToken() . '=1'; */?>
			<a href="<?php /*echo Route::_($route); */?>">
				<span class="fa fa-power-off"></span>
				<?php /*echo Text::_('JLOGOUT'); */?>
			</a>
		</div>
	</div>-->

</div>
