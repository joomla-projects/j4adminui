<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2019 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div class="eb-post" data-blog-posts-item data-id="<?php echo $post->id;?>">
	<div class="eb-post-content">
		<div class="eb-post-head no-overflow">
			<?php echo $this->output('site/blogs/latest/post.cover', array('post' => $post)); ?>

			<div class="eb-post-body">
				<h2 class="eb-post-title">
					<a href="<?php echo $post->getPermalink();?>" class="text-inherit"><?php echo $post->title;?></a>
				</h2>

				<div class="eb-post-intro">
					<?php echo $post->getIntro();?>
				</div>
				<div class="eb-post-more">
					<a href="<?php echo $post->getPermalink();?>"><?php echo JText::_('COM_EASYBLOG_CONTINUE_READING');?></a>
				</div>
			</div>
		</div>
	</div>

	<?php echo $this->output('site/blogs/post.schema', array('post' => $post)); ?>
</div>
