<?php

defined('_JEXEC') or die;

//JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$params = $displayData['params'];
$item = $displayData['item'];
if (!empty($displayData['print'])) {
  $print = $displayData['print'];
} else {
  $print = false;
}
$canEdit = $params->get('access-edit');
$info = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));

$useDefList = ($params->get('show_modify_date')
             || $params->get('show_publish_date')
             || $params->get('show_create_date')
             || $params->get('show_hits')
             || $params->get('show_category')
             || $params->get('show_parent_category')
             || $params->get('show_author')
             || $assocParam);

// Detect if the article is a menu item
$db = JFactory::getDBO();
$query  = "SELECT COUNT(*)";
$query .= " FROM #__menu";
$query .= " WHERE link LIKE '%option=com_content%'";
$query .= " AND link LIKE '%view=article%'";
$query .= " AND link LIKE '%id=" . $item->id . "';";
$db->setQuery($query);
$isInMenu = $db->loadResult();

// IF the the article is not linked by a  menu item AND show_title is true
// OR the article is linked by a menu item AND show_page_heading is false
// AND show_title is true
// THEN use article title as the H1
// ELSE IF the article is linked by a menu item AND show_page_heading is true
// THEN use the page_heading as the H1 also in this condition
// IF show_title is true AND the two titles do not match
// THEN set an H2 to the article title
/*
$d  = "<p>";
$d .= "params->get('show_title') = " . (($params->get('show_title')) ? "true" : "false") . "<br />";
$d .= "isInMenu = " . (($isInMenu) ? "true" : "false") . "<br />";
$d .= "params->get('show_page_heading') = " . (($params->get('show_page_heading')) ? "true" : "false") . "<br />";
$d .= "item->title = " . $item->title . "<br />";
$d .= "params->get('page_heading') = " . $params->get('page_heading') . "<br />";
$d .= "</p>";
die($d);
*/
if (($params->get('show_title') && !$isInMenu) || ($isInMenu && !$params->get('show_page_heading') && $params->get('show_title'))) {
  $h1 = $this->escape($item->title);
} else if ($isInMenu && $params->get('show_page_heading')) {
  $h1 = $this->escape($params->get('page_heading'));

  if ($params->get('show_title') && $h1 != $this->escape($item->title)) {
    $h2 = $this->escape($item->title);
  }
}



echo '<header class="page-header">';

if (!empty($h1)) {
  echo '<h1>' . $h1 . '</h1>';
}

if (!empty($item->pagination) && $item->pagination && !$item->paginationposition && $item->paginationrelative) {
	echo $item->pagination;
}

$useDefList = ($params->get('show_modify_date')
               || $params->get('show_publish_date')
               || $params->get('show_create_date')
               || $params->get('show_hits')
               || $params->get('show_category')
               || $params->get('show_parent_category')
               || $params->get('show_author')
               || $assocParam);

if (!$useDefList && $print) {
	echo '<div id="pop-print" class="btn hidden-print">'
        . JHtml::_('icon.print_screen', $item, $params)
        . '</div>';
}

if (isset($h2)) {
  echo '<div class="page-header">';

  if (isset($h2)) {
    echo '<h2 itemprop="headline">' . $h2 . '</h2>';
	}

  if ($item->state == 0) {
		echo '<span class="label label-warning">'
          . JText::_('JUNPUBLISHED')
          . '</span>';
	}

  if (strtotime($item->publish_up) > strtotime(JFactory::getDate())) {
    echo '<span class="label label-warning">' . JText::_('JNOTPUBLISHEDYET') . '</span>';
	}

	if ((strtotime($item->publish_down) < strtotime(JFactory::getDate())) && $item->publish_down != JFactory::getDbo()->getNullDate()) {
		echo '<span class="label label-warning">' . JText::_('JEXPIRED') . '</span>';
  }

  echo '</div>';
}

if (!$print){
	if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) {
		JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $item, 'print' => false));
	}
} else {
	if ($useDefList) {
		echo '<div id="pop-print" class="btn hidden-print">' . JHtml::_('icon.print_screen', $item, $params) . '</div>';
	}
}

if ($useDefList && ($info == 0 || $info == 2)) {
	echo JLayoutHelper::render('yaniz.content.article.info', array('item' => $item, 'params' => $params, 'position' => 'above'));
}

echo "</header>";
