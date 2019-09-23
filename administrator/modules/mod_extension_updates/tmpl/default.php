<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_extension_updates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('behavior.core');
HTMLHelper::_('webcomponent', 'system/joomla-progress.min.js', ['version' => 'auto', 'relative' => true]);

$updateMsg = '';

if (!empty($extensionContents['updatableInfo']['component']))
{
    $updateMsg .= Text::plural('MOD_EXTENSION_UPDATES_COMPONENTS', $extensionContents['updatableInfo']['component']);
}

if (!empty($extensionContents['updatableInfo']['module']))
{
    $updateMsg .= Text::plural('MOD_EXTENSION_UPDATES_MODULES', $extensionContents['updatableInfo']['module']);
}

if (!empty($extensionContents['updatableInfo']['plugin']))
{
    $updateMsg .= Text::plural('MOD_EXTENSION_UPDATES_PLUGINS', $extensionContents['updatableInfo']['plugin']);
}

if (!empty($extensionContents['updatableInfo']['library']))
{
    $updateMsg .= Text::plural('MOD_EXTENSION_UPDATES_LIBRARIES', $extensionContents['updatableInfo']['library']);
}

if (!empty($extensionContents['updatableInfo']['package']))
{
    $updateMsg .= Text::plural('MOD_EXTENSION_UPDATES_PACKAGES', $extensionContents['updatableInfo']['package']);
}

?>

<div class="mod-extension-updates module-<?php echo $module->id; ?>" id="mod-extension-updates-<?php echo $module->id; ?>">
    <div class="mod-eu-joomla-update">
        <?php if($extensionContents['updateJoomla']) : ?>
            <a href="<?php echo Route::_('index.php?option=com_joomlaupdate'); ?>" class="btn btn-link"><?php echo Text::_('Outdated'); ?></a>
        <?php else : ?>
        <div class="updated">
            <div class="outdated"><?php echo Text::_('Updated'); ?></div>    
        </div>
        <?php endif; ?> 
    </div><!-- /.mod-eu-joomla-update -->

    <div class="mod-eu-extension-update">
        <div class="mod-eu-percent">
            <h4><?php echo $extensionContents['percentage'] . '%'; ?></h4>
            <p><?php echo Text::_('MOD_EXTENSION_UPDATES_UPDATED'); ?></p>
        </div>

        <div class="j-progress">
            <joomla-progress progress="<?php echo $extensionContents['percentage']; ?>" radius="80" stroke="15" duration="2000" >
                <h2><span data-counter="true"></span>%</h2>
                <span>Updated</span>
            </joomla-progress>
        </div>

        <?php if(!empty($extensionContents['updatableInfo']['component']) || 
            !empty($extensionContents['updatableInfo']['module']) ||
            !empty($extensionContents['updatableInfo']['plugin']) ||
            !empty($extensionContents['updatableInfo']['library']) ||
            !empty($extensionContents['updatableInfo']['package'])) : ?>
            <div class="mod-eu-group-count">
                <p class=""><?php echo Text::sprintf('MOD_EXTENSION_UPDATES_UPDATE_EXTENSIONS_MSG', $updateMsg); ?></p>
            </div>
            <div class="mod-eu-group-update-all">
                <a href="<?php echo Route::_('index.php?option=com_installer&view=update'); ?>" class="btn btn-link"><span class="fa fa-sync"></span> <?php echo JText::_('MOD_EXTENSION_UPDATES_UPDATE_ALL'); ?></a>
            </div>
        <?php else: ?>
            <div class="mod-eu-uptodate">
                <span class="fa fa-check-circle"></span> <?php echo Text::_('MOD_EXTENSION_UPDATES_UPTODATE'); ?>
            </div>
        <?php endif; ?>
    </div><!-- /.mod-eu-extension-update -->
</div>