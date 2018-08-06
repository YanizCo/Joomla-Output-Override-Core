<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$params    = &$this->item->params;
$n         = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items)) {
	foreach ($this->items as $article) {
		if ($article->params->get('access-edit')) {
			$isEditable = true;
			break;
		}
	}
}

// For B/C we also add the css classes inline. This will be removed in 4.0.
JFactory::getDocument()->addStyleDeclaration('
.hide { display: none; }
.table-noheader { border-collapse: collapse; }
.table-noheader thead { display: none; }
');

$tableClass = $this->params->get('show_headings') != 1 ? ' table-noheader' : '';

$formAction = htmlspecialchars(JUri::getInstance()->toString());
echo '<form action="' . $formAction . '" method="post" name="adminForm" id="adminForm" class="form-inline">';

if ($this->params->get('filter_field') !== 'hide' || $this->params->get('show_pagination_limit')) {
	echo '<fieldset class="filters btn-toolbar clearfix">';
	echo '<legend class="hide">' . JText::_('COM_CONTENT_FORM_FILTER_LEGEND') . '</legend>';

  if ($this->params->get('filter_field') !== 'hide') {
		echo '<div class="btn-group">';
		if ($this->params->get('filter_field') !== 'tag') {
			echo '<label class="filter-search-lbl element-invisible" for="filter-search">';
			echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '&#160;';
			echo '</label>';

			echo '<input type="text" name="filter-search" id="filter-search"';
			echo ' value="' . $this->escape($this->state->get('list.filter')) . '"';
			echo ' class="inputbox" onchange="document.adminForm.submit();"';
			echo 'title="' . JText::_('COM_CONTENT_FILTER_SEARCH_DESC') . '"';
			echo ' placeholder="' . JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '" />';
		} else {
			echo '<select name="filter_tag" id="filter_tag" onchange="document.adminForm.submit();" >';
			echo '<option value="">' .  JText::_('JOPTION_SELECT_TAG') . '</option>';
			echo JHtml::_('select.options', JHtml::_('tag.options', true, true), 'value', 'text', $this->state->get('filter.tag'));
			echo '</select>';
		}

		echo '</div>';
	}

	if ($this->params->get('show_pagination_limit')) {
		echo '<div class="btn-group pull-right">';
		echo '<label for="limit" class="element-invisible">';
		echo JText::_('JGLOBAL_DISPLAY_NUM');
		echo '</label>';
		echo $this->pagination->getLimitBox();
		echo '</div>';
	}

	echo '<input type="hidden" name="filter_order" value="" />';
	echo '<input type="hidden" name="filter_order_Dir" value="" />';
	echo '<input type="hidden" name="limitstart" value="" />';
	echo '<input type="hidden" name="task" value="" />';
	echo '</fieldset>';

	echo '<div class="control-group hide pull-right">';
	echo '<div class="controls">';
	echo '<button type="submit" name="filter_submit" class="btn btn-primary">';
	echo JText::_('COM_CONTENT_FORM_FILTER_SUBMIT');
	echo '</button>';
	echo '</div>';
	echo '</div>';

}

if (empty($this->items)) {
	if ($this->params->get('show_no_articles', 1)) {
		echo '<p>' . JText::_('COM_CONTENT_NO_ARTICLES') . '</p>';
	}
} else {
	echo '<table class="category table table-striped table-bordered table-hover' . $tableClass . '">';
	echo '<caption class="hide">' . JText::sprintf('COM_CONTENT_CATEGORY_LIST_TABLE_CAPTION', $this->category->title) . '</caption>';
	echo '<thead>';
	echo '<tr>';
	echo '<th scope="col" id="categorylist_header_title">';
	echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder, null, 'asc', '', 'adminForm');
	echo '</th>';

	if ($date = $this->params->get('list_show_date')) {
		echo '<th scope="col" id="categorylist_header_date">';

		if ($date === 'created') {
			echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.created', $listDirn, $listOrder);
		} elseif ($date === 'modified') {
			echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.modified', $listDirn, $listOrder);
		} elseif ($date === 'published') {
			echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.publish_up', $listDirn, $listOrder);
		}

		echo '</th>';
	}

	if ($this->params->get('list_show_author')) {
		echo '<th scope="col" id="categorylist_header_author">';
		echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder);
		echo '</th>';
	}

	if ($this->params->get('list_show_hits')) {
		echo '<th scope="col" id="categorylist_header_hits">';
		echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder);
		echo '</th>';
	}

	if ($this->params->get('list_show_votes', 0) && $this->vote) {
		echo '<th scope="col" id="categorylist_header_votes">';
		echo JHtml::_('grid.sort', 'COM_CONTENT_VOTES', 'rating_count', $listDirn, $listOrder);
		echo '</th>';
	}

	if ($this->params->get('list_show_ratings', 0) && $this->vote) {
		echo '<th scope="col" id="categorylist_header_ratings">';
		echo JHtml::_('grid.sort', 'COM_CONTENT_RATINGS', 'rating', $listDirn, $listOrder);
		echo '</th>';
	}

	if ($isEditable) {
		echo '<th scope="col" id="categorylist_header_edit">' . JText::_('COM_CONTENT_EDIT_ITEM') . '</th>';
	}

	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

	foreach ($this->items as $i => $article) {
		if ($this->items[$i]->state == 0) {
			echo '<tr class="system-unpublished cat-list-row' . ($i % 2) . '">';
		} else {
			echo '<tr class="cat-list-row' . ($i % 2) . '">';
		}

		echo '<td headers="categorylist_header_title" class="list-title">';
		if (in_array($article->access, $this->user->getAuthorisedViewLevels())) {
			$href = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language));
			echo '<a href="' . $href . '">' .  $this->escape($article->title) . '</a>';

			if (JLanguageAssociations::isEnabled() && $this->params->get('show_associations')) {
				$associations = ContentHelperAssociation::displayAssociations($article->id);

				foreach ($associations as $association) {
					if ($this->params->get('flags', 1) && $association['language']->image) {
						$flag = JHtml::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true);
						echo '&nbsp;<a href="' . JRoute::_($association['item']) . '">' . $flag . '</a>&nbsp;';
					} else {
						$class = 'label label-association label-' . $association['language']->sef;
						echo '&nbsp;<a class="' . $class . '" href="' . JRoute::_($association['item']) . '">' . strtoupper($association['language']->sef) . '</a>&nbsp';
					}
				}
			}
		} else {
			echo $this->escape($article->title) . ' : ';
			$menu = JFactory::getApplication()->getMenu();
			$active = $menu->getActive();
			$itemId = $active->id;
			$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
			$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)));

			echo '<a href="' . $link . '" class="register">';
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
			echo '</a>';

			if (JLanguageAssociations::isEnabled() && $this->params->get('show_associations')) {
				$associations = ContentHelperAssociation::displayAssociations($article->id);
				foreach ($associations as $association) {
					if ($this->params->get('flags', 1)) {
						$flag = JHtml::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true);
						echo '&nbsp;<a href="' . JRoute::_($association['item']) . '">' . $flag . '</a>&nbsp;';
					} else {
						$class = 'label label-association label-' . $association['language']->sef;
						echo '&nbsp;<a class="' . $class . '" href="' . JRoute::_($association['item']) . '">' . strtoupper($association['language']->sef) . '</a>&nbsp';
					}
				}
			}
		}

		if ($article->state == 0) {
			echo '<span class="list-published label label-warning">';
			echo JText::_('JUNPUBLISHED');
			echo '</span>';
		}

		if (strtotime($article->publish_up) > strtotime(JFactory::getDate())) {
			echo '<span class="list-published label label-warning">';
			echo JText::_('JNOTPUBLISHEDYET');
			echo '</span>';
		}

		if ((strtotime($article->publish_down) < strtotime(JFactory::getDate())) && $article->publish_down != JFactory::getDbo()->getNullDate()) {
			echo '<span class="list-published label label-warning">';
			echo JText::_('JEXPIRED');
			echo '</span>';
		}

		echo '</td>';

		if ($this->params->get('list_show_date')) {
			echo '<td headers="categorylist_header_date" class="list-date small">';
			echo JHtml::_('date', $article->displayDate, $this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3'))));
			echo '</td>';
		}

		if ($this->params->get('list_show_author', 1)) {
			echo '<td headers="categorylist_header_author" class="list-author">';

			if (!empty($article->author) || !empty($article->created_by_alias)) {
				$author = $article->author;
				$author = $article->created_by_alias ?: $author;
				if (!empty($article->contact_link) && $this->params->get('link_author') == true) {
					echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $article->contact_link, $author));
				} else {
					echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author);
				}
			}

			echo '</td>';
		}

		if ($this->params->get('list_show_hits', 1)) {
			echo '<td headers="categorylist_header_hits" class="list-hits">';
			echo '<span class="badge badge-info">';
			echo JText::sprintf('JGLOBAL_HITS_COUNT', $article->hits);
			echo '</span>';
			echo '</td>';
		}

		if ($this->params->get('list_show_votes', 0) && $this->vote) {
			echo '<td headers="categorylist_header_votes" class="list-votes">';
			echo '<span class="badge badge-success">';
			echo JText::sprintf('COM_CONTENT_VOTES_COUNT', $article->rating_count);
			echo '</span>';
			echo '</td>';
		}

		if ($this->params->get('list_show_ratings', 0) && $this->vote) {
			echo '<td headers="categorylist_header_ratings" class="list-ratings">';
			echo '<span class="badge badge-warning">';
			echo JText::sprintf('COM_CONTENT_RATINGS_COUNT', $article->rating);
			echo '</span>';
			echo '</td>';
		}

		if ($isEditable) {
			echo '<td headers="categorylist_header_edit" class="list-edit">';
			if ($article->params->get('access-edit')) {
				echo JHtml::_('icon.edit', $article, $params);
			}

			echo '</td>';
		}

		echo '</tr>';
	}

	echo '</tbody>';
	echo '</table>';
}

// Code to add a link to submit an article.
if ($this->category->getParams()->get('access-create')) {
	echo JHtml::_('icon.create', $this->category, $this->category->params);
}

// Add pagination links
if (!empty($this->items)) {
	if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) {
		echo '<div class="pagination">';

		if ($this->params->def('show_pagination_results', 1)) {
			echo '<p class="counter pull-right">';
			echo $this->pagination->getPagesCounter();
			echo '</p>';
		}

		echo $this->pagination->getPagesLinks();
		echo '</div>';
	}
}

echo '</form>';
