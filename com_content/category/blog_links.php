<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

echo '<div class="items-more">';
echo '<ol class="nav nav-tabs nav-stacked">';

foreach ($this->link_items as &$item) {
  echo '<li>';
  echo '<a href="' . JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)) . '">';
  echo $item->title;
  echo '</a></li>';
}

echo '</ol></div>';
