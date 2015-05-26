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
abstract class jpHtmlBase
{
	/**
	 * @var mixed[]
	 */
	protected $data = array();

	/**
	 * @var string
	 */
	protected $buffer = '';

	/**
	 * @var bool
	 */
	protected $bufferMode = false;

	/**
	 * Set the body data.
	 *
	 * @param mixed[] $data
	 * @return $this
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
		$ret = $this->buffer;

		if($reset) {
			$this->buffer = '';
		}

		return $ret;
	}

	/**
	 * Adds the given string to the buffer
	 *
	 * @param string $buffer
	 */
	public function addBuffer($buffer = '')
	{
		$this->buffer.= $buffer;
	}

	/**
	 * Resets the buffer to an empty string.
	 */
	public function resetBuffer()
	{
		$this->buffer = '';
	}

	/**
	 * @param bool $bool
	 * @return $this
	 */
	public function setBufferMode($bool)
	{
		$this->bufferMode = (bool)$bool;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getBufferMode()
	{
		return $this->bufferMode;
	}

	/**
	 * @param bool $reset [optional] default false
	 */
	public function flush($reset = false)
	{
		echo $this->getBuffer($reset);
	}
}
