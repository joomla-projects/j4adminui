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
<?php if (($post->image || (!$post->image && $this->entryParams->get('post_image_placeholder', false))) && $this->entryParams->get('post_image', true)) { ?>

	<div class="eb-image eb-post-thumb<?php echo $this->config->get('cover_width_entry_full') ? " is-full" : " is-" . $this->config->get('cover_alignment_entry')?>" data-eb-entry-cover>
		<?php if (!$this->config->get('cover_crop_entry', false)) { ?>
			<a class="eb-post-image eb-image-popup-button"
				href="<?php echo $post->getImage('original', true, false, false);?>"
				title="<?php echo $this->escape($post->getImageTitle());?>"
				caption="<?php echo $this->escape($post->getImageCaption());?>"
				target="_blank"
				style="
					<?php if ($this->config->get('cover_width_entry_full')) { ?>
					width: 100%;
					<?php } else { ?>
					width: <?php echo $this->config->get('cover_width_entry') ? $this->config->get('cover_width_entry') : '260';?>px;
					<?php } ?>"
			>
				<img src="<?php echo $post->getImage($this->config->get('cover_size_entry', 'large'), true, false, false);?>" alt="<?php echo $this->escape($post->getImageTitle());?>" />
				<meta content="<?php echo $post->getImage($this->config->get('cover_size_entry', 'large'), true, true, false);?>" alt="<?php echo $this->escape($post->getImageTitle());?>"/>

				<?php if ($post->getImageCaption()) { ?>
					<span class="eb-post-thumb-caption"><?php echo $post->getImageCaption(); ?></span>
				<?php } ?>
			</a>
		<?php } ?>

		<?php if ($this->config->get('cover_crop_entry', false)) { ?>
			<a class="eb-post-image-cover eb-image-popup-button"
				href="<?php echo $post->getImage('original', true, false, false);?>"
				title="<?php echo $this->escape($post->getImageTitle());?>"
				caption="<?php echo $this->escape($post->getImageCaption());?>"
				target="_blank"
				style="
					display: inline-block;
					background-image: url('<?php echo $post->getImage($this->config->get('cover_size_entry', 'large'), true, true, false);?>');
					<?php if ($this->config->get('cover_width_entry_full')) { ?>
					width: 100%;
					<?php } else { ?>
					width: <?php echo $this->config->get('cover_width_entry') ? $this->config->get('cover_width_entry') : '260';?>px;
					<?php } ?>
					height: <?php echo $this->config->get('cover_height_entry') ? $this->config->get('cover_height_entry') : '200';?>px;"
			></a>

			<img class="hide" src="<?php echo $post->getImage($this->config->get('cover_size', 'large'), true, false, $this->config->get('cover_firstimage', 0));?>" alt="<?php echo $this->escape($post->getImageTitle());?>" />

			<?php if ($post->getImageCaption()) { ?>
				<span class="eb-post-thumb-caption"><?php echo $post->getImageCaption(); ?></span>
			<?php } ?>

		<?php } ?>
	</div>
<?php } ?>
