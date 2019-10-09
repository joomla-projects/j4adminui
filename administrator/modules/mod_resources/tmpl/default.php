<?php

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_resources
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<div class="mod-resources mod-resources-<?php echo $params->get('moduleclass_sfx', ''); ?>" id="mod-resources-<?php echo $module->id; ?>">
    <div class="info-cards-container">
        <div class="row justify-content-center">
            <div class="info-card-help col-12">
                <div class="j-card j-card-quick-link j-success j-card-has-hover">
                    <div class="j-card-header j-card-header-sm">
                        <div class="j-card-header-right">
                            <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>
                    <div class="j-card-quick-link-body">
                        <span class="fas fa-life-ring j-card-icon"></span>
                        <div class="j-card-quick-link-content">
                            <a href="https://forum.joomla.org" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_HELP_LABEL'); ?></a>
                            <p><?php echo Text::_('MOD_RESOURCES_GET_HELP_DESC'); ?></p>
                        </div>
                    </div>
                </div>
            </div><!-- /.info-card-help -->
            <div class="info-card-shop col-12">
                <div class="j-card j-card-quick-link j-danger j-card-has-hover">
                    <div class="j-card-header j-card-header-sm">
                        <div class="j-card-header-right">
                            <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>
                    <div class="j-card-quick-link-body">
                        <span class="fas fa-shopping-cart j-card-icon"></span>
                        <div class="j-card-quick-link-content">
                            <a href="https://community.joomla.org/the-joomla-shop.html" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_SHOP_LABEL'); ?></a>
                            <p><?php echo Text::_('MOD_RESOURCES_GET_SHOP_DESC'); ?></p>
                        </div>
                    </div>
                </div>
            </div><!-- /.info-card-shop -->
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col info-card-feedback">
                <div class="j-card j-card-quick-link j-warning j-card-has-hover">
                    <div class="j-card-header j-card-header-sm">
                        <div class="j-card-header-right">
                            <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>
                    <div class="j-card-quick-link-body">
                        <span class="fas fa-comments j-card-icon"></span>
                        <div class="j-card-quick-link-content">
                            <a href="https://issues.joomla.org/" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_FEEDBACK_LABEL'); ?></a>
                            <p><?php echo Text::_('MOD_RESOURCES_GET_FEEDBACK_DESC'); ?></p>
                        </div>
                    </div>
                </div>
            </div><!-- /.info-card-feedback -->
            <div class="col info-card-learn">
                <div class="j-card j-card-quick-link j-info j-card-has-hover">
                    <div class="j-card-header j-card-header-sm">
                        <div class="j-card-header-right">
                            <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                        </div>
                    </div>
                    <div class="j-card-quick-link-body">
                        <span class="fas fa-graduation-cap j-card-icon"></span>
                        <div class="j-card-quick-link-content">
                            <a href="https://docs.joomla.org/" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_LEARN_LABEL'); ?></a>
                            <p><?php echo Text::_('MOD_RESOURCES_GET_LEARN_DESC'); ?></p>
                        </div>
                    </div>
                </div>
            </div><!-- /.info-card-learn -->
        </div>

    </div><!-- /.info-cards-container -->

    <div class="resources-card-container mt-4">
        <div class="j-card">
            <div class="j-card-header">
                <h4 class=""><?php echo Text::_('MOD_RESOURCES_LABEL'); ?></h4>
                <div class="j-card-header-right">
                    <button class="j-card-header-icon fas fa-ellipsis-h"></button>
                </div>
            </div>
            <div class="j-card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3 mb-md-0">
                        <?php echo HTMLHelper::_('image', 'mod_resources/resource-pay.png', 'Resources pay', array('class' => "mod-resources-image"), true); ?>
                    </div>
                    <div class="col">
                        <div class="row mt-n3">
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/creative-strategy" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_CREATIVE_STRATEGY'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/content-development" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_CONTENT_DEVELOPMENT'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://developer.joomla.org/development-strategy.html" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_DEVELOPMENT'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/configuration-support" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_CONFIGURATION'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/hosting-providers" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_HOSTING_PROVIDERS'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/design-development" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_DESIGN'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://extensions.joomla.org/" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_EXTENSION'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/joomla-security" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_JOOMLA_SECURITY'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/technical-support" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_TECHNICAL_SUPPORT'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/consulting" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_CONSULTING'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/migration-and-upgrade-services" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_MIGRATIONS'); ?></a>
                            </div>
                            <div class="col-12 col-md-auto mt-3">
                                <a href="https://resources.joomla.org/en/category/project-management" target="_blank" class="btn btn-default btn-block"><?php echo Text::_('MOD_RESOURCES_PROJECT_MANAGEMENT'); ?></a>
                            </div>
                        </div>
                        <!-- <div class="row mt-3">

                        </div>
                        <div class="row mt-3">

                        </div>
                        <div class="row mt-3">

                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.resources-card-container -->
</div>
