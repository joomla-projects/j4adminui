<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @since  4.0.0
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Utilities\ArrayHelper;

extract($displayData);

/**
 * Layout variables
 * ------------------
 * @param   string  $selector  Unique DOM identifier for the modal. CSS id without #
 * @param   array   $params    Modal parameters. Default supported parameters:
 *                             - title        string   The modal title
 *                             - backdrop     mixed    A boolean select if a modal-backdrop element should be included (default = true)
 *                                                     The string 'static' includes a backdrop which doesn't close the modal on click.
 *                             - keyboard     boolean  Closes the modal when escape key is pressed (default = true)
 *                             - url|iframe   string   URL of a resource to be inserted as an <iframe> inside the modal body
 *                             - height       string   height of the <iframe> containing the remote resource
 *                             - width        string   width of the <iframe> containing the remote resource
 *                             - footer       string   Optional markup for the modal footer
 * @param   string  $body      Markup for the modal body. Appended after the <iframe> if the URL option is set
 *
 */

/**
 * @var    array   $modalAttributes
* Set all params as element attributes without some specific attributes
*/
$modalAttributes = $params;

// Remove specific attributes
if (isset($modalAttributes['footer'])) {
unset($modalAttributes['footer']);
}

/**
 * Change url to iframe url for load iframe into modal body
 * Hack from default bootstrap.renderModal attributes
 */
if (isset($params['url']) && !isset($params['iframe']))
{
	$modalAttributes['iframe'] = $params['url'];
	unset($modalAttributes['url']);
}

?>
<joomla-modal role="dialog" id="<?php echo $selector; ?>" <?php echo ArrayHelper::toString($modalAttributes); ?> >
	<?php
		// Main body
		echo LayoutHelper::render('joomla.webcomponent.modal.body', $displayData);

		// Footer
		if (isset($params['footer']))
		{
			echo LayoutHelper::render('joomla.webcomponent.modal.footer', $displayData);
		}
	?>
</joomla-modal>