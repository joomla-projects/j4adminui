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
$resourceStatus = $params->get('show_resources', 'both');
?>
<div class="mod-resources mod-resources-<?php echo $params->get('moduleclass_sfx', ''); ?>" id="mod-resources-<?php echo $module->id; ?>">
    <?php if( $resourceStatus === 'help') : ?>
        <div class="info-cards-container">
            <div class="row no-gutters justify-content-center">
				<div class="col-12 j-card-quick-link-col d-inline-flex align-items-center">
					<div class="j-card j-card-quick-link j-success">
						<div class="j-card-quick-link-body">
							<span class="icon-support duotone j-card-icon"></span>
							<div class="j-card-quick-link-content">
								<a href="https://forum.joomla.org" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_HELP_LABEL'); ?></a>
								<p><?php echo Text::_('MOD_RESOURCES_GET_HELP_DESC'); ?></p>
							</div>
						</div>
					</div>
				</div><!-- /.info-card-help -->
				<div class="col-12 j-card-quick-link-col d-inline-flex align-items-center">
					<div class="j-card j-card-quick-link j-danger">
						<div class="j-card-quick-link-body">
							<span class="icon-cart duotone j-card-icon"></span>
							<div class="j-card-quick-link-content">
								<a href="https://community.joomla.org/the-joomla-shop.html" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_SHOP_LABEL'); ?></a>
								<p><?php echo Text::_('MOD_RESOURCES_GET_SHOP_DESC'); ?></p>
							</div>
						</div>
					</div>
				</div><!-- /.info-card-shop -->
                <div class="col-12 j-card-quick-link-col d-inline-flex align-items-center">
                    <div class="j-card j-card-quick-link j-warning">
                        <div class="j-card-quick-link-body">
                            <span class="icon-comment duotone j-card-icon"></span>
                            <div class="j-card-quick-link-content">
                                <a href="https://issues.joomla.org/" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_FEEDBACK_LABEL'); ?></a>
                                <p><?php echo Text::_('MOD_RESOURCES_GET_FEEDBACK_DESC'); ?></p>
                            </div>
                        </div>
                    </div>
                </div><!-- /.info-card-feedback -->
                <div class="col-12 j-card-quick-link-col d-inline-flex align-items-center">
                    <div class="j-card j-card-quick-link j-info">
                        <div class="j-card-quick-link-body">
                            <span class="icon-learn duotone j-card-icon"></span>
                            <div class="j-card-quick-link-content">
                                <a href="https://docs.joomla.org/" target="_blank"><?php echo Text::_('MOD_RESOURCES_GET_LEARN_LABEL'); ?></a>
                                <p><?php echo Text::_('MOD_RESOURCES_GET_LEARN_DESC'); ?></p>
                            </div>
                        </div>
                    </div>
                </div><!-- /.info-card-learn -->
            </div>
        </div><!-- /.info-cards-container -->
    <?php endif; ?>

    <?php if($resourceStatus === 'jrd') : ?>
        <div class="resources-card-container">
            <div class="j-card">
                <div class="j-card-body">
                    <div class="row align-items-center justify-content-center justify-content-xl-start">
                        <div class="col-12 col-xl-auto mb-5 mb-xl-0 text-center text-xl-left">
                            <?php echo HTMLHelper::_('image', 'mod_resources/resource-pay.png', 'Resources pay', array('class' => "mod-resources-image"), true); ?>
                        </div>
                        <div class="col">
                            <div class="row mt-n3">
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/creative-strategy" target="_blank"><?php echo Text::_('MOD_RESOURCES_CREATIVE_STRATEGY'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/content-development" target="_blank"><?php echo Text::_('MOD_RESOURCES_CONTENT_DEVELOPMENT'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://developer.joomla.org/development-strategy.html" target="_blank"><?php echo Text::_('MOD_RESOURCES_DEVELOPMENT'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/configuration-support" target="_blank"><?php echo Text::_('MOD_RESOURCES_CONFIGURATION'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/hosting-providers" target="_blank"><?php echo Text::_('MOD_RESOURCES_HOSTING_PROVIDERS'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/design-development" target="_blank"><?php echo Text::_('MOD_RESOURCES_DESIGN'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://extensions.joomla.org/"><?php echo Text::_('MOD_RESOURCES_EXTENSION'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/joomla-security" target="_blank"><?php echo Text::_('MOD_RESOURCES_JOOMLA_SECURITY'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/technical-support" target="_blank"><?php echo Text::_('MOD_RESOURCES_TECHNICAL_SUPPORT'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/consulting" target="_blank"><?php echo Text::_('MOD_RESOURCES_CONSULTING'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/migration-and-upgrade-services" target="_blank"><?php echo Text::_('MOD_RESOURCES_MIGRATIONS'); ?></a>
                                </div>
                                <div class="col-12 col-md-auto mt-3">
                                    <a href="https://resources.joomla.org/en/category/project-management" target="_blank"><?php echo Text::_('MOD_RESOURCES_PROJECT_MANAGEMENT'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.resources-card-container -->
    <?php endif; ?>
</div>
