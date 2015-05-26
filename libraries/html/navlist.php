<?php
/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.0
 * @license MIT - http://opensource.org/licenses/MIT
 */

if (!defined('_JPEXEC')) {
	die ('RESTRICTED ACCESS');
}

/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.0
 * @license MIT - http://opensource.org/licenses/MIT
 */
class jpHtmlNavlist extends jpHtmlBase
{
	/**
	 * @var mixed[]
	 */
	protected $classSfx = '';

	/**
	 * @param type $link
	 * @param type $title
	 * @param type $icon
	 */
	public function addItem($link, $title, $id, $icon)
	{
		$this->_data[$link] = array (
			'link' => $link,
			'title' => $title,
			'id' => $id,
			'icon' => $icon,
		);
	}

	/**
	 * @param array $items
	 */
	public function setItems(array $items)
	{
		$this->data = $items;
	}

	/**
	 * @return array
	 */
	public function getItems()
	{
		return $this->data;
	}

	/**
	 * @param string $classSfx
	 */
	public function setClassSfx($classSfx)
	{
		$this->classSfx = $classSfx;
	}

	/**
	 * @return string
	 */
	public function getClassSfx()
	{
		return $this->classSfx;
	}

	/**
	 * @return string
	 */
	public function render($render = true)
	{
		$buffer = '<ul class="nav nav-list">';

		foreach($this->getItems() as $item) {
			$id = '';
			$icon = '';

			if(!empty($item['id'])) {
				$id = ' id="'.$item['id'].'"';
			}

			if(!empty($item['icon'])) {
				$icon = '<span class="glyphicon glyphicon-'.$item['icon'].'"></span>';
			}

			$buffer .= '<li><a'.$id.' href="'.$item['link'].'">'.$icon.$item['title'].'</a></li>';
		}

		$buffer .= '</ul>';

		if($render) {
			echo $buffer;
		} else {
			return $buffer;
		}
	}
}
