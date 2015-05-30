<?php
/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.1
 * @license MIT - http://opensource.org/licenses/MIT
 */

if (!defined('_JPEXEC')) {
	die ('RESTRICTED ACCESS');
}

/**
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.1
 * @license MIT - http://opensource.org/licenses/MIT
 */
class jpHtmlNavlist extends jpHtmlBase
{
	/**
	 * @param type $link
	 * @param type $title
	 * @param type $id [optional] default: empty string
	 * @param type $class [optional] default: empty string
	 * @param type $icon [optional] default: empty string
	 * @return jpHtmlNavlist
	 */
	public function addItem($link, $title, $id = '', $class = '', $icon = '')
	{
		$this->data[$link] = array (
			'link' => $link,
			'title' => $title,
			'id' => $id,
			'class' => $class,
			'icon' => $icon,
		);
		return $this;
	}

	/**
	 * @param array $items
	 * @return jpHtmlNavlist
	 */
	public function setItems(array $items)
	{
		$this->data = $items;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getItems()
	{
		return $this->data;
	}

	/**
	 * @param string $id [optinal] default null
	 * @param string $class [optinal] default null
	 * @return jpHtmlBase
	 */
	public function begin($id = null, $class = null)
	{
		if($class === null) {
			$class = $this->class;
		}

		if($id === null) {
			$id = $this->id;
		}

		if(!empty($class)) {
			$class = ' '.$class;
		}

		$this->addBuffer (
			'<ul'
				. $this->getAttribute('class', 'nav nav-pills nav-stacked'.$class)
				. $this->getAttribute('id', $id)
			. '>'
		);

		return $this;
	}

	/**
	 * @return jpHtmlNavlist
	 */
	public function addItems()
	{
		foreach($this->getItems() as $item) {
			$icon = '';

			if(!empty($item['icon'])) {
				$icon = '<span class="glyphicon glyphicon-'.$item['icon'].'"></span> ';
			}

			$active = '';

			if(strpos($_SERVER['REQUEST_URI'], $item['link']) !== false) {
				$active = ' class="active"';
			}

			$this->addBuffer (
				'<li'.$active.'>'
					. '<a'.$this->getAttribute('id', $item['id'])
						.$this->getAttribute('class', $item['class'])
						.$this->getAttribute('href', $item['link'])
						.'>'
							. $icon . $item['title']
					. '</a>'
				. '</li>'
			);
		}
		return $this;
	}

	/**
	 * @param bool $flush [optional] default true
	 * @param bool $reset [optional] default true
	 * @return jpHtmlBase
	 */
	public function commit($flush = true, $reset = true)
	{
		$this->addBuffer('</ul>');

		if($flush) {
			$this->flush($reset);
		}

		return $this;
	}
}
