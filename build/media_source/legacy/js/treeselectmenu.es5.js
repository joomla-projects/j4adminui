/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
jQuery(function($)
{
	var treeselectmenu = $('div#treeselectmenu');

	$('.treeselect li').each(function(index)
	{
		$li = $(this);
		
		$div = $li.find('div.treeselect-item:first');

		// Add icons
		$div.prepend('<span class="treeselect-icon d-none"><span class="fas fa-fw" area-hidden="true"></span></span>');

		if ($li.find('ul.treeselect-sub').length) {
			// Add classes to Expand/Collapse icons
			$li.find('span.treeselect-icon').removeClass('d-none').addClass('treeselect-toggle').find('span').addClass('fa-chevron-down');
			
			// Append drop down menu in nodes
			treeselectmenu.find('.treeselect-options-toggle').attr('data-target', `treemenu-${index}`);
			treeselectmenu.find('joomla-dropdown').attr('for', `treemenu-${index}`);
			$div.find('.treeselect-item-content').after(treeselectmenu.html());

			if (!$li.find('ul.treeselect-sub ul.treeselect-sub').length) {
				$li.find('div.treeselect-menu-expand').remove();
			}
		}
	});

	// Takes care of the Expand/Collapse of a node
	$('span.treeselect-toggle').click(function()
	{
		$toggle = $(this);
		$icon = $(this).find('span');

		// Take care of parent UL
		if ($toggle.parent().parent().find('ul.treeselect-sub').is(':visible')) {
			$icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
			$toggle.parent().parent().find('ul.treeselect-sub').hide();
			$toggle.parent().parent().find('ul.treeselect-sub span.treeselect-toggle').find('span').removeClass('fa-chevron-down').addClass('fa-chevron-right');
		} else {
			$icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
			$toggle.parent().parent().find('ul.treeselect-sub').show();
			$toggle.parent().parent().find('ul.treeselect-sub span.treeselect-toggle').find('span').removeClass('fa-chevron-right').addClass('fa-chevron-down');
		}
	});

	// Takes care of the filtering
	$('#treeselectfilter').keyup(function()
	{
		var text = $(this).val().toLowerCase();
		var hidden = 0;
		$("#noresultsfound").hide();
		var $list_elements = $('.treeselect li');
		$list_elements.each(function()
		{
			if ($(this).text().toLowerCase().indexOf(text) == -1) {
				$(this).hide();
				hidden++;
			}
			else {
				$(this).show();
			}
		});
		if(hidden == $list_elements.length)
		{
			$("#noresultsfound").show();
		}
	});

	// Checks all checkboxes the tree
	$('#treeCheckAll').click(function()
	{
		$('.treeselect input').attr('checked', 'checked');
	});

	// Unchecks all checkboxes the tree
	$('#treeUncheckAll').click(function()
	{
		$('.treeselect input').attr('checked', false);
	});

	// Checks all checkboxes the tree
	$('#treeExpandAll').click(function()
	{
		$('ul.treeselect ul.treeselect-sub').show();
		$('ul.treeselect span.treeselect-toggle').find('span').removeClass('fa-chevron-right').addClass('fa-chevron-down');
	});

	// Unchecks all checkboxes the tree
	$('#treeCollapseAll').click(function()
	{
		$('ul.treeselect ul.treeselect-sub').hide();
		$('ul.treeselect span.treeselect-toggle').find('span').removeClass('fa-chevron-down').addClass('fa-chevron-right');
	});
	// Take care of children check/uncheck all
	$('a.checkall').click(function()
	{
		$(this).parents().eq(3).find('ul.treeselect-sub input').attr('checked', 'checked');
	});
	$('a.uncheckall').click(function()
	{
		$(this).parents().eq(3).find('ul.treeselect-sub input').attr('checked', false);
	});

	// Take care of children toggle all
	$('a.expandall').click(function()
	{
		var $parent = $(this).parents().eq(6);
		$parent.find('ul.treeselect-sub').show();
		$parent.find('ul.treeselect-sub span.treeselect-toggle').find('span').removeClass('fa-chevron-right').addClass('fa-chevron-down');
	});
	$('a.collapseall').click(function()
	{
		var $parent = $(this).parents().eq(6);
		$parent.find('li ul.treeselect-sub').hide();
		$parent.find('li span.treeselect-toggle').find('span').removeClass('fa-chevron-down').addClass('fa-chevron-right');
	});
});
