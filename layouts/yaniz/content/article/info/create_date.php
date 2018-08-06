<?php

defined('JPATH_BASE') or die;

$item = $displayData['item'];

echo '<dd class="create">';
echo '<span class="icon-calendar" aria-hidden="true"></span>';
echo '<time datetime="' . JHtml::_('date', $item->created, 'c') , '" itemprop="dateCreated">';
echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $item->created, JText::_('l, F j, Y, g:i A')))));
echo '</time>';
echo '</dd>';
