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
abstract class jpHtmlBase
{
	/**
	 * @var string
	 */
	protected $buffer = '';

	/**
	 * @var mixed[]
	 */
	protected $data = array();

	/**
	 * @var string
	 */
	protected $tag = 'div';

	/**
	 * @var string[]
	 */
	protected $class = '';

	/**
	 * @var string
	 */
	protected $id = '';

	/**
	 * @var jpHtmlBase
	 */
	protected $parentHelper = null;

	/**
	 * @param jpHtmlBase $parentHelper [optional] default null
	 */
	public function __construct(jpHtmlBase $parentHelper = null)
	{
		$this->parentHelper = $parentHelper;
	}

	/**
	 * Set the body data.
	 *
	 * @param mixed[] $data
	 * @return jpHtmlBase
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * Returns the current buffer.
	 *
	 * @param bool $reset Set to true if you want to reset the buffer.
	 * @return string
	 */
	public function getBuffer($reset = false)
	{
		$buffer = $this->buffer;

		if($reset) {
			$this->buffer = '';
		}

		return $buffer;
	}

	/**
	 * @param string $buffer
	 * @return jpHtmlBase
	 */
	public function addBuffer($buffer = '')
	{
		$this->buffer .= $buffer;
		return $this;
	}

	/**
	 * @return jpHtmlBase
	 */
	public function resetBuffer()
	{
		$this->buffer = '';
		return $this;
	}

	/**
	 * @param string $class
	 * @return jpHtmlBase
	 */
	public function addClass($class)
	{
		if(!empty($this->class)) {
			$this->class .= ' ';
		}

		$this->class .= $class;
		return $this;
	}

	/**
	 * @param string $class
	 * @return jpHtmlBase
	 */
	public function removeClass($class)
	{
		$this->class = str_replace($class, '', $this->class);
		return $this;
	}

	/**
	 * @param string $id
	 * @return jpHtmlBase
	 */
	public function setID($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @return string
	 */
	protected function getAttribute($name, $value)
	{
		if(!empty($value)) {
			return ' '.$name.'="'.$value.'"';
		}

		return '';
	}

	/**
	 * @param string $id [optinal] default null
	 * @param string $class [optinal] default null
	 * @param string $flush [optinal] default false
	 * @param string $reset [optinal] default true
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

		$this->addBuffer (
			'<'.$this->tag
				. $this->getAttribute('class', $class)
				. $this->getAttribute('id', $id)
			.'>'
		);

		return $this;
	}

	/**
	 * @param bool $flush [optional] default false
	 * @param bool $reset [optional] default true
	 * @return jpHtmlBase
	 */
	public function commit($flush = true, $reset = true)
	{
		$this->addBuffer('</'.$this->tag.'>');

		if($flush) {
			$this->flush($reset);
		}

		return $this;
	}

	/**
	 * Flush the buffer to the out stream or if a parent helper isset, than the
	 * current buffer added to the parent helper buffer and resetted. Afterwards
	 * you can use the current helper as a new fresh empty buffer.
	 *
	 * @param bool $reset [optional] default true
	 * @param bool $tidy [optional] default false
	 * @return jpHtmlBase
	 */
	public function flush($reset = true, $tidy = false)
	{
		if($this->parentHelper !== null) {
			$this->parentHelper->addBuffer($this->getBuffer($reset));
		} else if ($tidy && class_exists('tidy', false)) {
			$tidy = new tidy();
			$buffer = $tidy->repairString (
				$this->getBuffer($reset),
				array (
					'indent' => 2,
					'vertical-space' => false,
					'force-output' => true,
					'wrap' => 0
				),
				'utf8'
			);
			$buffer = preg_replace("/\n([\s]*)\n/", "\r\n", $buffer);
			echo $buffer;
		} else {
			echo $this->getBuffer($reset);
		}

		return $this;
	}

	/**
	 * @param jpHtmlBase $parentHelper
	 * @return jpHtmlBase
	 */
	public function setParentHelper(jpHtmlBase $parentHelper)
	{
		$this->parentHelper = $parentHelper;
		return $this;
	}

	/**
	 * @return jpHtmlBase
	 */
	public function resetParentHelper()
	{
		$this->parentHelper = null;
		return $this;
	}
}
