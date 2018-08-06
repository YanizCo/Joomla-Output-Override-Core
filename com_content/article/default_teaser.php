<?php

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$item = $this->item;
$params = $item->params;

// Optional teaser intro text for guests
echo JLayoutHelper::render('joomla.content.intro_image', $item);
echo JHtml::_('content.prepare', $item->introtext);

// Optional link to let them register to see the whole article.
if ($params->get('show_readmore') && $item->fulltext != null) {
  $menu = JFactory::getApplication()->getMenu();
  $active = $menu->getActive();
  $itemId = $active->id;
  $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
  $link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)));
  echo '<p class="readmore"><a href="' . $link . '" class="register">';

  $attribs = json_decode($item->attribs);

	if ($attribs->alternative_readmore == null) {
		echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
	} elseif ($readmore = $attribs->alternative_readmore) {
		echo $readmore;

    if ($params->get('show_readmore_title', 0) != 0) {
			echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
		}

	} elseif ($params->get('show_readmore_title', 0) == 0) {
		echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
  } else {
		echo JText::_('COM_CONTENT_READ_MORE');
		echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
	}

	echo '</a></p>';
}
