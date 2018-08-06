<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('jquery.ui');
JHtml::_('behavior.caption');

$params = $this->params;
$category = $this->category;
$dispatcher = JEventDispatcher::getInstance();

$category->text = $category->description;
$dispatcher->trigger('onContentPrepare', array($category->extension . '.categories', &$category, &$params, 0));
$category->description = $category->text;

$results = $dispatcher->trigger('onContentAfterTitle', array($category->extension . '.categories', &$category, &$params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentBeforeDisplay', array($category->extension . '.categories', &$category, &$params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentAfterDisplay', array($category->extension . '.categories', &$category, &$params, 0));
$afterDisplayContent = trim(implode("\n", $results));

echo '<section class="accordion' . $this->pageclass_sfx . '" itemscope itemtype="https://schema.org/Blog">';
echo JLayoutHelper::render('yaniz.content.category.header', array('category' => $category, 'params' => $params));

echo $afterDisplayTitle;

if ($beforeDisplayContent || $afterDisplayContent || $params->get('show_description', 1) || $params->def('show_description_image', 1)) {
  echo '<div class="category-desc">';
  if ($params->get('show_description_image') && $category->getParams()->get('image')) {
    echo '<img src="' . $category->getParams()->get('image');
    echo '" alt="' . htmlspecialchars($category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8') . '"/>';
	}

  echo $beforeDisplayContent;

  if ($params->get('show_description') && $category->description) {
		echo JHtml::_('content.prepare', $category->description, '', 'com_content.category');
	}

  echo $afterDisplayContent;

  echo '</div>';
}

if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) {
	if ($params->get('show_no_articles', 1)) {
	   echo '<p>' . JText::_('COM_CONTENT_NO_ARTICLES') . '</p>';
	}
}

echo '<div id="mainAccordion">';

if (!empty($this->lead_items)) {
  foreach ($this->lead_items as &$item) {
	  $this->item = &$item;
		echo $this->loadTemplate('item');
	}
}

if (!empty($this->intro_items)) {
  foreach ($this->intro_items as $key => &$item) {
    foreach ($this->lead_items as &$item) {
      $this->item = &$item;
      echo $this->loadTemplate('item');
    }
	}
}

echo '</div>';


if (!empty($this->link_items)) {
	echo $this->loadTemplate('links');
}

if ($this->maxLevel != 0 && !empty($this->children[$category->id])) {
  echo $this->loadTemplate('children');
}

if (($params->def('show_pagination', 1) == 1 || ($params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) {
  echo '<div class="pagination">';
	if ($params->def('show_pagination_results', 1)) {
		echo '<p class="counter pull-right">' . $this->pagination->getPagesCounter() . '</p>';
	}

  echo $this->pagination->getPagesLinks();
  echo '</div>';
}

echo '</section>';

echo '<script>';
echo 'jQuery(document).ready(function($){';
echo '$("#mainAccordion").accordion({active:false,collapsible:true,});';
echo '});';
echo '</script>';
