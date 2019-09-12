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
<div class="eb-comments" data-eb-comments>

	<div class="d-flex eb-section-comments">
		<svg width="26" height="22" xmlns="http://www.w3.org/2000/svg">
			<g fill="#000" fill-rule="nonzero">
				<path d="M22.05 8.98a.5.5 0 1 0 0 .998.5.5 0 0 0 0-.998zM13.769 3.99a.5.5 0 1 0 0-.997.5.5 0 0 0 0 .998z"/>
				<path d="M24.045 5.986h-6.784v-4.49C17.26.672 16.589 0 15.764 0H1.497C.67 0 0 .671 0 1.497v9.977c0 .825.671 1.497 1.497 1.497h1.496v2.494a.5.5 0 0 0 .852.353l2.847-2.847h1.59v4.49c0 .825.67 1.496 1.496 1.496h9.072l2.847 2.847a.5.5 0 0 0 .852-.353v-2.494h1.496c.826 0 1.497-.671 1.497-1.497V7.483c0-.825-.671-1.497-1.497-1.497zm-20.553.998h4.875a1.491 1.491 0 0 0-.086.498V8.98H3.492a.499.499 0 1 0 0 .997h4.79v1.996H6.484a.499.499 0 0 0-.352.146L3.99 14.26v-1.788a.499.499 0 0 0-.499-.5H1.497a.5.5 0 0 1-.5-.498V1.497a.5.5 0 0 1 .5-.5h14.267a.5.5 0 0 1 .499.5v4.49H3.493a.499.499 0 1 0 0 .997zM24.544 17.46a.5.5 0 0 1-.499.5H22.05a.499.499 0 0 0-.499.498v1.789l-2.142-2.142a.499.499 0 0 0-.352-.146h-9.28a.5.5 0 0 1-.498-.499V7.483a.5.5 0 0 1 .499-.499h14.267a.5.5 0 0 1 .5.499v9.977z"/>
				<path d="M3.492 3.99h8.281a.499.499 0 1 0 0-.997h-8.28a.499.499 0 1 0 0 .998zM11.773 9.977h8.281a.499.499 0 1 0 0-.997h-8.28a.499.499 0 1 0 0 .997zM22.05 11.973H11.773a.499.499 0 1 0 0 .998H22.05a.499.499 0 1 0 0-.998zM22.05 14.966H11.773a.499.499 0 1 0 0 .998H22.05a.499.499 0 1 0 0-.998z"/>
			</g>
		</svg>
		<span class="ml-2 text-medium">
			Comments
			<?php if ( $blog->totalComments ) { ?>
				(<span data-comment-counter><?php echo $blog->totalComments;?></span>)
			<?php } ?>
		</span>
	</div>

	<?php if ($this->my->guest && $this->config->get('comment_allowlogin') && !$this->acl->get('allow_comment') && $this->config->get('main_allowguestviewcomment')) { ?>
		<div class="eb-composer-author row-table">
			<div class="col-cell">
				<div class="pull-right">
					<?php echo JText::_('COM_EASYBLOG_COMMENTS_ALREADY_REGISTERED');?>
					<a href="<?php echo $loginURL;?>"><?php echo JText::_('COM_EASYBLOG_COMMENTS_ALREADY_REGISTERED_LOGIN_HERE');?></a>
				</div>
			</div>
		</div>
	<?php } ?>
	
	<?php if (!$this->config->get('main_allowguestviewcomment') && !$this->acl->get('allow_comment') && $this->my->guest) { ?>
		<div class="eblog-message info">
			<?php echo JText::sprintf('COM_EASYBLOG_COMMENT_DISABLED_FOR_GUESTS', $loginURL); ?>
		</div>
	<?php } else { ?>
		<?php if ($this->config->get('main_allowguestviewcomment') && $this->my->guest || (!$this->my->guest)) { ?>
			<div class="eb-comment-list" data-comment-list><?php if ($comments) { ?><?php foreach ($comments as $comment) { ?><?php echo $this->output('site/comments/default.item', array('comment' => $comment)); ?><?php } ?><?php } ?></div>
		<?php } ?>
	<?php } ?>

	<?php if($pagination) {?>
		<?php echo $pagination;?>
	<?php } ?>

	<?php if (($this->acl->get('allow_comment') && !$this->my->guest) || ($this->acl->get('allow_comment') && $this->my->guest)) { ?>
		<div data-comment-form-wrapper>
			<?php echo $this->output('site/comments/form'); ?>
		</div>
	<?php } ?>
</div>
