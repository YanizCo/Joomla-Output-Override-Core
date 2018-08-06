<?php

defined('JPATH_BASE') or die;

$title = $this->escape($displayData['item']->category_title);

echo '<dd class="category-name">';

if ($displayData['params']->get('link_category') && $displayData['item']->catslug) {
  $url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)) . '" itemprop="genre">' . $title . '</a>';
	echo JText::sprintf('COM_CONTENT_CATEGORY', $url);
} else {
	echo JText::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>');
}

echo '</dd>';
