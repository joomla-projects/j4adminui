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
use Joomla\CMS\Response\JsonResponse;
use Joomla\String\StringHelper;

/**
 * mod_draft_article_helper helper class for the module
 * 
 */
class ModDraftArticleHelper
{
    public static function saveDraftArticleAjax()
    {
        $app = Factory::getApplication();
        $table = $app->bootComponent('com_content')->getMVCFactory()->createTable('Article', 'Administrator', ['ignore_request' => true]);
        $user = Factory::getUser();

        
        
        // Check if the user has the access permission to create a new article
        if (!$user->authorise('core.create', 'com_content')) 
        {
            $app->setHeader('status', 401, true);
            $app->sendHeaders();
            echo Text::_('MOD_DRAFTARTICLE_NOT_AUTHORISED');
            $app->close();
            
        }
        
        $input = $app->input;
        
        $title = $input->post->get('title', '', 'STRING');
        $description = $input->post->get('description', '', 'STRING');
        $catid = 2;

        $articleObject = new \stdClass;
        $articleObject->id = null;
        $articleObject->title = $title;
        $articleObject->alias = StringHelper::increment($title, 'dash');
        
        while ($table->load(array('alias' => $articleObject->alias, 'catid' => 2)))
        {
            $articleObject->alias = StringHelper::increment($title, 'dash');
        }
        
        $articleObject->introtext = "<p>" . $description . "</p>";
        $articleObject->fulltext = "";
        $articleObject->images = "";
        $articleObject->urls = "";
        $articleObject->attribs = "";
        $articleObject->metakey = "";
        $articleObject->metadesc = "";
        $articleObject->metadata = "";
        
        $articleObject->catid = $catid;
        $articleObject->published = 0;
        $articleObject->created = Factory::getDate()->toSql();
        $articleObject->created_by = $user->id;
        $articleObject->language = '*';
        
        $articleid = 0;

        try 
        {
            $db = Factory::getDbo();
            $db->insertObject('#__content', $articleObject);
            $articleid = $db->insertid();
        }
        catch (Exception $e)
        {
            $app->setHeader('status', 500, true);
            $app->sendHeaders();
            echo $e->getMessage();
            $app->close();
        }
        
        echo new JsonResponse($articleid);
        $app->close();
    }
}