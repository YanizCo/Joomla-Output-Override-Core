<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

$params = $this->params;
//$category = $this->category;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');
JHtml::_('behavior.core');

// Get the main category description.
$itemKey = (array_keys($this->items))[0];
$item = ($this->items[$itemKey])[0];
$description = $item->getParent()->description;


$cssClass = 'categories-list' . $this->pageclass_sfx;
echo '<section class="' . $cssClass . '" itemscope itemtype="https://schema.org/Blog">';
echo JLayoutHelper::render('yaniz.content.category.header', array('category' => $this->parent, 'params' => $params));
echo $description;
echo $this->loadTemplate('items');
echo '</section>';
