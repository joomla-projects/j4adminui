<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_multilangstatus
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('bootstrap.framework');
HTMLHelper::_('script', 'mod_multilangstatus/admin-multilangstatus.min.js', array('version' => 'auto', 'relative' => true));
?>

<div class="multilanguage">
	<a class="d-flex align-items-stretch header-item-link" data-href="#multiLangModal" href="#" title="<?php echo Text::_('MOD_MULTILANGSTATUS'); ?>" data-toggle="modal" role="button">
		<div class="d-none d-xl-block mr-2">
			<?php echo Text::_('MOD_MULTILANGSTATUS'); ?>
		</div>
		<div>
			<span class="icon-multilingual" aria-hidden="true"></span>
		</div>
	</a>

	<?php echo HTMLHelper::_(
		'webcomponent.renderModal',
		'multiLangModal',
		array(
			'title'      => Text::_('MOD_MULTILANGSTATUS'),
			'url'        => Route::_('index.php?option=com_languages&view=multilangstatus&tmpl=component'),
			'height'     => '75vh',
			'width'      => '85vw',
			'bodyHeight' => 70,
			'modalWidth' => 80,
			'footer'     => '<button type="button" class="btn btn-secondary" data-dismiss="modal">' . Text::_('JTOOLBAR_CLOSE') . '</button>',
		)
	); ?>
</div>
