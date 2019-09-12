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
<?php if ($post->tags) { ?>
<div class="eb-tags d-flex">
	<div class="mr-3">
		<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
			<g fill-rule="nonzero">
				<path d="M23.292 3.829l-1.064-1.063 1.225-1.225a.703.703 0 1 0-.995-.994l-1.224 1.224L20.171.708a2.431 2.431 0 0 0-2.07-.682l-4.405.66c-.51.076-.992.319-1.357.684L.71 13a2.426 2.426 0 0 0-.001 3.426l6.866 6.866A2.412 2.412 0 0 0 9.285 24c.621 0 1.243-.237 1.716-.71l11.63-11.63c.364-.364.607-.846.683-1.356l.66-4.405a2.43 2.43 0 0 0-.682-2.07zm-.71 1.862l-.658 4.405a1.027 1.027 0 0 1-.288.57l-11.63 11.63a1.013 1.013 0 0 1-.72.299c-.272 0-.526-.106-.718-.297l-6.866-6.866a1.014 1.014 0 0 1 .002-1.438l11.63-11.63c.153-.153.356-.256.57-.288l4.405-.659a1.02 1.02 0 0 1 .868.286l1.063 1.063-1.154 1.154a2.157 2.157 0 0 0-.95-.22 2.15 2.15 0 0 0-1.531.635 2.166 2.166 0 0 0 1.53 3.694 2.15 2.15 0 0 0 1.53-.634 2.15 2.15 0 0 0 .634-1.53c0-.335-.076-.658-.219-.95l1.154-1.155 1.063 1.063c.226.227.333.551.286.868zm-3.69.174a.752.752 0 0 1-.221.535.753.753 0 0 1-.536.222.759.759 0 1 1 .536-1.293.753.753 0 0 1 .222.536z"/>
				<path d="M8.613 10.704a.703.703 0 0 0-.994 0l-3.237 3.237a.703.703 0 0 0 .995.994l3.236-3.237a.703.703 0 0 0 0-.994zM13.57 10.429a.703.703 0 0 0-.993 0l-5.854 5.853a.703.703 0 1 0 .995.995l5.853-5.854a.703.703 0 0 0 0-.994zM14.918 12.77l-5.854 5.854a.703.703 0 1 0 .995.994l5.853-5.853a.703.703 0 1 0-.994-.995z"/>
			</g>
		</svg>
		<span class="eb-tag-label"><?php echo JText::_('COM_EASYBLOG_POST_TAGGED');?></span>
	</div>
	<div class="eb-tag-list">
		<?php foreach ($post->tags as $tag) { ?>
		<span>
			<a href="<?php echo $tag->getPermalink();?>"><?php echo $tag->getTitle();?></a>
		</span>
		<?php } ?>
	</div>
</div>
<?php } ?>
