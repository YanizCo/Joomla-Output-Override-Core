<?php

defined('_JEXEC') or die;

$params = &$this->item->params;

if ($params->get('access-view')) {
  $link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
} else {
	$menu = JFactory::getApplication()->getMenu();
	$active = $menu->getActive();
	$itemId = $active->id;
	$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
	$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
}

echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link));
