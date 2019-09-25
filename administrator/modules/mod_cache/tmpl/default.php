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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

// cache ajax URL
Factory::getDocument()->addScriptOptions('cacheurl', Uri::root() . 'administrator/index.php?option=com_ajax&module=cache&method=clearCache&format=json');

?>

<div class="mod-extension-cache module-<?php echo $module->id; ?>" id="mod-extension-cache-<?php echo $module->id; ?>">
    <div class="j-card">
        <div class="j-card-image-mod-container text-center">
			<div class="j-card-img">
				<img src="<?php echo JURI::base().'modules/'.$module->module . '/assets/images/speedup.jpg'?>" alt="clear cache">
			</div>
			<div class="j-card-counter-msg">
				<span class="j-cache-animation">&lrm;<?php echo $cacheInfo['size']; ?></span>
				<?php echo Text::sprintf('MOD_CACHE_QUICKICON_TOTAL_CACHE', $cacheInfo['unit']); ?>
			</div>
        </div>
        <div class="j-card-footer j-card-footer-lg">
            <div class="j-card-footer-item">
                <?php if($cacheInfo['raw']): ?>
                    <a id="jclear-cache-btn" data-size="<?php echo $cacheInfo['size']; ?>" href="javascript:;">
                        <span class="fa fa-trash-alt j-card-icon" aria-hidden="true"></span>
                        <span aria-hidden="true"><?php echo Text::_('MOD_CACHE_QUICKICON_CLEAR_CACHE'); ?></span>
                    </a>
                <?php else: ?>
                    <span class="no-link"><?php echo Text::_('MOD_CACHE_QUICKICON_SRONLY_NOCACHE'); ?></span>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
