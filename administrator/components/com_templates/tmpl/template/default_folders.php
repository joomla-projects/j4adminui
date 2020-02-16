<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
ksort($this->files, SORT_STRING);
?>

<ul class="directory-tree treeselect">
	<?php foreach($this->files as $key => $value) : ?>
		<?php if (is_array($value)) : ?>
			<li class="folder-select has-subtree">
				<a class="folder-url" data-id="<?php echo base64_encode($key); ?>" href="javascript:void(0);">
					<span class="icon-folder-2" aria-hidden="true"></span>
					<?php $explodeArray = explode('/', $key); echo $this->escape(end($explodeArray)); ?>
				</a>
				<?php echo $this->folderTree($value); ?>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
