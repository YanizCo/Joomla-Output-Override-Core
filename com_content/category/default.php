<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

$cssClass = 'category-list' . $this->pageclass_sfx;

echo '<section class="' . $cssClass . '">';
$this->subtemplatename = 'articles';
echo JLayoutHelper::render('joomla.content.category_default', $this);
echo '</section>';
