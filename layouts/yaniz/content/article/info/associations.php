<?php

defined('JPATH_BASE') or die;

$item = $displayData['item'];

if (!empty($item->associations)) {

  $associations = $item->associations;

  echo '<dd class="association">';
	echo JText::_('JASSOCIATIONS');

  foreach ($associations as $association) {
		if ($item->params->get('flags', 1) && $association['language']->image) {
			$flag = JHtml::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array('title' => $association['language']->title_native), true);
			echo '&nbsp;<a href="' . JRoute::_($association['item']) . '">' . $flag . '</a>&nbsp;';
		} else {
			$class = 'label label-association label-' . $association['language']->sef;
			echo '&nbsp;<a class="' . $class . '" href="' . JRoute::_($association['item']) . '">' . strtoupper($association['language']->sef) . '</a>&nbsp;';
		}
	}

  echo '</dd>';
}
