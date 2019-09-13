<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2018 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div class="eb-comment<?php echo $comment->depth ? ' is-child' . ' depth-' . $comment->depth : ''; ?><?php echo $comment->isLike ? ' is-like' : '';?><?php echo $comment->isModerated() ? ' is-moderated' : '';?>" data-comment-item data-id="<?php echo $comment->id;?>"
	<?php
		$depth = $comment->depth;

		if ($depth == 1) {
			if ($rtl) {
				echo 'style="margin-right:' . $depth*65 . 'px;"';
			} else {
				echo 'style="margin-left:' . $depth*65 . 'px;"';	
			}
		} else if ($depth > 1) {
			if ($rtl) {
				echo 'style="margin-right:' . ($depth*50 + 15) . 'px;"';
			} else {
				echo 'style="margin-left:' . ($depth*50 + 15) . 'px;"';
			}
		}
	?>>
	<a id="comment-<?php echo $comment->id;?>"></a>
	
	<?php if ($comment->isModerated()) { ?>
	<div class="under-moderation">
		<?php echo JText::_('COM_EASYBLOG_COMMENT_POSTED_UNDER_MODERATION');?>
	</div>
	<?php } ?>

	<div class="row-table align-top">
		<div class="col-cell cell-avatar cell-tight">
			<div class="eb-comment-avatar eb-avatar">
				<?php
					$attr = array(
						'user' => $comment->author,
						'comment' => $comment,
						'size' => 48
					);
				?>
				<?php echo coreHelper::getAvatar($attr); ?>
			</div>
		</div>

		<div class="col-cell cell-content eb-comment-content">

			<div class="eb-comment-head text-muted row-table">
				<div class="col-cell">
					
					<div class="eb-comment-author-name">
						<?php if ($comment->created_by == 0) { ?>
							<?php echo $comment->name;?>
						<?php } else { ?>
							<?php echo $comment->author->getName();?>
						<?php } ?>
					</div>

					<div class="eb-comment-time">
						<?php
							$time = new JDate('now');
							$timestamp = strtotime($comment->created);

							$strTime = array("seconds", "minutes", "hours", "days", "months", "years");
							$length = array("60","60","24","30","12","10");
						
							$currentTime = strtotime($time);
							if($currentTime >= $timestamp) {
								$diff     = strtotime($time)- $timestamp;
								for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
									$diff = $diff / $length[$i];
								}
					
								$diff = round($diff);
								echo $diff . " " . $strTime[$i] . " ago ";
							}
						?>
					</div>
				</div>

				<?php
				if (
						(EB::isSiteAdmin() || $this->acl->get('manage_comment') || ($this->my->id == $comment->created_by && $this->acl->get('edit_comment') ) && !$this->my->guest) ||
						(EB::isSiteAdmin() || ($this->my->id == $comment->created_by && $this->acl->get('delete_comment') ) && !$this->my->guest)
					) {
				?>
				<div class="col-cell text-right">
					<div class="eb-comment-admin dropdown">
						<b class="dropdown-toggle_" data-bp-toggle="dropdown">
							<i class="fa fa-cog"></i>
							<i class="fa fa-caret-down"></i>
						</b>
						<ul class="dropdown-menu">
							<?php if (EB::isSiteAdmin() || $this->acl->get('manage_comment') || ($this->my->id == $comment->created_by && $this->acl->get('edit_comment') ) && !$this->my->guest) { ?>
							<li>
								<a href="javascript:void(0);" data-comment-edit>
									<i class="fa fa-pencil"></i> <?php echo JText::_('COM_EASYBLOG_COMMENTS_EDIT');?>
								</a>
							</li>
							<?php } ?>

							<?php if (EB::isSiteAdmin() || $this->acl->get('manage_comment') || ($this->my->id == $comment->created_by && $this->acl->get('delete_comment') ) && !$this->my->guest) { ?>
							<li>
								<a href="javascript:void(0);" data-comment-delete>
									<i class="fa fa-trash-o"></i> <?php echo JText::_('COM_EASYBLOG_COMMENTS_DELETE');?>
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<?php } ?>
			</div>

			<div data-comment-body>

				<div class="eb-comment-body" data-comment-preview>
					<?php if ($comment->title && $this->config->get('comment_show_title')) { ?>
					<div class="eb-comment-title"><b><?php echo $comment->title;?></b></div>
					<?php } ?>

					<?php echo $comment->comment;?>
				</div>

				<?php if (!$comment->isModerated()) { ?>
				<div class="eb-comment-foot">
					<?php if ($this->config->get('comment_likes')) { ?>
						<span class="eb-comment-heart d-inline-flex" data-eb-provide="tooltip" data-original-title="<?php echo $comment->likesAuthor;?>" data-comment-like-tooltip data-placement="bottom">
							<svg class="eb-heart-icon-line" width="21" height="18" xmlns="http://www.w3.org/2000/svg">
								<path d="M10.105 17.98c-.287 0-.565-.103-.781-.293a234.22 234.22 0 0 0-2.298-1.976l-.004-.003c-2.036-1.736-3.794-3.234-5.017-4.71C.637 9.348 0 7.783 0 6.074 0 4.414.57 2.88 1.603 1.76A5.435 5.435 0 0 1 5.646 0c1.167 0 2.235.369 3.175 1.096.475.367.905.817 1.284 1.34.38-.523.81-.973 1.284-1.34A5.084 5.084 0 0 1 14.565 0c1.56 0 2.996.625 4.042 1.76 1.034 1.121 1.604 2.653 1.604 4.314 0 1.71-.637 3.274-2.005 4.924-1.223 1.476-2.981 2.974-5.017 4.71-.696.592-1.484 1.264-2.303 1.98a1.186 1.186 0 0 1-.78.293zM5.646 1.185c-1.226 0-2.353.49-3.172 1.378-.832.902-1.29 2.15-1.29 3.512 0 1.437.534 2.723 1.732 4.168 1.158 1.398 2.88 2.865 4.874 4.565l.004.003c.697.594 1.487 1.267 2.31 1.987.827-.721 1.618-1.396 2.317-1.99 1.994-1.7 3.716-3.167 4.874-4.565 1.197-1.445 1.732-2.73 1.732-4.168 0-1.363-.458-2.61-1.29-3.512a4.263 4.263 0 0 0-3.172-1.378c-.899 0-1.723.285-2.452.849-.649.502-1.1 1.136-1.366 1.58a.741.741 0 0 1-.642.365.741.741 0 0 1-.642-.365c-.265-.444-.717-1.078-1.366-1.58a3.926 3.926 0 0 0-2.451-.85z" fill-rule="nonzero"/>
							</svg>
							<svg class="eb-heart-icon-fill" width="22" height="18" xmlns="http://www.w3.org/2000/svg">
								<path d="M10.776 3.003a5.969 5.969 0 0 1 1.472-1.763c2.217-1.8 5.649-1.623 7.647.415 1.588 1.618 1.98 3.54 1.364 5.686-.475 1.66-1.379 3.091-2.476 4.406-1.777 2.125-3.938 3.802-6.272 5.274-.517.326-1.046.635-1.575.939-.079.044-.222.056-.295.014-2.683-1.522-5.192-3.28-7.294-5.558C2.087 11.05 1.044 9.542.421 7.777-.096 6.313-.194 4.84.453 3.395 1.295 1.517 2.764.367 4.803.083c2.564-.356 4.553.613 5.906 2.832.015.022.03.04.067.088z" fill-rule="nonzero"/>
							</svg>
							<span class="ml-2 text-medium" data-comment-like-counter><?php echo $comment->likesCount;?></span>
						</span>

						<?php if (!$this->my->guest) { ?>
							<span class="eb-comment-likes">
								<a href="javascript:void(0);" class="like-comment" data-comment-like><?php echo JText::_('COM_EASYBLOG_COMMENTS_LIKE');?></a>
								<a href="javascript:void(0);" class="unlike-comment" data-comment-unlike><?php echo JText::_('COM_EASYBLOG_COMMENTS_UNLIKE');?></a>
							</span>
						<?php } ?>
					<?php } ?>

					<?php if ((($this->acl->get('allow_comment') && !$this->my->guest) || ($this->acl->get('allow_comment') && $this->my->guest)) && (($comment->depth + 1) < $this->config->get('comment_maxthreadedlevel'))) { ?>
						<span class="eb-comment-reply">
							<a href="javascript:void(0);" class="hide" data-comment-reply-cancel>
								<?php echo JText::_('COM_EASYBLOG_COMMENTS_CANCEL');?>
							</a>
							<a href="javascript:void(0);" class="d-inline-flex" data-comment-reply data-depth="<?php echo $comment->depth + 1;?>">
								<svg width="24" height="18" xmlns="http://www.w3.org/2000/svg">
									<path d="M11 5.008V1.5C11 .673 10.327 0 9.5 0c-.372 0-.731.143-1.01.401L7.845 1C5.72 2.964 2.165 6.253.345 8.078.124 8.302 0 8.629 0 9c0 .37.123.698.346.923C2.166 11.747 5.72 15.036 7.845 17l.645.598c.279.258.638.401 1.01.401.827 0 1.5-.673 1.5-1.5v-3.497c7.2.101 12 2.372 12 4.497a.5.5 0 1 0 1 0c0-6.738-5.786-12.248-13-12.492zM10.5 12a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-.5.5.484.484 0 0 1-.33-.135l-.646-.597c-2.119-1.96-5.665-5.241-7.47-7.05C1.028 9.19 1 9.111 1 9s.027-.19.055-.217c1.804-1.81 5.35-5.09 7.47-7.05l.645-.598A.484.484 0 0 1 9.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5c6.012 0 11.046 3.925 12.234 9.135C20.601 13.266 15.98 12 10.5 12z" fill="#FFAB10" fill-rule="nonzero"/>
								</svg>
								<span class="ml-2"><?php echo JText::_('COM_EASYBLOG_COMMENTS_REPLY');?></span>
							</a>
						</span>
					<?php } ?>
				</div>
				<?php } ?>
			</div>

			<div class="eb-comment-editor form-group hide mt-15" data-comment-edit-editor>
				<div class="eb-comment-notice" data-edit-comment-notice></div>

				<?php if ($this->config->get('comment_requiretitle') || $this->config->get('comment_show_title')) { ?>
				<div class="form-group">
					<input type="text" class="form-control" name="title" id="title" value="<?php echo $comment->title; ?>" placeholder="<?php echo JText::_('COM_EASYBLOG_COMMENTS_TITLE_PLACEHOLDER', true); ?>" data-comment-title-edit/>
				</div>
				<?php } else { ?>
					<input type="hidden" id="title" name="title" value="" data-comment-title-edit/>
				<?php } ?>

				<textarea class="form-control textarea" rows="3" data-comment-edit-textarea data-comment-bbcode="<?php echo $this->config->get('comment_bbcode'); ?>"><?php echo $comment->raw;?></textarea>
				<div class="hide" data-comment-edit-raw><?php echo $comment->raw;?></div>
				<div class="eb-comment-editor-actions text-right mt-10">
					<a href="javascript:void(0);" class="btn btn-default btn-sm" data-comment-edit-cancel><?php echo JText::_('COM_EASYBLOG_CANCEL_BUTTON'); ?></a>
					<a href="javascript:void(0);" class="btn btn-primary btn-sm" data-comment-edit-update><?php echo JText::_('COM_EASYBLOG_UPDATE_COMMENT_BUTTON'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
