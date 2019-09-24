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
    <div class="jcard">
        <div class="jcard-overview-box pt-3">
            <div class="jcard-overview-content" area-hidden="true">
                <div class="jcard-img">
                    <img src="<?php echo JURI::base().'modules/'.$module->module . '/assets/images/speedup.jpg'?>" alt="clear cache">
                </div>
                <span class="j-cache-animation">&lrm;<?php echo $cacheInfo['size']; ?></span>
                <sub class="j-counter-" aria-hidden="true"><?php echo Text::sprintf('MOD_CACHE_QUICKICON_TOTAL_CACHE', $cacheInfo['unit']); ?></sub>
            </div>
        </div>
        <div class="jcard-footer jcard-footer-lg">
            <div class="jcard-footer-item">
                <?php if($cacheInfo['raw']): ?>
                    <a id="jclear-cache-btn" data-size="<?php echo $cacheInfo['size']; ?>" href="javascript">
                        <span class="fa fa-trash-alt jcard-icon" aria-hidden="true"></span>
                        <span aria-hidden="true"><?php echo Text::_('MOD_CACHE_QUICKICON_CLEAR_CACHE'); ?></span>
                    </a>
                <?php else: ?>
                    <span><?php echo Text::_('MOD_CACHE_QUICKICON_SRONLY_NOCACHE'); ?></span>
                <?php endif;?>
            </div>					
        </div>
    </div>
</div>
