<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');


if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) {
  foreach ($this->items[$this->parent->id] as $id => $item) {
    echo '<section class="item column-1 span12" itemprop="blogPost" itemscope="" itemtype="https://schema.org/BlogPosting">';
    echo '<h2 class="item-title" itemprop="headline">' . $this->escape($item->title) . '</h2>';

    if ($this->params->get('show_description_image') && $item->getParams()->get('image')) {
      $src = $item->getParams()->get('image');
      $alt = htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8');
      echo '<img src="' . $src . '" alt="' . $alt . '" />';
    }

    if ($this->params->get('show_subcat_desc_cat') == 1 && $item->description) {
      echo JHtml::_('content.prepare', $item->description, '', 'com_content.categories');
    }

    $href = JRoute::_(ContentHelperRoute::getCategoryRoute($item->id, $item->language));
    echo JLayoutHelper::render('joomla.content.readmore', array('item' => $item, 'params' => $this->params, 'link' => $href));

    echo '</section>';

  }
}
