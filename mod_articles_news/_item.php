<?php

defined('_JEXEC') or die;

$item_heading = $params->get('item_heading', 'h4');

if ($params->get('item_title')) {
  echo '<' . $item_heading . 'class="newsflash-title' . $params->get('moduleclass_sfx') . '">';
	if ($item->link !== '' && $params->get('link_titles')) {
		echo '<a href="' . $item->link . '">';
		echo $item->title;
		echo '</a>';
	} else {
		echo $item->title;
	}
	echo '</' . $item_heading . '>';
}

if (!$params->get('intro_only')) {
	echo $item->afterDisplayTitle;
}

echo $item->beforeDisplayContent;

if ($params->get('show_introtext', '1')) {
  echo $item->introtext;
}

echo $item->afterDisplayContent;

if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) {
	echo '<a class="readmore" href="' . $item->link . '">' . $item->linkText . '</a>';
}
