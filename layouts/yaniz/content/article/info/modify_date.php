<?php

defined('JPATH_BASE') or die;

$item = $displayData['item'];

echo '<dd class="modified">';
echo '<span class="icon-calendar" aria-hidden="true"></span>';
echo '<time datetime="' . JHtml::_('date', $item->modified, 'c') . '" itemprop="dateModified">';
echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('l, F j, Y, g:i A')))));
echo '</time>';
echo '</dd>';
