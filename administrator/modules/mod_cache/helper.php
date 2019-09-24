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
 use Joomla\CMS\Response\JsonResponse;

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
            $data['size']     	= static::getCacheSize();
            $data['status']     = true;
            $data['messsage']   = Text::_('MOD_CACHE_MSG_ALL_CACHE_GROUPS_CLEARED');
		}
		else
		{
			$data['size'] 		= 0;
            $data['messsage']   = Text::_('MOD_CACHE_MSG_SOME_CACHE_GROUPS_CLEARED');
            $data['status']     = true;
        }
        
        echo new JsonResponse($data);
		$app->close();
    }
    
    public static function getCacheSize() 
    {
        $cache_model = new CacheModel;
		$data = $cache_model->getData();
		$size = 0;
		$result = array();

		if (!empty($data))
		{
			foreach ($data as $d)
			{
				$size += $d->size;
			}
		}

		// Number bytes are returned in format xxx.xx MB
        $bytes = HTMLHelper::_('number.bytes', $size, 'kB', 1);
		if (!empty($bytes))
		{
			$sizeExplode = explode(' ', $bytes);
			$result['raw'] = $bytes;
			$result['size'] = $sizeExplode[0];
			$result['unit'] = $sizeExplode[1];
		}
		else
		{
			$result['raw'] = 0;
			$result['size'] = 0;
			$result['unit'] = null;
        }
        
        return $result;
    }
}