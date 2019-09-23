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

// ajax URL
Factory::getDocument()->addScriptOptions('cacheurl', Uri::root() . 'administrator/index.php?option=com_ajax&module=cache&method=clearCache&format=json');

//echo $module->content;

?>

<div class="jcardmbcol-lg-4">
    <div class="jcard-overview-box pt-3">
        <div class="jcard-overview-content" area-hidden="true">
            <div>
                <img src="<?php echo JURI::base().'modules/'.$module->module . '/assets/images/speedup.jpg'?>" alt="clear cache">
            </div>
            <span class="j-counter-animation">&lrm;<?php echo $total_cache; ?></span>
            <sub aria-hidden="true">Files Total Cache.</sub>
        </div>
    </div>
    <div class="jcard-footer jcard-footer-lg">
        <div class="jcard-footer-item">
            <?php if($total_cache > 1): ?>
                <a id="jclear-cache-btn" href="#">
                    <span class="fa fa-trash-alt jcard-icon" aria-hidden="true"></span>
                    <span aria-hidden="true">Clear Cache</span>
                </a>
            <?php endif; ?>
        </div>					
	</div>
</div>    
