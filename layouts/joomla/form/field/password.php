<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   array    $inputType       Options available for this field.
 * @var   string   $accept          File types that are accepted.
 */

HTMLHelper::_('webcomponent', 'system/fields/joomla-field-password.min.js', array('version' => 'auto', 'relative' => true));

Text::script('JFIELD_PASSWORD_INDICATE_INCOMPLETE', true);
Text::script('JFIELD_PASSWORD_INDICATE_COMPLETE', true);
Text::script('JFIELD_PASSWORD_INDICATOR_VERY_WEAK', true);
Text::script('JFIELD_PASSWORD_INDICATOR_WEAK', true);
Text::script('JFIELD_PASSWORD_INDICATOR_GOOD', true);
Text::script('JFIELD_PASSWORD_INDICATOR_GREAT', true);
Text::script('JFIELD_PASSWORD_INDICATOR_STRONG', true);
Text::script('JSHOW', true);
Text::script('JHIDE', true);

$hint 	= !empty($hint) ? htmlspecialchars($hint, ENT_COMPAT, 'UTF-8') : '';
$class 	= !empty($class) ? 'form-control ' . $class : 'form-control';

?>

<joomla-field-password 
	type="password"
	name="<?php echo $name; ?>"
	input-id="<?php echo $id; ?>"
	custom-class="<?php echo $class; ?>"
	value="<?php echo htmlspecialchars($value, ENT_COMPAT, 'UTF-8'); ?>"
	strength-meter="<?php echo $meter; ?>"
	min-length="<?php echo $minLength; ?>"
	min-integers="<?php echo $minIntegers; ?>"
	min-symbols="<?php echo $minSymbols; ?>"
	min-uppercase="<?php echo $minUppercase; ?>"
	min-lowercase="<?php echo $minLowercase; ?>"
	force-password="<?php echo $forcePassword; ?>"
	hint="<?php echo $hint; ?>"
	autocomplete="<?php echo $autocomplete; ?>"
	readonly="<?php echo $readonly; ?>"
	disabled="<?php echo $disabled; ?>"
	size="<?php echo $size; ?>"
	max-length="<?php echo $maxLength; ?>"
	required="<?php echo $required; ?>"
	autofocus="<?php echo $autofocus; ?>"
/>