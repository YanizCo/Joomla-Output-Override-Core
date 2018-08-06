<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$cssClassTag = ' class="first"';
$lang = JFactory::getLanguage();
$user = JFactory::getUser();
$groups = $user->getAuthorisedViewLevels();

if ($this->maxLevel != 0 && count($this->children[$this->category->id]) > 0) {
  foreach ($this->children[$this->category->id] as $id => $child) {
		// Check whether category access level allows access to subcategories.
		if (in_array($child->access, $groups)) {
			if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) {
				if (!isset($this->children[$this->category->id][$id + 1])) {
					$cssClassTag = ' class="last"';
				}

			  echo '<div' . $cssClassTag . '>';
				$cssClassTag = '';

        if ($lang->isRtl()) {
				  echo '<h3 class="page-header item-title">';

          if ( $this->params->get('show_cat_num_articles', 1)) {
						echo '<span class="badge badge-info tip hasTooltip"';
            echo 'title="' .  JHtml::_('tooltipText', 'COM_CONTENT_NUM_ITEMS_TIP') . '">';
						echo $child->getNumItems(true);
						echo '</span>';
					}

          echo '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)) . '">';
					echo $this->escape($child->title) . '</a>';

					if ($this->maxLevel > 1 && count($child->getChildren()) > 0) {
						echo '<a href="#category-' . $child->id . '" data-toggle="collapse"';
            echo ' data-toggle="button" class="btn btn-mini pull-right"';
            echo ' aria-label="' . JText::_('JGLOBAL_EXPAND_CATEGORIES') . '">';
            echo '<span class="icon-plus" aria-hidden="true"></span></a>';
					}

          echo '</h3>';
				} else {
				  echo '<h3 class="page-header item-title">';
          echo '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)) . '">';
					echo $this->escape($child->title) . '</a>';

          if ( $this->params->get('show_cat_num_articles', 1)) {
						echo '<span class="badge badge-info tip hasTooltip" title="' . JHtml::_('tooltipText', 'COM_CONTENT_NUM_ITEMS_TIP') . '">';
						echo JText::_('COM_CONTENT_NUM_ITEMS') . '&nbsp';
						echo $child->getNumItems(true);
						echo '</span>';
					}

					if ($this->maxLevel > 1 && count($child->getChildren()) > 0) {
						echo '<a href="#category-' . $child->id . '" data-toggle="collapse"';
            echo ' data-toggle="button" class="btn btn-mini pull-right"';
            echo ' aria-label="' . JText::_('JGLOBAL_EXPAND_CATEGORIES') . '">';
            echo '<span class="icon-plus" aria-hidden="true"></span>';
            echo '</a>';
					}

          echo '</h3>';
				}

				if ($this->params->get('show_subcat_desc') == 1) {
					if ($child->description) {
						echo '<div class="category-desc">';
            echo JHtml::_('content.prepare', $child->description, '', 'com_content.category');
						echo '</div>';
					}
				}

				if ($this->maxLevel > 1 && count($child->getChildren()) > 0) {
					echo '<div class="collapse fade" id="category-' . $child->id . '">';

					$this->children[$child->id] = $child->getChildren();
					$this->category = $child;
					$this->maxLevel--;
					echo $this->loadTemplate('children');
					$this->category = $child->getParent();
					$this->maxLevel++;

					echo '</div>';
				}

        echo '</div>';
			}
		}
	}
}
