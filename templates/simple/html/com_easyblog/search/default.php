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
$theme_url = JURI::root() . 'templates/' . JFactory::getApplication()->getTemplate();
?>
<?php if ($query) { ?>
	<div class="form-control-static">
		<?php if (!$posts) { ?>
			<div class="row d-flex align-items-center">
				<div class="col-md-5">
					<img src="<?php echo $theme_url . '/images/empty-result.png'; ?>"  srcset="<?php echo $theme_url . '/images/empty-result@2x.png 2x'; ?>" alt="Nothing found">
				</div>

				<div class="col-md-6 mt-4 mt-mb-0">
					<h1>Nothing Found</h1>
					<p>Sorry, but nothing matched your search terms "<strong><?php echo $query; ?></strong>". Please try again with some different keywords.</p>
					<form action="<?php echo JRoute::_('index.php');?>" class="eb-search-form-no-post" method="post">
						<div class="input-group">
							<input type="text" class="form-control form-control-lg" name="query" value="<?php echo $this->html('string.escape', $query);?>" placeholder="Search" />
							<div class="input-group-btn">
								<button class="btn btn-search btn-lg" type="submit">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
						<?php echo $this->html('form.action', 'search.query'); ?>
					</form>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<form action="<?php echo JRoute::_('index.php');?>" method="post">
		<div class="input-group">
			<input type="text" class="form-control form-control-lg" name="query" value="<?php echo $this->html('string.escape', $query);?>" placeholder="Search" />
			<div class="input-group-btn">
				<button class="btn btn-search btn-lg" type="submit">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>
		<?php echo $this->html('form.action', 'search.query'); ?>
	</form>
<?php } ?>

<?php if ($posts) { ?>
	
	<?php if ($query) { ?>
		<div class="eb-search-string">
			<h1><?php echo JText::sprintf('COM_EASYBLOG_SEARCH_RESULTS_TOTAL_RESULT', $pagination->get('pages.current'), $pagination->get('pages.total'), $pagination->get('total'), $query); ?></h1>
		</div>
	<?php } ?>

	<form action="<?php echo JRoute::_('index.php');?>" class="eb-search-form-has-posts" method="post">
		<div class="input-group">
			<input type="text" class="form-control form-control-lg" name="query" value="<?php echo $this->html('string.escape', $query);?>" placeholder="Search" />
			<div class="input-group-btn">
				<button class="btn btn-search btn-lg" type="submit">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>
		<?php echo $this->html('form.action', 'search.query'); ?>
	</form>

	<div class="eb-posts eb-posts-search">
		<?php foreach ($posts as $post) { ?>
			<div class="eb-post" data-blog-posts-item data-id="<?php echo $post->id;?>">
				<div class="eb-post-content">
					<div class="eb-post-head no-overflow">
						<?php echo $this->output('site/blogs/latest/post.cover', array('post' => $post)); ?>

						<div class="eb-post-body type-<?php echo $post->posttype; ?>">
							<h2 class="eb-post-title reset-heading">
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
			</div>
		<?php } ?>
	</div>

	<div class="eb-pagination">
		<div>
			<?php echo $pagination->getPagesLinks();?>
		</div>
	</div>
<?php } ?>
