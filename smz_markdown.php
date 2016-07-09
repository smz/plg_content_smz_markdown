<?php
/**
 * @package         SMZ_Markdown
 * @version         1.0.0
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
	function plgContentSMZ_Markdown( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

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
						return true;
					}
				case strpos($context, 'mod_custom') === 0 && $this->params->get('smz_markdown_filter_mod_custom', 0):
				case strpos($context, 'com_search') === 0 && $this->params->get('smz_markdown_filter_com_search', 0):
					return $this->applyMarkdown($row->text, $params);
			}
		}
		return true;
	}

	protected function applyMarkdown(&$text, &$params)
	{
		$classes_path = dirname(__FILE__) . '/classes';
		require_once($classes_path . '/erusev/Parsedown.php');
		require_once($classes_path . '/erusev/ParsedownExtra.php');

		$mdclass = new ParsedownExtra();
		$text = $mdclass->text($text);

		return true;
	}
}
