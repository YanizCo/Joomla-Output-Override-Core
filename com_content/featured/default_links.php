<?php

defined('_JEXEC') or die;

echo '<ol class="nav nav-tabs nav-stacked">';

foreach ($this->link_items as &$item) {
  echo '<li>';
  echo '<a href="' . JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)) . '">';
	echo $item->title;
	echo '</a></li>';
}

echo '</ol>';
