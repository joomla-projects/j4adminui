<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_cache
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

// cache ajax URL
Factory::getDocument()->addScriptOptions('cacheurl', Uri::root() . 'administrator/index.php?option=com_ajax&module=cache&method=clearCache&format=json');

?>

<div class="mod-extension-cache text-center text-xl-left module-<?php echo $module->id; ?>" id="mod-extension-cache-<?php echo $module->id; ?>">
	<div class="j-card-body">
		<div class="row align-items-center">
			<div class="col-12 col-xl-auto mb-4 mb-xl-0">
				<?php echo HTMLHelper::_('image', 'mod_cache/cache-cleaning.svg', Text::_('MOD_CACHE_CACHE_CLEANING_ALT_TEXT'), array('class' => "mod-cache-image", 'width' => "100%"), true); ?>
			</div>
			<div class="col">
				<div class="j-card-vertical-content pl-xl-4">
					<div class="j-card-counter-msg">
						<span class="j-count-number j-cache-animation">&lrm;<?php echo $cacheInfo['size']; ?></span>
						<?php echo Text::sprintf('MOD_CACHE_QUICKICON_TOTAL_CACHE', $cacheInfo['unit']); ?>
					</div>
					<p><?php echo Text::_('MOD_CACHE_MSG'); ?></p>
					<div class="j-card-vertical-btn-group">
						<?php if($cacheInfo['raw']): ?>
							<button id="jclear-cache-btn" class="btn btn-primary" data-size="<?php echo $cacheInfo['size']; ?>" type="button">
								<span class="icon-trash icon-md" area-hidden="true"></span>
								<?php echo Text::_('MOD_CACHE_QUICKICON_CLEAR_CACHE'); ?>
							</button>
						<?php else: ?>
							<button class="btn btn-primary disabled">
								<span class="icon-info-circle icon-md" area-hidden="true"></span>
								<?php echo Text::_('MOD_CACHE_QUICKICON_SRONLY_NOCACHE'); ?>
							</button>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
