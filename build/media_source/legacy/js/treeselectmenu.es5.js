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
		$div.prepend('<span class="icon-"></span>');

		if ($li.find('ul.treeselect-sub').length) {
			// Add classes to Expand/Collapse icons
			$li.find('span.icon-').addClass('treeselect-toggle fa-chevron-down');
			
			// Append drop down menu in nodes
			treeselectmenu.find('button.iconic-button').attr('id', `treemenu-${index}`);
			treeselectmenu.find('joomla-dropdown').attr('for', `#treemenu-${index}`);
			$div.find('label:first').after(treeselectmenu.html());

			if (!$li.find('ul.treeselect-sub ul.treeselect-sub').length) {
				$li.find('div.treeselect-menu-expand').remove();
			}
		}
	});

	// Takes care of the Expand/Collapse of a node
	$('span.treeselect-toggle').click(function()
	{
		console.log($(this));
		$i = $(this);

		// Take care of parent UL
		if ($i.parent().parent().find('ul.treeselect-sub').is(':visible')) {
			$i.removeClass('fa-chevron-down').addClass('fa-chevron-right');
			$i.parent().parent().find('ul.treeselect-sub').hide();
			$i.parent().parent().find('ul.treeselect-sub span.treeselect-toggle').removeClass('fa-chevron-down').addClass('fa-chevron-right');
		} else {
			$i.removeClass('fa-chevron-right').addClass('fa-chevron-down');
			$i.parent().parent().find('ul.treeselect-sub').show();
			$i.parent().parent().find('ul.treeselect-sub span.treeselect-toggle').removeClass('fa-chevron-right').addClass('fa-chevron-down');
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
		$('ul.treeselect span.treeselect-toggle').removeClass('fa-chevron-right').addClass('fa-chevron-down');
	});

	// Unchecks all checkboxes the tree
	$('#treeCollapseAll').click(function()
	{
		$('ul.treeselect ul.treeselect-sub').hide();
		$('ul.treeselect span.treeselect-toggle').removeClass('fa-chevron-down').addClass('fa-chevron-right');
	});
	// Take care of children check/uncheck all
	$('a.checkall').click(function()
	{
		$(this).parents().eq(5).find('ul.treeselect-sub input').attr('checked', 'checked');
	});
	$('a.uncheckall').click(function()
	{
		$(this).parents().eq(5).find('ul.treeselect-sub input').attr('checked', false);
	});

	// Take care of children toggle all
	$('a.expandall').click(function()
	{
		var $parent = $(this).parents().eq(6);
		$parent.find('ul.treeselect-sub').show();
		$parent.find('ul.treeselect-sub span.treeselect-toggle').removeClass('fa-chevron-right').addClass('fa-chevron-down');
	});
	$('a.collapseall').click(function()
	{
		var $parent = $(this).parents().eq(6);
		$parent.find('li ul.treeselect-sub').hide();
		$parent.find('li span.treeselect-toggle').removeClass('fa-chevron-down').addClass('fa-chevron-right');
	});
});
