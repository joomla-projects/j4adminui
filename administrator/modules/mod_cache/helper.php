<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_cache
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_JEXEC') or die;

 use Joomla\Component\Cache\Administrator\Model\CacheModel;
 use Joomla\CMS\Factory;
 use Joomla\CMS\HTML\HTMLHelper;
 use Joomla\CMS\Language\Text;

/**
 * mod_cache_helper helper class for the module
 * 
 */
class ModCacheHelper
{
    public static function clearCacheAjax()
	{

        $data = array();
        $data['status'] = false;

        // load cache model
        $cache_model = new CacheModel;

        //echo json_encode(get_class_methods($cache_model));

        $app = Factory::getApplication();
		$allCleared = true;

        $mCache = $cache_model->getCache();

		foreach ($mCache->getAll() as $cache)
		{
			if ($mCache->clean($cache->group) === false)
			{
                $data['messsage']   = Text::sprintf('COM_CACHE_EXPIRED_ITEMS_DELETE_ERROR', Text::_('JADMINISTRATOR') . ' > ' . $cache->group);
				$allCleared         = false;
			}
		}

		if ($allCleared)
		{
            $data['status']     = true;
            $data['messsage']   = Text::_('COM_CACHE_MSG_ALL_CACHE_GROUPS_CLEARED');
		}
		else
		{
            //$data['messsage']   = Text::_('COM_CACHE_MSG_SOME_CACHE_GROUPS_CLEARED');
            $data['status']     = true;
        }
        
        echo json_encode($data);

        // $app->triggerEvent('onAfterPurge', array());
        
		// $app->setHeader('status', 200, true);
        // $app->sendHeaders();
        // echo new JsonResponse($articleid);
		// $app->close();
    }
    
    public static function getCacheSize() 
    {
        $cache_model = new CacheModel;
		$data = $cache_model->getData();
		$size = 0;

		if (!empty($data))
		{
			foreach ($data as $d)
			{
				$size += $d->size;
			}
		}

		// Number bytes are returned in format xxx.xx MB
        $bytes = HTMLHelper::_('number.bytes', $size, 'MB', 1);
        
		if (!empty($bytes))
		{
			$result['amount'] = $bytes;
			$result['sronly'] = Text::sprintf('COM_CACHE_QUICKICON_SRONLY', $bytes);
		}
		else
		{
			$result['amount'] = 0;
			$result['sronly'] = Text::sprintf('COM_CACHE_QUICKICON_SRONLY_NOCACHE');
        }
        
        return $result;
    }
}