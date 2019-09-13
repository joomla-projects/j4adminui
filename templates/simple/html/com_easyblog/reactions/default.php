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
<div class="eb-reactions" data-reactions data-id="<?php echo $post->id;?>">
	
	<div class="eb-reactions__options">
		<div class="eb-reaction-option">
			<svg width="31" height="26" xmlns="http://www.w3.org/2000/svg">
				<g fill-rule="nonzero">
					<path d="M20.213 10.38a.602.602 0 0 1-.157-1.182l.025-.007a.602.602 0 1 1 .304 1.164l-.014.004a.596.596 0 0 1-.158.022zM24.268 16.158c-.287 0-.569-.075-.824-.222a1.64 1.64 0 0 1-.769-1.002.602.602 0 0 1 1.163-.312.445.445 0 0 0 .548.317.443.443 0 0 0 .272-.209.444.444 0 0 0 .045-.34.602.602 0 0 1 1.163-.311 1.64 1.64 0 0 1-.166 1.253 1.64 1.64 0 0 1-1.432.826zM19.062 17.553c-.287 0-.569-.075-.824-.222a1.64 1.64 0 0 1-.769-1.002.602.602 0 0 1 1.163-.312.445.445 0 0 0 .548.316.444.444 0 0 0 .316-.548.602.602 0 0 1 1.164-.311 1.64 1.64 0 0 1-.166 1.253 1.64 1.64 0 0 1-1.432.826zM22.686 21.497c-.429 0-.851-.113-1.233-.333a2.457 2.457 0 0 1-1.152-1.502.602.602 0 1 1 1.162-.312c.088.328.298.602.592.772a1.272 1.272 0 0 0 1.862-1.429.602.602 0 1 1 1.163-.312 2.477 2.477 0 0 1-2.394 3.116z"/>
					<path d="M30.523 15.24a8.534 8.534 0 0 0-7.742-6.321.602.602 0 0 0-.072 1.202 7.331 7.331 0 0 1 6.651 5.43c1.048 3.91-1.281 7.943-5.19 8.99a7.276 7.276 0 0 1-1.886.248 7.376 7.376 0 0 1-6.182-3.353c.63-1.19.987-2.546.987-3.983a8.49 8.49 0 0 0-.987-3.984 7.373 7.373 0 0 1 2.239-2.222.602.602 0 0 0-.644-1.017 8.579 8.579 0 0 0-2.293 2.134 8.537 8.537 0 0 0-6.86-3.456C3.834 8.908 0 12.74 0 17.453c0 4.711 3.833 8.544 8.545 8.544a8.537 8.537 0 0 0 6.86-3.458 8.622 8.622 0 0 0 3.602 2.81 8.476 8.476 0 0 0 5.474.355c4.55-1.22 7.261-5.914 6.042-10.465zM8.545 24.792c-4.048 0-7.341-3.293-7.341-7.34 0-4.048 3.293-7.341 7.34-7.341 4.048 0 7.341 3.293 7.341 7.34 0 4.048-3.293 7.341-7.34 7.341z"/>
					<path d="M6.9 16.778a.602.602 0 0 1-.603-.602.448.448 0 0 0-.895 0 .602.602 0 1 1-1.204 0c0-.91.741-1.651 1.652-1.651.91 0 1.651.74 1.651 1.65 0 .333-.27.603-.602.603zM12.29 16.778a.602.602 0 0 1-.603-.602.448.448 0 0 0-.895 0 .602.602 0 0 1-1.204 0c0-.91.741-1.651 1.652-1.651.91 0 1.65.74 1.65 1.65 0 .333-.269.603-.6.603zM8.545 21.553a2.477 2.477 0 0 1-2.474-2.474.602.602 0 0 1 1.203 0c0 .7.57 1.27 1.27 1.27.701 0 1.27-.57 1.27-1.27a.602.602 0 0 1 1.205 0 2.477 2.477 0 0 1-2.474 2.474zM15.417 4.077a.602.602 0 0 1-.602-.602V.602a.602.602 0 1 1 1.204 0v2.873c0 .333-.27.602-.602.602zM15.417 6.619a.605.605 0 0 1-.426-1.027.607.607 0 0 1 .426-.177.606.606 0 0 1 .602.602.604.604 0 0 1-.602.602zM12.312 5.576a.6.6 0 0 1-.425-.177L9.892 3.404a.602.602 0 0 1 .85-.851l1.996 1.995a.602.602 0 0 1-.426 1.028zM18.559 5.523a.602.602 0 0 1-.426-1.027l1.94-1.942a.602.602 0 0 1 .851.851l-1.94 1.941a.6.6 0 0 1-.425.177z"/>
				</g>
			</svg>
			<div class="eb-reaction-option__link">
				<div class="eb-reaction-option__text">
					<?php echo JText::_('COM_EASYBLOG_REACTIONS_HOW_DO_YOU_FEEL');?>
				</div>
			</div>
		</div>
	</div>

	<div class="eb-reactions__results">
		<div class="eb-reaction-state">
			<?php foreach ($reactions as $reaction) { ?>
			<a href="javascript:void(0);" class="eb-reaction-state__item <?php echo $userReaction && $userReaction->type == $reaction->type ? ' is-active' : '';?>" 
				data-reaction="<?php echo $reaction->type;?>" data-id="<?php echo $reaction->id;?>">
				<i class="eb-reaction-state__icon eb-emoji-icon eb-emoji-icon--<?php echo $reaction->type;?>"></i>
				<div class="eb-reaction-state__counter">
					<b><?php echo JText::_('COM_EASYBLOG_REACTION_' . strtoupper($reaction->type));?></b> (<span data-count><?php echo $reaction->total;?></span>)
				</div>
			</a>
			<?php } ?>
		</div>
	</div>
</div>