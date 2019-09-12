<?php
/**
* @package    EasyBlog
* @copyright  Copyright (C) 2010 - 2017 Stack Ideas Sdn Bhd. All rights reserved.
* @license    GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
$input = JFactory::getApplication()->input;

$option = $input->get('option');
$view = $input->get('view');
?>
<div class="eb-mod mod_easyblogcategories <?php echo $modules->getWrapperClass();?>" data-eb-module-categories>
	<ul>
		<?php foreach($categories as $category) : ?>
			<?php
			$cssClass = "";
			if( $option == 'com_easyblog' && $view == 'categories' ) {
				$cId = (int) $input->get('id');
				if($category->id == $cId) {
					$cssClass = 'active';
				}
			}
			?>
			<li class="<?php echo $cssClass; ?>">
				<a href="<?php echo $category->getPermalink();?>"><?php echo JText::_($category->title); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
