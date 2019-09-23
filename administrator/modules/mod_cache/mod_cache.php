<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_cache
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Component\Cache\Administrator\Model\CacheModel;
use Joomla\Component\Cache\Administrator\Controller\DisplayController;
//use Joomla\Module\Content\Administrator\Helper\ModCacheHelper;

//includes js and css
$doc        = JFactory::getDocument();
$doc->addScript(JURI::root(true) . '/administrator/modules/' . $module->module . '/assets/js/mod_cache.js');

//HTMLHelper::_('script', 'mod_draft_article/draftarticle.min.js', ['version' => 'auto', 'relative' => true]);

require_once __DIR__ . '/helper.php';

$cache_model = new CacheModel;
$total_cache = $cache_model->getTotal();

// $cacheController = new DisplayController;
$cacheSize   = ModCacheHelper::getCacheSize();

echo $cacheSize['sronly'];

echo '<xmp>';
//print_r(get_class_methods($cache_controller));
print_r($cacheSize);
echo '</xmp>';

// echo '<pre>';
// print_r(get_class_methods($cache_model));
// echo '</pre>';
//die();


// echo '<xmp>';
// print_r($controller);
// echo '</xmp>';
//$controller->execute('task');

require ModuleHelper::getLayoutPath('mod_cache', $params->get('layout', 'default'));
