<?php

defined('JPATH_BASE') or die;

$params = $displayData['params'];
$item = $displayData['item'];
$pos = $displayData['position'];
$posBlock = $params->get('info_block_position', 0);

echo '<dl class="article-info muted">';

if ($pos === 'above' && ($posBlock == 0 || $posBlock == 2) || $pos === 'below' && ($posBlock == 1)) {
  if ($params->get('info_block_show_title', 1)) {
    echo '<dt class="article-info-term">';
		echo JText::_('COM_CONTENT_ARTICLE_INFO');
    echo '</dt>';
	}

	if ($params->get('show_author') && !empty($item->author)) {
		echo $this->sublayout('author', $displayData);
	}

	if ($params->get('show_parent_category') && !empty($item->parent_slug)) {
		echo $this->sublayout('parent_category', $displayData);
	}

	if ($params->get('show_category')) {
		echo $this->sublayout('category', $displayData);
	}

	if ($params->get('show_associations')) {
		echo $this->sublayout('associations', $displayData);
	}

	if ($params->get('show_publish_date')) {
		echo $this->sublayout('publish_date', $displayData);
	}
}

if ($pos === 'above' && ($posBlock == 0) || $pos === 'below' && ($posBlock == 1 || $posBlock == 2)) {

  if ($params->get('show_create_date')) {
		echo $this->sublayout('create_date', $displayData);
	}

	if ($params->get('show_modify_date')) {
		echo $this->sublayout('modify_date', $displayData);
	}

	if ($params->get('show_hits')) {
		echo $this->sublayout('hits', $displayData);
	}
}

echo '</dl>';
