<?php
/**
* @package      EasyBlog
* @copyright    Copyright (C) 2010 - 2018 Stack Ideas Sdn Bhd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div class="eb-authors" data-authors>
	<h1 class="eb-page-header">Authors</h1>
	<?php if ($authors) { ?>
		<div class="row">
			<?php foreach ($authors as $author) { ?>
				<div class="col-lg-6">
					<div class="eb-author-card" data-author-item data-id="<?php echo $author->id;?>">
						<div class="d-flex">
							<?php if ($this->config->get('layout_avatar') && $this->params->get('author_avatar', true)) { ?>
								<div class="mr-3">
									<a class="eb-avatar" href="<?php echo $author->getPermalink();?>">
										<img src="<?php echo $author->getAvatar(); ?>" class="eb-authors-avatar" width="50" height="50" alt="<?php echo $author->getName(); ?>" />
									</a>
								</div>
							<?php } ?>

							<div>
								<h2>
									<a href="<?php echo $author->getProfileLink(); ?>"><?php echo $author->getName(); ?></a>
								</h2>
								<div class="eb-authors-subscribe">
									<?php if ($this->acl->get('allow_subscription') && $this->config->get('main_bloggersubscription') && $this->params->get('author_subscribe_email', true)) { ?>
										<span class="eb-authors-subscription">
											<a href="javascript:void(0);" class="<?php echo $author->isBloggerSubscribed ? 'hide' : ''; ?>" data-blog-subscribe data-type="blogger" data-id="<?php echo $author->id;?>"
												data-eb-provide="tooltip" title="<?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_SUBSCRIBE_TO_BLOGGER', true);?>"
											>
												<i class="fa fa-envelope"></i>
											</a>
											<a href="javascript:void(0);" class="<?php echo $author->isBloggerSubscribed ? '' : 'hide'; ?>" 
												data-blog-unsubscribe 
												data-type="blogger" 
												data-id="<?php echo $author->id;?>" 
												data-subscription-id="<?php echo $author->isBloggerSubscribed ? $author->isBloggerSubscribed : '';?>"
												data-email="<?php echo $this->my->email;?>"
												data-eb-provide="tooltip" data-title="<?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_UNSUBSCRIBE_TO_BLOGGER', true);?>"
											>
												<i class="fa fa-envelope"></i>
											</a>
										</span>
										<?php } ?>

										<?php if ($this->acl->get('allow_subscription_rss') && $this->config->get('main_rss') && $this->params->get('author_subscribe_rss', true)) { ?>
										<span class="eb-authors-rss">
											<a href="<?php echo $author->getRSS();?>" data-eb-provide="tooltip" title="<?php echo JText::_('COM_EASYBLOG_SUBSCRIBE_FEEDS'); ?>">
												<i class="fa fa-rss"></i>
											</a>
										</span>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<div class="eb-empty">
			<i class="fa fa-users"></i>
			<?php echo JText::_('COM_EASYBLOG_NO_AUTHORS_CURRENTLY'); ?>
		</div>
	<?php } ?>

	<?php if ($pagination) { ?>
	<div class="eb-pagination clearfix">
		<?php echo $pagination; ?>
	</div>
	<?php } ?>
</div>
