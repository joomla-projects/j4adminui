<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_draft_article
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
HTMLHelper::_('behavior.keepalive');

Factory::getDocument()->addScriptOptions('saveurl', Uri::root() . 'administrator/index.php?option=com_ajax&module=draft_article&method=saveDraftArticle&format=json');
Factory::getDocument()->addScriptOptions('editurl', Uri::root() . 'administrator/index.php?option=com_content&task=article.edit&id=');

?>

<form name="draftArticleForm" id="form-draftarticle" method="post" action="#">
    <fieldset>
        <div class="form-group">
            <label for="mod-draftarticle-title" >
                <?php echo JText::_('JGLOBAL_TITLE'); ?>
            </label>
            <div class="input-group">
                <input 
                    type="text"
                    id="mod-draftarticle-title"
                    name="title"
                    class="form-control input-full"
                    required="required"
                    autofocus
                >
            </div>
        </div>

        <div class="form-group">
            <label for="mod-draftarticle-description">
                <?php echo JText::_('JGLOBAL_FIELDSET_CONTENT'); ?>
            </label>
            <div class="input-group">
                <textarea 
                    name="description"
                    id="mod-draftarticle-description"
                    cols="10"
                    rows="5"
                    class="form-control input-full"
                    max="500"
                ></textarea>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-cancel" type="button" role="button" id="mod-draftarticle-clear">
                <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
            </button>
            <button class="btn btn-primary" type="submit" role="button" id="mod-draftarticle-submit">
                <?php echo JText::_('MOD_DRAFTARTICLE_SAVE_ARTICLE'); ?>
            </button>
        </div>

    </fieldset>
</form>