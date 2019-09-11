<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_frontend
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
?>
<div class="header-item-content">
	<a class="header-item-link" href="<?php echo Uri::root(); ?>"
		title="<?php echo Text::sprintf('MOD_FRONTEND_PREVIEW', $sitename); ?>"
		target="_blank">
		<?php echo HTMLHelper::_('string.truncate', $sitename, 28, false, false); ?>
        <span class="header-item-icon fa fa-external-link-alt" aria-hidden="true"></span>
	</a>
</div>
