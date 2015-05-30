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
class jpHtmlList extends jpHtmlBase
{
	/**
	 * @var string
	 */
	protected $tag = 'ul';

	/**
	 * @param string $type
	 * @return jpHtmlList
	 */
	public function setListType($type)
	{
		$this->tag = $type;
		return $this;
	}

	/**
	 * @return jpHtmlList
	 */
	public function addItems()
	{
		foreach($this->data as $item) {
			$buffer .= '<li>';

			if(is_array($item)) {
				$buffer .= array_shift($item);
				$this->addSubList($item, $buffer);
			} else {
				$buffer .= $item;
			}

			$buffer .= '</li>';
		}

		$this->addBuffer($buffer);
		return $this;
	}

	/**
	 * @param mixed[] $data
	 * @param string $buffer
	 */
	private function addSubList($data, &$buffer)
	{
		$class = '';
		$type = 'ul';

		if(!empty($data['config']['class'])) {
			$class = $data['config']['class'];
		}

		if(!empty($data['config']['type'])) {
			$type = $data['config']['type'];
		}

		$buffer .= '<'.$type.' '.$class.'>';

		foreach($data as $value) {
			$buffer .= '<li>';

			if(is_array($value)) {
				$buffer .= array_shift($value);
				$this->addSubList($type, $class, $value, $buffer);
			} else {
				$buffer .= $value;
			}

			$buffer .= '</li>';
		}

		$buffer .= '</'.$type.'>';
	}
}
