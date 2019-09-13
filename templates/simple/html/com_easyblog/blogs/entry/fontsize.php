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
<?php if ($this->entryParams->get('post_font_resize', true)) { ?>
	<div class="eb-tool-font-resizer">
		<div class="eb-tool-title">Font Size</div>
		<ul>
			<li>
				<a class="eb-tool-font-larger" href="javascript:void(0);" data-font-resize data-operation="increase" data-toggle="tooltip" data-placement="left" title="<?php echo JText::_('COM_EASYBLOG_FONT_LARGER', true);?>">
					A&#8314;
				</a>
			</li>
			<li>
				<a class="eb-tool-font-smaller" href="javascript:void(0);" data-font-resize data-operation="decrease" data-toggle="tooltip" data-placement="left" title="<?php echo JText::_('COM_EASYBLOG_FONT_SMALLER', true); ?>">
					A&#8315;
				</a>
			</li>
		</ul>
	</div>
<?php } ?>