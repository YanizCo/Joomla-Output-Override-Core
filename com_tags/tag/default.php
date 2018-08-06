<?php
/**
 * @copyright Copyright (C) 2016 - 2018 Yaniz Corporation. All rights reserved.
 * @license BSD 2 Clause; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$isSingleTag = count($this->item) === 1;

echo '<div class="tag-category' . $this->pageclass_sfx . '">';

if ($this->params->get('show_page_heading')) {
  echo '<h1>' . $this->escape($this->params->get('page_heading')) . '</h1>';
}

if ($this->params->get('show_tag_title', 1)) {
  echo '<h2>' . JHtml::_('content.prepare', $this->tags_title, '', 'com_tag.tag') . '</h2>';
}

// We only show a tag description if there is a single tag.
if (count($this->item) === 1 && ($this->params->get('tag_list_show_tag_image', 1) || $this->params->get('tag_list_show_tag_description', 1))) {
  echo '<div class="category-desc">';

  $images = json_decode($this->item[0]->images);

  if ($this->params->get('tag_list_show_tag_image', 1) == 1 && !empty($images->image_fulltext)) {
	  echo '<img src="' . htmlspecialchars($images->image_fulltext, ENT_COMPAT, 'UTF-8') . '" alt="' . htmlspecialchars($images->image_fulltext_alt) . '" />';
	}

  if ($this->params->get('tag_list_show_tag_description') == 1 && $this->item[0]->description) {
		echo JHtml::_('content.prepare', $this->item[0]->description, '', 'com_tags.tag');
	}

  echo '<div class="clr"></div>';
	echo '</div>';
}

// If there are multiple tags and a description or image has been supplied use that.

if ($this->params->get('tag_list_show_tag_description', 1) || $this->params->get('show_description_image', 1)) {
	if ($this->params->get('show_description_image', 1) == 1 && $this->params->get('tag_list_image')) {
		echo '<img src="' . $this->params->get('tag_list_image') . '" />';
	}

	if ($this->params->get('tag_list_description', '') > '') {
		echo JHtml::_('content.prepare', $this->params->get('tag_list_description'), '', 'com_tags.tag');
	}
}

echo $this->loadTemplate('items');

if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) {
	echo '<div class="pagination">';

  if ($this->params->def('show_pagination_results', 1)) {
		echo '<p class="counter pull-right">' . $this->pagination->getPagesCounter() . '</p>';
  }

  echo $this->pagination->getPagesLinks();
	echo '</div>';
}

echo '</div>';
