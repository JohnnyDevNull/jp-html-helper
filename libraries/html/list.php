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
class jpHtmlList extends jpHtmlBase
{
	/**
	 * @var string[]
	 */
	protected $class = array('table');

	/**
	 * @var string
	 */
	protected $width = '';

	/**
	 * @var string
	 */
	protected $listType = 'ul';

	/**
	 * @param string $type
	 */
	public function setListType($type)
	{
		$this->listType = $type;
	}

	/**
	 * @param string $class
	 * @return $this
	 */
	public function addClass($class)
	{
		if(!in_array($class, $this->class)) {
			$this->class[] = $class;
		}

		return $this;
	}

	/**
	 * @param string $width
	 * @return $this
	 */
	public function setWidth($width)
	{
		$this->width = $width;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function begin()
	{
		$class = '';

		if(!empty($this->class)) {
			$class = 'class="'.implode(' ',$this->class).'"';
		}

		$width = '';

		if(!empty($this->width)) {
			$width = 'width="'.$this->width.'"';
		}

		$this->buffer = '<'.$this->listType.' '.$class.' '.$width.'>';
		return $this;
	}

	/**
	 * @return $this
	 */
	public function commit()
	{
		$this->buffer .= '</'.$this->listType.'>';
		return $this;
	}

	/**
	 * @return $this
	 */
	public function renderItems()
	{
		foreach($this->data as $item) {
			$buffer .= '<li>';

			if(is_array($item)) {
				$buffer .= array_shift($item);
				$this->renderSubList($item, $buffer);
			} else {
				$buffer .= $item;
			}

			$buffer .= '</li>';
		}

		$this->addBuffer($buffer);
	}

	/**
	 * @param mixed[] $data
	 * @param string $buffer
	 */
	private function renderSubList($data, &$buffer)
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
				$this->renderSubList($type, $class, $value, $buffer);
			} else {
				$buffer .= $value;
			}

			$buffer .= '</li>';
		}

		$buffer .= '</'.$type.'>';
	}
}
