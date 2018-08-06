<?php

defined('_JEXEC') or die;

echo '<ul class="mostread' . $moduleclass_sfx . '">';

foreach ($list as $item) {
  echo '<li itemscope itemtype="https://schema.org/Article">';
	echo '<a href="' . $item->link . '" itemprop="url">';
	echo '<span itemprop="name">';
	echo $item->title;
	echo '</span>';
	echo '</a>';
	echo '</li>';
}

echo '</ul>';
