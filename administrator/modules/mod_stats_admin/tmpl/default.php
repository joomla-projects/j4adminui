<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_stats_admin
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$app->getDocument()->addScriptDeclaration('
	document.addEventListener("DOMContentLoaded", function() {
		const allReverts = document.querySelectorAll("a.js-revert")
		allReverts.forEach( item => {
			item.addEventListener("click", (e) => { 
				e.preventDefault();
				e.stopPropagation();
				var activeTab = [];
				activeTab.push("#" + e.target.href.split("#")[1]);
				var path = window.location.pathname;
				localStorage.removeItem(e.target.href.replace(/&return=[a-zA-Z0-9%]+/, "").replace(/&[a-zA-Z-_]+=[0-9]+/, ""));
				localStorage.setItem(path + e.target.href.split("index.php")[1].split("#")[0], JSON.stringify(activeTab));
				return window.location.href = e.target.href.split("#")[0];
			})
		})
	});
');
?>
<ul class="list-group list-group-flush stats-module">
	<?php foreach ($list as $item) : ?>
		<li class="list-group-item">
			<div class="d-flex align-items-center">
				<div class="mr-3">
					<span class="icon-<?php echo $item->icon; ?> icon-fw text-muted" aria-hidden="true"></span>
				</div>
				<div>
					<?php echo $item->title; ?>
				</div>
				<div class="ml-auto">
					<?php if(isset($item->link)) : ?>
					<strong><a class="js-revert" href="<?php echo $item->link; ?>"><?php echo $item->data; ?></a></strong>
					<?php else : ?>
						<strong><?php echo $item->data; ?></strong>
					<?php endif; ?>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
