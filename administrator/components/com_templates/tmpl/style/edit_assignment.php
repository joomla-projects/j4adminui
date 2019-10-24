<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\Menus\Administrator\Helper\MenusHelper;

// Initialise related data.
$menuTypes = MenusHelper::getMenuLinks();
$user      = Factory::getUser();

HTMLHelper::_('script', 'com_templates/admin-template-toggle-assignment.js', ['version' => 'auto', 'relative' => true]);
?>
<div class="d-flex align-items-center">
	<div class="mr-auto">
		<label id="jform_menuselect-lbl" for="jform_menuselect"><?php echo Text::_('JGLOBAL_MENU_SELECTION'); ?></label>
	</div>
	<button class="btn btn-sm btn-secondary jform-rightbtn" type="button" onclick="Joomla.toggleAll()">
		<span class="icon-checkbox-partial" aria-hidden="true"></span> <?php echo Text::_('JGLOBAL_SELECTION_INVERT_ALL'); ?>
	</button>
</div>
<div id="menu-assignment" class="menu-assignment">
	<ul class="menu-links">
		<?php foreach ($menuTypes as &$type) : ?>
			<li>
				<div class="j-card">
					<div class="j-card-header d-flex align-items-center">
						<h4 class="j-card-title"><?php echo $type->title ?: $type->menutype; ?></h4>
						<div class="j-card-header-right">
							<button class="j-card-header-icon jform-rightbtn" type="button" onclick='Joomla.toggleMenutype("<?php echo $type->menutype; ?>")'>
								<span class="icon-checkbox-partial" aria-hidden="true"></span></span> <?php echo Text::_('JGLOBAL_SELECTION_INVERT'); ?>
							</button>
						</div>
					</div>

					<div class="j-card-body">
						<?php foreach ($type->links as $link) : ?>
							<div class="j-checkbox-group">
								<label><input type="checkbox" name="jform[assigned][]" value="<?php echo (int) $link->value; ?>" id="link<?php echo (int) $link->value; ?>"<?php if ($link->template_style_id == $this->item->id) : ?> checked="checked"<?php endif; ?><?php if ($link->checked_out && $link->checked_out != $user->id) : ?> disabled="disabled"<?php else : ?> class="chk-menulink <?php echo $type->menutype; ?>"<?php endif; ?> /> <?php echo LayoutHelper::render('joomla.html.treeprefix', array('level' => $link->level)) . $link->text; ?></label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
