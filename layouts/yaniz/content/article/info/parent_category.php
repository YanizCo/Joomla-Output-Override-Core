<?php

defined('JPATH_BASE') or die;

$item = $displayData['item'];
$title = $this->escape($item->parent_title);

echo '<dd class="parent-category-name">';

if ($displayData['params']->get('link_parent_category') && !empty($item->parent_slug)) {
  $href = JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug));
	$link = '<a href="' . $href . '" itemprop="genre">' . $title . '</a>';
	echo JText::sprintf('COM_CONTENT_PARENT', $link);
} else {
	echo JText::sprintf('COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>');
}

echo '</dd>';
