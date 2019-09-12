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
<?php if ($post->image && $this->params->get('post_image', true) || (!$post->image && $post->usePostImage() && $this->params->get('post_image', true))
		|| (!$post->image && !$post->usePostImage() && $this->params->get('post_image_placeholder', false) && $this->params->get('post_image', true))) { ?>

	<div class="eb-post-thumb position-relative">
		<a href="<?php echo $post->getPermalink();?>"
			class="eb-post-image"
			title="<?php echo $this->escape($post->getImageTitle());?>"
			caption="<?php echo $this->escape($post->getImageCaption());?>">
			<img src="<?php echo $post->getImage($this->config->get('cover_size', 'large'), true, true, $this->config->get('cover_firstimage', 0));?>" alt="<?php echo $this->escape($post->getImageTitle());?>" loading="lazy" />

			<?php if ($post->getImageCaption()) { ?>
				<span class="eb-post-thumb-caption"><?php echo $post->getImageCaption(); ?></span>
			<?php } ?>
		</a>

		<?php if($post->isFeatured()): ?>
			<div class="eb-featured-post-icon" data-toggle="tooltip" data-placement="top" title="Featured Item">
				<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg">
					<g fill="none" fill-rule="evenodd">
						<circle fill="#FF2624" cx="15" cy="15" r="15"/>
						<path d="M21.46154 16.538754c-.206192-2.684496-1.456067-4.366758-2.558708-5.851266C17.881824 9.31316 17 8.126355 17 6.375645c0-.140625-.07875-.269157-.203625-.333598-.125262-.064828-.275766-.054211-.389637.028547-1.656 1.184976-3.03771 3.182168-3.52037 5.087777-.335075 1.326691-.379407 2.81816-.38563 3.803203-1.529297-.326637-1.875726-2.614183-1.879383-2.63911-.017226-.118652-.089718-.221905-.195187-.278296-.106559-.055652-.23182-.059695-.339856-.006223-.08019.038813-1.968398.998227-2.078261 4.828887-.0077.127441-.008051.25527-.008051.383063 0 3.721535 3.028184 6.749543 6.75 6.749543.005133.000351.010617.00109.015012 0h.004746C18.482434 23.988785 21.5 20.964856 21.5 17.249895c0-.187137-.03846-.711141-.03846-.711141zM14.75 23.249484c-1.240734 0-2.250011-1.075113-2.250011-2.396671 0-.045036-.00034-.090458.002929-.14611.015012-.557332.120867-.937793.236953-1.190848.217547.467262.606445.896801 1.238168.896801.207281 0 .375012-.16773.375012-.374976 0-.533883.011004-1.14982.14393-1.705711.1183-.49289.400992-1.017281.759164-1.437645.159293.545625.469863.987223.773085 1.418238.43397.616641.882563 1.2542.961313 2.341407.004746.064441.009527.12927.009527.198843C17 22.174336 15.990734 23.249484 14.75 23.249484z" fill="#FFF" fill-rule="nonzero"/>
					</g>
				</svg>
			</div>
		<?php endif; ?>
	</div>
<?php } ?>
