<?php

defined('JPATH_BASE') or die;

$author = ($displayData['item']->created_by_alias ?: $displayData['item']->author);
$author = '<span itemprop="name">' . $author . '</span>';

echo '<dd class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">';

if (!empty($displayData['item']->contact_link ) && $displayData['params']->get('link_author') == true) {
	echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url')));
} else {
	echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author);
}

echo '</dd>';
