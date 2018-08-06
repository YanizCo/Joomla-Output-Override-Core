<?php

defined('_JEXEC') or die;

//JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$params = $displayData['params'];
$category = $displayData['category'];

if (!empty($category)) {
  // Detect if the article is a menu item
  $db = JFactory::getDBO();
  $query  = "SELECT COUNT(*)";
  $query .= " FROM #__menu";
  $query .= " WHERE link LIKE '%option=com_content%'";
  $query .= " AND link LIKE '%view=categor%'";
  $query .= " AND link LIKE '%id=" . $category->id . "';";
  $db->setQuery($query);
  $isInMenu = $db->loadResult();
} else {
  $isInMenu = false;
}
// IF the the article is not linked by a  menu item AND show_title is true
// OR the article is linked by a menu item AND show_page_heading is false
// AND show_title is true
// THEN use article title as the H1
// ELSE IF the article is linked by a menu item AND show_page_heading is true
// THEN use the page_heading as the H1 also in this condition
// IF show_title is true AND the two titles do not match
// THEN set an H2 to the article title

if (($params->get('show_category_title') && !$isInMenu) || ($isInMenu && !$params->get('show_page_heading') && $params->get('show_category_title'))) {
  $h1 = $this->escape($category->title);

  if (!empty($params->get('page_subheading'))) {
    $h2 = $this->escape($params->get('page_subheading'));
  }

} else if ($isInMenu && $params->get('show_page_heading')) {
  $h1 = $this->escape($params->get('page_heading'));

  if ($params->get('show_category_title') && $h1 != $this->escape($category->title)) {
    $h2 = $this->escape($params->get('page_subheading'));

    if ($params->get('show_category_title')) {
       $h2 .= '<span class="subheading-category">' . $category->title . '</span>';
    }
  }
}

echo '<header class="page-header">';

if (isset($h1)) {
  echo '<h1>' . $h1 . '</h1>';
}

if (isset($h2)) {
  echo '<div class="page-header">';

  if (isset($h2)) {
    echo '<h2 itemprop="headline">' . $h2 . '</h2>';
	}
}

echo '</header>';
