<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$params = $displayData['params'];
$item = $displayData['item'];
$direction = JFactory::getLanguage()->isRtl() ? 'left' : 'right';
$href = $displayData['link'];
$html = '<span class="icon-chevron-' . $direction . '" aria-hidden="true"></span>';

// Added in default value of 'true' to make this work with the Categories list
// this could have been a mistake.  Needs further testing.
if ($params->get('access-view', true) === false) {
  $label = JText::_('COM_CONTENT_REGISTER_TO_READ_MORE') . " " . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');
  $html .= JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
}/* elseif ($readmore = $item->alternative_readmore) {
  $label = htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');
  $html .= $readmore;

  if ($params->get('show_readmore_title', 0) != 0) {
    $html .= JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
  }

}*/ elseif ($params->get('show_readmore_title', 0) == 0) {
  $label = JText::_('COM_CONTENT_READ_MORE') . ' ' . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');
  $html .= JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
} else {
  $label = JText::_('COM_CONTENT_READ_MORE') . ' ' . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');
  $html .= JText::_('COM_CONTENT_READ_MORE') . ' ' . JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
}

echo '<p class="readmore">';
echo '<a href="' . $href . '" class="btn" itemprop="url" aria-label="' . $label . '">' . $html . '</a>';
echo '</p>';
