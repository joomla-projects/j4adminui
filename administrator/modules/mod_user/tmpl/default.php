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
use Joomla\CMS\HTML\HTMLHelper;

$hideLinks = $app->input->getBool('hidemainmenu');

HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version'=> 'auto', 'relative' => true));
?>

<div class="header-item-content header-profile">
    <div class="joomla-dropdown-container">
        <button data-target="header-user-dropdown" class="header-dropdown-button <?php echo ($hideLinks ? 'disabled' : ''); ?>" type="button" <?php echo ($hideLinks ? 'disabled' : ''); ?> title="<?php echo Text::_('MOD_USER_MENU'); ?>">
            <span class="header-user-icon icon-user"></span>
            <span class="header-user-name"><?php echo $user->name; ?></span>
            <span class="icon-angle-down" aria-hidden="true"></span>
        </button>
        
        <joomla-dropdown for="header-user-dropdown">
            <?php $uri   = Uri::getInstance(); ?>
		    <?php $route = 'index.php?option=com_users&task=user.edit&id=' . $user->id . '&return=' . base64_encode($uri); ?>
            <a href="<?php echo Route::_($route); ?>" class="dropdown-item">
                <span class="icon-user"></span>
				<?php echo Text::_('MOD_USER_EDIT_ACCOUNT'); ?>
            </a>
            <?php // TODO: route to accessibility settings ?>
            <a href="#" class="dropdown-item">
                <span class="icon-shield"></span>
				<?php echo Text::_('MOD_USER_ACCESSIBILITY_SETTINGS'); ?>
            </a>
            <?php $route = 'index.php?option=com_login&task=logout&amp;' . Session::getFormToken() . '=1'; ?>
            <a href="<?php echo Route::_($route); ?>" class="dropdown-item text-center">
                <?php echo Text::_('JLOGOUT'); ?>
                <span class="icon-exit"></span>
            </a>
        </joomla-dropdown>
    </div>
</div>
