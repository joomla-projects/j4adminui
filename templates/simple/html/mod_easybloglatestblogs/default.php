<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2017 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div class="eb-mod eb-mod-recent-posts<?php echo $modules->getWrapperClass();?>" data-eb-module-latest>

	<?php if ($posts) { ?>
	<div class="eb-mod-recent-post-list">
		<?php $column = 1; ?>

		<?php $key = 1; ?>
		<?php foreach ($posts as $post) { ?>
			<?php require(JModuleHelper::getLayoutPath('mod_easybloglatestblogs', 'default_' . $layout)); ?>
			
			<?php if($key == 2) : ?>
				<?php echo JHtml::_('content.prepare', '{loadposition ad2}'); ?>
			<?php endif; ?>

			<?php $key++; ?>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if ($params->get('allentrieslink', false)) { ?>
	<div class="eb-load-more">
		<a href="<?php echo $helper->getViewAllLink($filterType); ?>">
			View All Posts 
			<svg width="18" height="12" xmlns="http://www.w3.org/2000/svg">
				<path d="M0 7h14.17l-3.58 3.59L12 12l6-6-6-6-1.41 1.41L14.17 5H0z" fill-rule="evenodd"/>
			</svg>
		</a>
	</div>
	<?php } ?>
</div>