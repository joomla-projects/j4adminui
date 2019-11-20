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

/**
 * Layout variable
 * ------------------
 * @param   string  $body      Markup for the modal body. Appended after the <iframe> if the URL option is set
 */

extract($displayData);
?>

<section>
	<?php echo $body; ?> 
</section>