<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_accessibility
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;
?>
<div class="mod-accessibility module-<?php echo $module->id; ?>" id="mod-accessibility-<?php echo $module->id; ?>">

    <a class="header-item-link" id="accessibility-collapse-control" href="javascript:void(0);">
        <span class="header-item-icon fab fa-accessible-icon" aria-hidden="true"></span>
        <span class="header-item-text">
            <?php echo Text::_('MOD_ACCESSIBILITY'); ?>
        </span>
    </a>

    <!-- /.offcanvas -->
    <div class="accessibility-sidebar j-card pr-2 font-unresizable">
        <!-- <div class=" pr-2"> -->
        <div class="j-card-body">
            <div class="accessibility-scaling">
                <div class="card-content font-unresizable">
                    <div class="font-size font-unresizable">
                        <h3 class="font-unresizable"><?php echo Text::_('MOD_ACCESSIBILITY_CONTENT_SCALING'); ?></h3>
                        <button class="btn btn-secondary font-unresizable" id="decrement">-</button>
                        <span class="font-percent-value font-unresizable">0%</span>
                        <button class="btn btn-secondary font-unresizable" id="increment">+</button>
                    </div>
                </div>
            </div>
            <div class="accessibility-items-wrap mb-4">
                <div class="accessibility--item">
                    <a class="btn btn-secondary accessible-action-btn p-5" data-type="grayscale" href="javascript:void(0);">
                        <span class="fas fa-adjust mb-2" aria-hidden="true"></span>
                        <?php echo Text::_('MOD_ACCESSIBILITY_GRAYSCALE'); ?>
                    </a>
                </div>
                <div class="accessibility--item">
                    <a class="btn btn-secondary accessible-action-btn p-5" data-type="nomotion" href="javascript:void(0);">
                        <span class="fas fa-radiation-alt mb-2" aria-hidden="true"></span>
                        <?php echo Text::_('MOD_ACCESSIBILITY_DISABLE_MOTION'); ?>
                    </a>
                </div>
            </div>

            <div class="accessibility-items-wrap mb-4">
                <div class="accessibility--item">
                    <a class="btn btn-secondary accessible-action-btn p-5" data-type="bbcursor" href="javascript:void(0);">
                        <span class="fas fa-radiation-alt mb-2" aria-hidden="true"></span>
                        <?php echo Text::_('MOD_ACCESSIBILITY_BIG_BLACK_CURSOR'); ?>
                    </a>
                </div>
                <div class="accessibility--item">
                    <a class="btn btn-secondary accessible-action-btn p-5" data-type="bhcursor" href="javascript:void(0);">
                        <span class="fas fa-radiation-alt mb-2" aria-hidden="true"></span>
                        <?php echo Text::_('MOD_ACCESSIBILITY_BIG_WHITE_CURSOR'); ?>
                    </a>
                </div>
            </div>

            <div class="accessibility-items-wrap mb-4">
                <div class="accessibility--item">
                    <a class="btn btn-secondary accessible-action-btn p-5" data-type="magnifier" href="javascript:void(0);">
                        <span class="fas fa-radiation-alt mb-2" aria-hidden="true"></span>
                        <?php echo Text::_('MOD_ACCESSIBILITY_MAGNIFIER'); ?>
                    </a>
                </div>
                <div class="accessibility--item">
                    <a class="btn btn-secondary accessible-action-btn p-5" data-type="contrast" href="javascript:void(0);">
                        <span class="fas fa-radiation-alt mb-2" aria-hidden="true"></span>
                        <?php echo Text::_('MOD_ACCESSIBILITY_CONTRAST'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="j-card-footer j-card-footer-sm accessibility-mouse-highligther">
            <div class="j-checkbox-group">
                <label>
                    <input type="checkbox" name="mouse-highlighter" id="a11y-mouse-highlighter" data-type="mouse-highlighter"> <?php echo Text::_('MOD_ACCESSIBILITY_MOUSE_HIGHLIGHTER'); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="a11y-cursor-pointer"><div class="a11y-cursor-pointer-inner"></div></div>
</div>