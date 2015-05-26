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
class jpHtmlTable extends jpHtmlBase
{
	/**
	 * @var bool
	 */
	protected $responsive = true;

	/**
	 * @var string[]
	 */
	protected $header = array();

	/**
	 * @var string[]
	 */
	protected $class = array('table');

	/**
	 * @var string
	 */
	protected $width = '';

	/**
	 * @param string[] $header
	 */
	public function setHeader(array $header)
	{
		$this->header = $header;
		return $this;
	}

	/**
	 * @param mixed[] $footer
	 * @return $this
	 */
	public function setFooter(array $footer)
	{
		$this->footer = $footer;
		return $this;
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
	 * @param string $key
	 * @param string $name
	 * @return $this
	 */
	public function addHeaderColumn($key, $name)
	{
		$this->header[$key] = $name;
		return $this;
	}

	/**
	 * @param mixed $key
	 * @param mixed $value
	 * @return $this
	 */
	public function addFooterColumn($key, $value)
	{
		$this->footer[$key] = $value;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function begin()
	{
		if($this->responsive) {
			$this->buffer .= '<div class="table-responsive">';
		}

		$class = '';

		if(!empty($this->class)) {
			$class = 'class="'.implode(' ',$this->class).'"';
		}

		$width = '';

		if(!empty($this->width)) {
			$width = 'width="'.$this->width.'"';
		}

		$this->buffer = '<table '.$class.' '.$width.'>';
		return $this;
	}

	/**
	 * @return $this
	 */
	public function commit()
	{
		$this->buffer .= '</table>';

		if($this->responsive) {
			$this->buffer .= '</div>';
		}

		return $this;
	}

	/**
	 * @return $this
	 */
	public function renderHeader()
	{
		$this->buffer .= '<thead><tr><th>'
					  .implode('</th><th>', $this->header)
					  .'</th></tr></thead>';
		return $this;
	}

	/**
	 * @return $this
	 */
	public function renderFooter()
	{
		$this->buffer .= '<tfoot></tfoot>';
		return $this;
	}

	/**
	 * @param bool $bool
	 * @return $this
	 */
	public function setResponsive($bool)
	{
		$this->responsive = (bool)$bool;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function renderBody()
	{
		$buffer = '';

		foreach($this->data as $row) {
			$buffer .= '<tr><td>'.implode('</td><td>', $row).'</td></tr>';
		}

		if(!empty($buffer)) {
			$this->buffer .= '<tbody>'.$buffer.'</tbody>';
		}

		return $this;
	}
}
