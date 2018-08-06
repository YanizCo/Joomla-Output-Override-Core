<?php
/**
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Clean up duplicates
for ($i = 0; $i < $count; $i++) {
	if ($i === 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link === $list[$i - 1]->link) {
		unset($list[$i]);
	}
}

$itemLength = count($list);

if ($itemLength > 1) {
	$keyLastItem = $itemLength - 1;
	$keyPrevItem = $itemLength - 2;
	$showLastItem = $params->get('showLast', 1);

	$tmpl_li = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">{item}</li>';
	$tmpl_a = '<a itemprop="item" href="{link}" class="pathway"><span itemprop="name">{name}</span></a>';
	$tmpl_span = '<span itemprop="name">{name}</span>';
	$tmpl_meta = '<meta itemprop="position" content="{$key}">';

	echo '<ul itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb' . $moduleclass_sfx . '">';

	if ($params->get('showHere', 1)) {
			echo '<li>' . JText::_('MOD_BREADCRUMBS_HERE') . '&#160;</li>';
	} else {
			echo '<li class="active"><span class="divider icon-location"></span></li>';
	}

	// Build the breadcrumbs
	foreach ($list as $k => $l) {
		if ($k !== $keyLastItem) {

			if (!empty($l->link)) {
				$item = str_replace('{link}', $l->link, $tmpl_a);
				$item = str_replace('{name}', $l->name, $item);
			} else {
				$item = str_replace('{name}', $l->name, $tmpl_span);
			}

			$item .= str_replace('{key}', $k + 1, $tmpl_meta);

			echo str_replace('{item}', $item, $tmpl_li);

			if (($k !== $keyPrevItem) || $showLastItem) {
				echo '<li class="divider">' . $separator . '</li>';
			}
		} elseif ($showLastItem) {

			$item = str_replace('{name}', $l->name, $tmpl_span);
			$item .= str_replace('{key}', $k + 1, $tmpl_meta);

			echo str_replace('{item}', $item, $tmpl_li);
		}
	}

	echo '</ul>';
}
