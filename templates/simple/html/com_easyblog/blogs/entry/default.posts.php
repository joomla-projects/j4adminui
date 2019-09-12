<?php
/**
* @package      EasyBlog
* @copyright    Copyright (C) 2010 - 2019 Stack Ideas Sdn Bhd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div data-eb-post-section data-url="<?php echo $post->getExternalPermalink(); ?>" data-page-title="<?php echo $this->html('string.escape', $post->getPagePostTitle()); ?>" data-permalink="<?php echo $post->getPermalink(); ?>" data-post-title="<?php echo $this->html('string.escape', $post->getTitle()); ?>">
	<div class="eb-adsense-head clearfix">
		<?php echo $adsense->header;?>
	</div>

	<div data-blog-post>

		<?php if ($this->config->get('main_show_reading_progress')) { ?>
		<div class="eb-reading-progress-sticky hide" data-eb-spy="affix" data-offset-top="240">
			<progress value="0" max="100" class="eb-reading-progress" data-blog-reading-progress style="<?php echo 'top:' . $this->config->get('main_reading_progress_offset') . 'px'; ?>">
				<div class="eb-reading-progress__container">
					<span class="eb-reading-progress__bar"></span>
				</div>
			</progress>
		</div>
		<?php } ?>

		<div id="entry-<?php echo $post->id; ?>" class="eb-entry fd-cf" data-blog-posts-item data-id="<?php echo $post->id;?>" data-uid="<?php echo $post->getUid();?>">

			<div data-blog-reading-container>
				<?php if (!$preview && $post->isPending() && $post->canModerate()) { ?>
					<?php echo $this->output('site/blogs/entry/moderate'); ?>
				<?php } ?>

				<?php if ($post->isUnpublished()) { ?>
					<?php echo $this->output('site/blogs/entry/entry.unpublished'); ?>
				<?php } ?>

				<?php
				if ($preview) {
					if (!$post->canModerate() && $post->isPending()) {
						echo $this->output('site/blogs/entry/preview.pending.approval');
					} else if ($post->isPostPublished()) {
						echo $this->output('site/blogs/entry/preview.revision');
					} else {
						echo $this->output('site/blogs/entry/preview.unpublished');
					}
				}
				?>

				<?php echo $this->output('site/blogs/admin.tools', array('post' => $post, 'return' => $post->getPermalink(false))); // admin tools ?>

				<?php echo $this->renderModule('easyblog-before-entry'); ?>

				<div class="d-none d-md-flex eb-post-top-meta align-items-center">
					<?php if ($post->isFeatured) { ?>
						<div class="eb-post-featured">
							<?php echo JText::_('COM_EASYBLOG_FEATURED_FEATURED');?>
						</div>
					<?php } ?>

					<?php if ($this->entryParams->get('show_reading_time')) { ?>
						<div class="eb-reading-indicator d-inline-flex align-items-center">
							<svg width="18" height="18" xmlns="http://www.w3.org/2000/svg">
								<g fill-rule="nonzero">
									<path d="M13.573 8.647h-4.01V3.826a.735.735 0 0 0-1.47 0v5.556c0 .406.33.735.735.735h4.745a.735.735 0 0 0 0-1.47z"/>
									<path d="M8.923 0C4.003 0 0 4.003 0 8.923s4.003 8.923 8.923 8.923 8.923-4.003 8.923-8.923S13.843 0 8.923 0zm0 15.947a7.032 7.032 0 0 1-7.025-7.024 7.032 7.032 0 0 1 7.025-7.024 7.032 7.032 0 0 1 7.024 7.024 7.032 7.032 0 0 1-7.024 7.024z"/>
								</g>
							</svg>
							<span class="eb-reading-indicator-info ml-2"><?php echo $post->getReadingTime(); ?> (<?php echo JText::sprintf('COM_EB_TOTAL_WORDS', $post->getTotalWords()); ?>)</span>
						</div>
					<?php } ?>
				</div>

				<div class="eb-entry-head">
					<h1 id="title-<?php echo $post->id; ?>" class="eb-entry-title">
						<?php echo $post->title; ?>
					</h1>

					<?php echo $post->event->afterDisplayTitle; ?>

					<div class="eb-entry-meta">
						<?php if ($this->entryParams->get('post_author', true)) { ?>
							<div class="eb-meta-author d-inline-flex align-items-center">
								<a href="<?php echo $post->getAuthorPermalink();?>" rel="author" class="eb-avatar">
									<img src="<?php echo $post->getAuthor()->getAvatar(); ?>" width="50" height="50" alt="<?php echo $post->getAuthorName();?>" />
								</a>
								<span>
									<a href="<?php echo $post->getAuthorPermalink();?>" rel="author"><?php echo $post->getAuthorName();?></a>
								</span>
							</div>
						<?php } ?>

						<?php if ($this->entryParams->get('post_date', true)) { ?>
							<div class="eb-entry-date">
								<time class="eb-meta-date" datetime="<?php echo $post->getCreationDate($this->entryParams->get('post_date_source', 'created'))->format(JText::_('DATE_FORMAT_LC4'));?>">
									<?php echo $post->getDisplayDate($this->entryParams->get('post_date_source', 'created'))->format(JText::_('DATE_FORMAT_LC3')); ?>
								</time>
							</div>
						<?php } ?>
						
						<?php if ($this->entryParams->get('post_category', true)) { ?>
							<div class="eb-meta-category d-inline-flex">
								<span class="d-none d-md-inline mr-2">Category:</span> 
								<div class="comma-seperator">
									<?php foreach ($post->categories as $cat) { ?>
										<span><a href="<?php echo $cat->getPermalink();?>"><?php echo $cat->getTitle();?></a></span>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

				<div class="eb-entry-body type-<?php echo $post->posttype; ?> clearfix">
					
					<div class="eb-entry-tools">
						<?php echo $this->output('site/blogs/entry/social', array('return' => $post->getPermalink(false))); ?>
						<?php echo $this->output('site/blogs/entry/fontsize'); ?>
					</div>

					<div class="eb-entry-article clearfix" data-blog-content>

						<?php echo $post->event->beforeDisplayContent; ?>

						<?php echo EB::renderModule('easyblog-before-content'); ?>

						<?php if (in_array($post->posttype, array('photo', 'standard', 'twitter', 'email', 'link', 'video'))) { ?>
							<?php echo $this->output('site/blogs/entry/post.cover', array('post' => $post)); ?>

							<?php if(!empty($post->toc)){ echo $post->toc; } ?>

							<!--LINK TYPE FOR ENTRY VIEW-->
							<?php if ($post->getType() == 'link') { ?>
								<div class="eb-post-headline">
									<div class="eb-post-headline-source">
										<a href="<?php echo $post->getAsset('link')->getValue(); ?>" target="_blank"><?php echo $post->getAsset('link')->getValue();?></a>
									</div>
								</div>
							<?php } ?>

							<?php echo $content; ?>
						<?php } else { ?>
							<?php if(!empty($post->toc)){ echo $post->toc; } ?>
						<?php } ?>

						<?php echo $this->renderModule('easyblog-after-content'); ?>

						<?php if ($post->fields && $this->entryParams->get('post_fields', true)) { ?>
							<?php echo $this->output('site/blogs/entry/fields', array('fields' => $post->fields)); ?>
						<?php } ?>
					</div>

					<?php if ($this->entryParams->get('post_social_buttons', true)) { ?>
						<?php echo EB::socialbuttons()->html($post, 'entry'); ?>
					<?php } ?>

					<?php echo $this->output('site/blogs/entry/location', array('post' => $post)); ?>

					<?php echo $this->output('site/blogs/entry/copyright', array('post' => $post)); ?>

					<?php if (!$preview && $this->config->get('main_ratings') && $this->entryParams->get('post_ratings', true)) { ?>
					<div class="eb-entry-ratings">
						<?php echo $this->output('site/ratings/frontpage', array('post' => $post)); ?>
					</div>
					<?php } ?>

					<?php if (!$preview) { ?>
						<?php echo EB::emotify()->html($post); ?>
					<?php } ?>

				</div>
			</div>
			
			<?php echo $this->output('site/blogs/entry/navigation'); ?>
			
			<?php if ($this->entryParams->get('post_tags', true) && count($post->tags)) { ?>
				<div class="eb-entry-tags">
					<?php echo $this->output('site/blogs/tags/item', array('tags' => $post->tags)); ?>
				</div>
			<?php } ?>

			<div class="eb-post-details-ad2">
				<?php echo EB::renderModule('ad2'); ?>
			</div>

			<?php if ($this->config->get('reactions_enabled') && $this->entryParams->get('post_reactions', true)) { ?>
				<?php echo EB::reactions($post)->html();?>
			<?php } ?>

			<?php if ($this->entryParams->get('post_author_box', true) && !$post->hasAuthorAlias()) { ?>
				<?php echo $this->output('site/blogs/entry/author', array('post' => $post)); ?>
			<?php } ?>
		</div>

		<?php echo $adsense->beforecomments; ?>

		<?php echo $post->event->afterDisplayContent; ?>

		<?php if (!$preview && $this->config->get('main_comment') && $post->allowcomment && $this->entryParams->get('post_comment_form', true)) { ?>
			<a class="eb-anchor-link" name="comments" id="comments">&nbsp;</a>
			<?php echo EB::comment()->getCommentHTML($post);?>
		<?php } ?>

		<?php if ($this->entryParams->get('post_related', true) && $relatedPosts) { ?>
			<div class="eb-related-items">
				<h3 class="mb-3">You may also like</h3>
				<?php foreach ($relatedPosts as $related) { ?>
				<div class="eb-related-item">
					<?php if ($this->entryParams->get('post_related_image', true)) { ?>
						<a class="eb-related-thumbnail" href="<?php echo $related->getPermalink();?>">
							<img src="<?php echo $related->postimage;?>" alt="">
						</a>
					<?php } ?>

					<div class="eb-related-body">
						<h3 class="eb-related-title">
							<a href="<?php echo $related->getPermalink();?>"><?php echo $related->title;?></a>
						</h3>
						<div class="eb-related-content">
							<?php echo($related->intro); ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>

	<div class="eb-adsense-foot clearfix">
		<?php echo $adsense->footer;?>
	</div>
</div>

<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"mainEntityOfPage": "<?php echo $post->getPermalink(true, true); ?>",
		"@type": "BlogPosting",
		"headline": "<?php echo $this->html('string.escape', $post->getTitle());?>",
		"image": "<?php echo $post->getImage($this->config->get('cover_size_entry', 'large'), true, true);?>",
		"editor": "<?php echo $post->getAuthor()->getName();?>",
		"genre": "<?php echo $post->getPrimaryCategory()->title;?>",
		"wordcount": "<?php echo $post->getTotalWords();?>",
		"publisher": {
			"@type": "Organization",
			"name": "<?php echo EB::showSiteName(); ?>",
			"logo": <?php echo $post->getSchemaLogo(); ?>
		},
		"datePublished": "<?php echo $post->getPublishDate(true)->format('Y-m-d');?>",
		"dateCreated": "<?php echo $post->getCreationDate(true)->format('Y-m-d');?>",
		"dateModified": "<?php echo $post->getModifiedDate()->format('Y-m-d');?>",
		"description": "<?php echo EB::jconfig()->get('MetaDesc'); ?>",
		"articleBody": "<?php echo htmlentities($schemaContent, ENT_QUOTES);?>",
		"author": {
			"@type": "Person",
			"name": "<?php echo $post->getAuthor()->getName();?>",
			"image": "<?php echo $post->creator->getAvatar();?>"
		}<?php if (!$preview && $this->config->get('main_ratings') && $this->entryParams->get('post_ratings', true) && $ratings->total > 0) { ?>,
			"aggregateRating": {
				"@type": "http://schema.org/AggregateRating",
				"ratingValue": "<?php echo round($ratings->ratings / 2, 2); ?>",
				"worstRating": "1",
				"bestRating": "5",
				"ratingCount": "<?php echo $ratings->total; ?>"
			}
		<?php } ?>
	}
</script>

<?php if ($prevId) { ?>
<hr class="eb-hr" />
<?php } ?>