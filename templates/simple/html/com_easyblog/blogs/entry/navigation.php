<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2014 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<?php if ((!empty($navigation->prev) || !empty($navigation->next)) && $this->entryParams->get('post_navigation', true)) { ?>
<div class="eb-entry-nav fd-cf d-none d-md-block">
	<?php if (!empty($navigation->next)) { ?>
	<div class="eb-entry-nav-prev">
		<a href="<?php echo $navigation->next->link;?>"> 
			<svg width="19" height="13" xmlns="http://www.w3.org/2000/svg">
				<path d="M6.102 12.43a.628.628 0 0 0 .897 0 .633.633 0 0 0 0-.887L2.45 6.995H17.46c.35-.001.628-.28.628-.629a.632.632 0 0 0-.628-.637H2.45L7 1.189a.644.644 0 0 0 0-.897.628.628 0 0 0-.897 0L.476 5.917a.618.618 0 0 0 0 .888l5.626 5.626z" fill-rule="nonzero"/>
			</svg>
			Previous Post
			<span><?php echo $navigation->next->title;?></span>
		</a>
	</div>
	<?php } ?>

	<?php if (!empty($navigation->prev)) { ?>
	<div class="eb-entry-nav-next">
		<a href="<?php echo $navigation->prev->link;?>">
			Next Post
			<svg width="18" height="13" xmlns="http://www.w3.org/2000/svg">
				<path d="M11.985.188a.628.628 0 0 0-.897 0 .633.633 0 0 0 0 .888l4.549 4.548H.628A.625.625 0 0 0 0 6.253c0 .35.278.637.628.637h15.009l-4.549 4.54a.644.644 0 0 0 0 .897.628.628 0 0 0 .897 0l5.625-5.625a.618.618 0 0 0 0-.888L11.985.188z" fill-rule="nonzero"/>
			</svg>
			<span><?php echo $navigation->prev->title;?></span>
		</a>
	</div>
	<?php } ?>
</div>
<?php } ?>