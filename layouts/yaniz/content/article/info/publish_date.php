<?php

defined('JPATH_BASE') or die;

$item = $displayData['item'];

echo '<dd class="published">';
echo '<span class="icon-calendar" aria-hidden="true"></span>';
echo '<time datetime="' . JHtml::_('date', $item->publish_up, 'c') . '" itemprop="datePublished">';
echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $item->publish_up, JText::_('l, F j, Y, g:i A')));
echo '</time>';
echo '</dd>';
