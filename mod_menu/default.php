<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = '';

if ($tagId = $params->get('tag_id', '')) {
	$id = ' id="' . $tagId . '"';
}

echo '<ul class="nav menu' . $class_sfx . '"' . $id . '>';

foreach ($list as $i => &$item) {
	$class = 'item-' . $item->id;

	if ($item->id == $default_id) {
		$class .= ' default';
	}

	if ($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id)) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	} elseif ($item->type === 'alias') {
		$aliasToId = $item->params->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
			$class .= ' active';
		} elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type === 'separator') {
		$class .= ' divider';
	}

	if ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	echo '<li class="' . $class . '">';

	switch ($item->type) {
		case 'separator':
		case 'component':
		case 'heading':
		case 'url':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	}

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul class="nav-child unstyled small">';
	} elseif ($item->shallower) { // The next item is shallower.
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	} else { // The next item is on the same level.
		echo '</li>';
	}
}

echo '</ul>';
