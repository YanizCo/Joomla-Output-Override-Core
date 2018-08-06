<?php

defined('JPATH_BASE') or die;

// Create a shortcut for params.
$params = $displayData->params;
$canEdit = $displayData->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

if ($displayData->state == 0 || $params->get('show_title') || ($params->get('show_author') && !empty($displayData->author ))) {
	echo '<header class="page-header">';

  if ($params->get('show_title')) {
		echo '<h2 itemprop="name">';
		if ($params->get('link_titles') && ($params->get('access-view') || $params->get('show_noauth', '0') == '1')) {
      $link = JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language));;
	    echo '<a href="' . $link . '" itemprop="url">';
			echo $this->escape($displayData->title);
			echo '</a>';
		} else {
			echo $this->escape($displayData->title);
		}

    echo '</h2>';
	}

	if ($displayData->state == 0) {
		echo '<span class="label label-warning">' . JText::_('JUNPUBLISHED') . '</span>';
	}

	if (strtotime($displayData->publish_up) > strtotime(JFactory::getDate())) {
		echo '<span class="label label-warning">' . JText::_('JNOTPUBLISHEDYET') . '</span>';
  }

	if ($displayData->publish_down != JFactory::getDbo()->getNullDate()
			&& (strtotime($displayData->publish_down) < strtotime(JFactory::getDate()))) {
		echo '<span class="label label-warning">' . JText::_('JEXPIRED') . '</span>';
	}

  echo '</header>';
}
