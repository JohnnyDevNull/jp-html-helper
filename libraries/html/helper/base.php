<?php
/**
 * Holds the html helper class of the framework.
 *
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @copyright (c) 2014, Philipp John
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl-3.0 GNUv3
 */

if (!defined('_JPEXEC'))
{
	die('RESTRICTED ACCESS');
}

/**
 * Holds some functions the generate html.
 *
 * @package jpFramework
 */
abstract class jpfwHtmlHelperBase
{
	/**
	 * Holds the flag for the processing mode.
	 *
	 * @var string
	 * @access protected
	 */
	protected $_mode = '';

	/**
	 * Contains the data for the table.
	 *
	 * @var mixed[][]
	 * @access protected
	 */
	protected $_data = array();

	/**
	 * Holds the colgroup config.
	 *
	 * @var mixed[]
	 * @access protected
	 */
	protected $_config = array();

	/**
	 * Buffer variable to hold generated html.
	 *
	 * @var string
	 */
	protected $_buffer = '';

	/**
	 * Default constructor.
	 *
	 * @param array $data
	 * @param string $mode
	 * @access public
	 */
	public function __construct($data = array(), $mode = 'frontend')
	{
		$this->_data = $data;
		$this->_mode = $mode;
	}

	/**
	 * Set the body data.
	 *
	 * @param mixed[] $data
	 * @access public
	 */
	public function setData($data)
	{
		$this->_data = $data;
	}

	/**
	 * Set the config array.
	 *
	 * @param mixed[] $config
	 * @access public
	 */
	public function setConfig($config)
	{
		$this->_config = $config;
	}

	/**
	 * Sets the processing mode of the helper object.
	 * 
	 * @param string $string
	 */
	public function setMode($string)
	{
		$this->_mode = $string;
	}

	/**
	 * Resets the helper mode to default value.
	 */
	public function resetMode()
	{
		$this->_mode = 'frontend';
	}

	/**
	 * Returns the current buffer.
	 *
	 * @param bool $reset Set to true if you want to reset the buffer.
	 * @return string
	 */
	public function getBuffer($reset = false)
	{
		$ret = $this->_buffer;

		if($reset) {
			$this->_buffer = '';
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
		$this->_buffer.= $buffer;
	}

	/**
	 * Resets the buffer to an empty string.
	 */
	public function resetBuffer()
	{
		$this->_buffer = '';
	}
}
