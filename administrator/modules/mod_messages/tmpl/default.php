<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_messages
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$hideLinks = $app->input->getBool('hidemainmenu');
$uri   = Uri::getInstance();
$route = 'index.php?option=com_messages&view=messages&id=' . $app->getIdentity()->id . '&return=' . base64_encode($uri);
?>

<a class="header-item-link <?php echo ($hideLinks ? 'disabled' : ''); ?>" <?php echo ($hideLinks ? '' : 'href="' . Route::_($route) . '"'); ?> title="<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>">
	<span class="header-item-icon icon-envelope" aria-hidden="true"></span>
	<span class="header-item-text">
		<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>
	</span>
	<?php $countUnread = $app->getSession()->get('messages.unread'); ?>
	<?php if ($countUnread > 0) : ?>
		<span class="badge badge-pill badge-danger"><?php echo $countUnread; ?></span>
	<?php endif; ?>
</a>
