<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_post_installation_messages
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
HTMLHelper::_('webcomponent', 'system/joomla-callout.min.js', array('version'=> 'auto', 'relative' => true));

$hideLinks = $app->input->getBool('hidemainmenu');
?>
<?php if ($app->getIdentity()->authorise('core.manage', 'com_postinstall')) : ?>
	<div class="j-card-body">
		<a href="#" id="showCollout" class="header-item-link<?php echo ($hideLinks ? ' disabled' : ''); ?>"<?php echo ($hideLinks ? ' disabled' : ''); ?> title="<?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?>" role="button">
			<span class="header-item-icon icon-notification" aria-hidden="true"></span> <span class="header-item-text"><?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?></span> <span class="icon-chevron-right" aria-hidden="true"></span>
			<?php if (count($messages) > 0) : ?>
				<span class="badge badge-pill badge-danger"><?php echo count($messages); ?></span>
			<?php endif; ?>
		</a>
	</div>
	<?php if (!$hideLinks) : ?>
		<joomla-callout for="#showCollout" dismiss="true" position="bottom">
			<div class="callout-title">
				<?php echo Text::_('MOD_POST_INSTALLATION_MESSAGES'); ?>
			</div>
			<div class="callout-content">
				<?php if (empty($messages)) : ?>
					<div class="dropdown-item">
						<a href="<?php echo Route::_('index.php?option=com_postinstall&eid=' . $joomlaFilesExtensionId); ?>">
							<?php echo Text::_('COM_POSTINSTALL_LBL_NOMESSAGES_TITLE'); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="callout-footer">
				<?php foreach ($messages as $message) : ?>
					<?php $route = 'index.php?option=com_postinstall&amp;eid=' . $joomlaFilesExtensionId; ?>
					<?php $title = Text::_($message->title_key); ?>
					<a href="<?php echo Route::_($route); ?>" class="callout-link" title="<?php echo $title; ?>">
						<?php echo $title; ?>
					</a>
				<?php endforeach; ?>
			</div>
		</joomla-callout>
	<?php endif; ?>
<?php endif; ?>
