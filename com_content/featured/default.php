<?php

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

$params = $this->params;

echo '<section class="blog-featured' . $this->pageclass_sfx . '" itemscope itemtype="https://schema.org/Blog">';

if ($params->get('show_page_heading') != 0) {
  echo '<header class="page-header">';
	echo '<h1>' . $this->escape($params->get('page_heading')) . '</h1>';
  echo '</header>';
}

$leadingcount = 0;

if (!empty($this->lead_items)) {
  echo '<section class="items-leading clearfix">';

  foreach ($this->lead_items as &$item) {
	  echo '<article class="leading-' . $leadingcount . (($item->state == 0) ? ' system-unpublished' : null) . ' clearfix"';
		echo 'itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">';
    $this->item = &$item;
		echo $this->loadTemplate('item');
    echo '</article>';

		$leadingcount++;
	}

  echo '</section>';
}

$introcount = count($this->intro_items);
$counter = 0;

if (!empty($this->intro_items)) {
	foreach ($this->intro_items as $key => &$item) {
		$key = ($key - $leadingcount) + 1;
		$rowcount = (((int) $key - 1) % (int) $this->columns) + 1;
		$row = $counter / $this->columns;

		if ($rowcount === 1) {
      $cssClass = 'items-row cols-' . (int)$this->columns . ' row-' . $row . ' row-fluid';
      echo '<div class="' . $cssClass . '">';
		}

    $cssClass = 'item column-' . $rowcount . (($item->state == 0) ? ' system-unpublished' : null) . ' span' . round(12 / $this->columns);

    echo '<section class="' . $cssClass . '" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">';

    $this->item = &$item;

    echo $this->loadTemplate('item');
    echo "</section>";

    $counter++;

		if (($rowcount == $this->columns) or ($counter == $introcount)) {
      echo  '</div>';
		}
	}
}

if (!empty($this->link_items)) {
	echo '<section class="items-more">';
	echo $this->loadTemplate('links');
	echo '</section>';
}

if ($params->def('show_pagination', 2) == 1  || ($params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) {
	echo '<div class="pagination">';

	if ($params->def('show_pagination_results', 1)) {
		echo '<p class="counter pull-right">';
		echo $this->pagination->getPagesCounter();
		echo '</p>';
	}

  echo $this->pagination->getPagesLinks();
	echo '</div>';
}

echo '</section>';
