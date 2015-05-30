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
class jpHtmlCol extends jpHtmlBase
{
	/**
	 * @var string
	 */
	protected $type = 'md';

	/**
	 * @var string
	 */
	protected $size = '12';

	/**
	 * @param string $type
	 * @return jpHtmlCol
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @param string $size
	 * @return jpHtmlCol
	 */
	public function setSize($size)
	{
		$this->size = $size;
		return $this;
	}

	/**
	 * @param string $type [optinal] default null
	 * @param string $size [optinal] default null
	 * @param string $id [optinal] default null
	 * @param string $class [optinal] default null
	 * @return jpHtmlCol
	 */
	public function begin($type = null, $size = null, $id= '', $class = '')
	{
		if($type === null) {
			$type = $this->type;
		}

		if($size === null) {
			$size = $this->size;
		}

		if($class === null) {
			$class = $this->class;
		}

		if($id === null) {
			$id = $this->id;
		}

		$colClass = 'col-'.$type.'-'.$size;

		if(!empty($this->class))
		{
			$colClass .= ' ';
		}

		$this->addBuffer(
			'<div '
				. 'class="'.$colClass.$class.'"'
				. $this->getAttribute('id', $id)
			. '>'
		);

		return $this;
	}
}
