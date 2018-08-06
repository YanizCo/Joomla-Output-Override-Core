<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation. All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://dev.yaniz.co/license/bsd-2-clause
 */

defined('_JEXEC') or die;

/*
    [id] => 1
    [title] => Navigation
    [module] => mod_menu
    [position] => navigation
    [content] =>
    [showtitle] => 0
    [params] => {"menutype":"mainmenu","startLevel":"0","endLevel":"0","showAllChildren":"0","tag_id":"","class_sfx":"","window_open":"","layout":"","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid"}
    [menuid] => 0
    [user] => 0
    [name] => menu
    [style] => clean

*/

function modChrome_menu($module, &$params, &$attribs) {
	$moduleTag = 'nav';
	$cssClass = 'menu' . htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');;

	echo '<' . $moduleTag . ' class="' . $cssClass . '"' . '>';

	if ($module->content) {
		echo $module->content;
	}

	echo '</' . $moduleTag . '>';
}

function modChrome_clean($module, &$params, &$attribs) {
	$moduleTag = htmlspecialchars($params->get('module_tag', 'div'), ENT_QUOTES, 'UTF-8');
	$headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
	$headerClass = htmlspecialchars($params->get('header_class', 'page-header'), ENT_COMPAT, 'UTF-8');
	$cssClass = 'clean' . htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

	echo '<' . $moduleTag . ' class="' . $cssClass . '"' . '>';

	if ($module->showtitle) {
		echo '<' . $headerTag . ' class="' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
	}

	echo $module->content;

	echo '</' . $moduleTag . '>';
}

function modChrome_minimal($module, &$params, &$attribs) {
	$moduleTag = htmlspecialchars($params->get('module_tag', 'div'), ENT_QUOTES, 'UTF-8');
	$headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
	$headerClass = htmlspecialchars($params->get('header_class', 'page-header'), ENT_COMPAT, 'UTF-8');
	$cssClass = 'clean' . htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

	echo '<' . $moduleTag . ' class="' . $cssClass . '"' . '>';

	if ($module->showtitle) {
		echo '<' . $headerTag . ' class="' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
	}

	echo $module->content;

	echo '</' . $moduleTag . '>';
}
?>
