<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
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

echo '<section class="blog' . $this->pageclass_sfx . '" itemscope itemtype="https://schema.org/Blog">';
echo JLayoutHelper::render('yaniz.content.category.header', array('category' => $category, 'params' => $params));

/*
$showPageTitle = ($params->get('show_page_heading') != 0);
$showCategoryTitle = ($params->get('show_category_title', 1) || $params->get('page_subheading'));

if ($params->get('show_page_heading') != 0) {
  echo '<header class="page-header">';
	echo '<h1>' . $this->escape($params->get('page_heading')) . '</h1>';
  echo '</header>';
}

if ($showCategoryTitle) {
  $title = $this->escape($params->get('page_subheading'));

  if ($params->get('show_category_title')) {
	   $title .= '<span class="subheading-category">' . $category->title . '</span>';
	}

  if ($showPageTitle) {
    echo '<h2>' . $title . '</h2>';
  } else {
    echo '<header class="page-header">';
    echo '<h1>' . $title . '</h1>';
    echo '</header>';
  }
}
*/

echo $afterDisplayTitle;

if ($params->get('show_cat_tags', 1) && !empty($category->tags->itemTags)) {
	$category->tagLayout = new JLayoutFile('joomla.content.tags');
	echo $category->tagLayout->render($category->tags->itemTags);
}

if ($beforeDisplayContent || $afterDisplayContent || $params->get('show_description', 1) || $params->def('show_description_image', 1)) {
  echo '<div class="category-desc clearfix">';
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

$countLead = 0;

if (!empty($this->lead_items)) {
  echo '<section class="items-leading clearfix">';

  foreach ($this->lead_items as &$item) {
	  echo '<article class="leading-' . $countLead . (($item->state == 0) ? ' system-unpublished' : null) . ' clearfix"';
		echo 'itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">';
    $this->item = &$item;
		echo $this->loadTemplate('item');
    echo '</article>';

		$countLead++;
	}

  echo '</section>';
}

$countIntro = count($this->intro_items);
$count = 0;

if (!empty($this->intro_items)) {
  foreach ($this->intro_items as $key => &$item) {
	  $countRow = ((int) $key % (int) $this->columns) + 1;

    if ($countRow === 1) {
	    $row = $count / $this->columns;
      $cssClass = 'items-row cols-' . (int)$this->columns . ' row-' . $row . ' row-fluid clearfix';
			echo '<section class="' . $cssClass . '">';
		}

    $cssClass = 'span' . (round(12 / $this->columns));
    echo '<section class="' . $cssClass . '">';

    $cssClass = 'item column-' . $countRow . (($item->state == 0) ? ' system-unpublished' : null);
		echo '<article class="' . $cssClass . '"';
		echo ' itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">';

		$this->item = &$item;
		echo $this->loadTemplate('item');

		echo '</article>';

		$count++;
		echo '</section>';

    if (($countRow == $this->columns) or ($count == $countIntro)) {
				echo '</section>';
		}
	}
}

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
