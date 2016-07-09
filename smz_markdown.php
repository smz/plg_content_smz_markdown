<?php
/**
 * @package         SMZ_Markdown
 * @version         1.1.0
 *
 * @author          Sergio Manzi <smz@smz.it>
 * @link            http://smz.it
 * @copyright       Copyright © 2014 Sergio Manzi All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgContentSMZ_Markdown extends JPlugin
{
	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		if (is_object($row))
		{
			switch (true)
			{
				case strpos($context, 'com_content') === 0:
					$categories = $this->params->get('smz_markdown_categories', array());
					if (empty($categories) || (!in_array(0, $categories) && !in_array($row->catid, $categories)))
					{
						break;
					}
				case strpos($context, 'mod_custom') === 0 && $this->params->get('smz_markdown_mod_custom', 0):
				case strpos($context, 'com_search') === 0 && $this->params->get('smz_markdown_com_search', 0):
					require_once(__DIR__ . '/classes/erusev/Parsedown.php');
					require_once(__DIR__ . '/classes/erusev/ParsedownExtra.php');
					$mdclass = new ParsedownExtra();
					$row->text = $mdclass->text($row->text);
			}
		}
		return true;
	}
}
