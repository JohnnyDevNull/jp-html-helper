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
	 * @param bool $bool
	 * @return jpHtmlTable
	 */
	public function setResponsive($bool)
	{
		$this->responsive = (bool)$bool;
		return $this;
	}

	/**
	 * @param string[] $header
	 * @return jpHtmlTable
	 */
	public function setHeader(array $header)
	{
		$this->header = $header;
		return $this;
	}

	/**
	 * @param mixed[] $footer
	 * @return jpHtmlTable
	 */
	public function setFooter(array $footer)
	{
		$this->footer = $footer;
		return $this;
	}

	/**
	 * @param string $key
	 * @param string $name
	 * @return jpHtmlTable
	 */
	public function addHeaderColumn($key, $name)
	{
		$this->header[$key] = $name;
		return $this;
	}

	/**
	 * @param mixed $key
	 * @param mixed $value
	 * @return jpHtmlTable
	 */
	public function addFooterColumn($key, $value)
	{
		$this->footer[$key] = $value;
		return $this;
	}

	/**
	 * @param string $id [optinal] default null
	 * @param string $class [optinal] default null
	 * @return jpHtmlTable
	 */
	public function begin($id = null, $class = null)
	{
		if($class === null) {
			$class = $this->class;
		}

		if($id === null) {
			$id = $this->id;
		}

		if($this->responsive) {
			$this->addBuffer('<div class="table-responsive">');
		}

		if(!empty($class)) {
			$class = ' '.$class;
		}

		$this->addBuffer(
			'<table class="table'.$class.'"'
				. $this->getAttribute('id', $id)
			. '>'
		);
		return $this;
	}

	/**
	 * @param bool $flush [optional] default true
	 * @param bool $reset [optional] default true
	 * @return jpHtmlTable
	 */
	public function commit($flush = true, $reset = true)
	{
		$this->addBuffer('</table>');

		if($this->responsive) {
			$this->addBuffer('</div>');
		}

		if($flush) {
			$this->flush($reset);
		}

		return $this;
	}

	/**
	 * @return jpHtmlTable
	 */
	public function addHeader()
	{
		$this->addBuffer(
			'<thead>'
				.'<tr>'
					.'<th>'.implode('</th><th>', $this->header).'</th>'
				.'</tr>'
			.'</thead>'
		);
		return $this;
	}

	/**
	 * @return jpHtmlTable
	 */
	public function addFooter()
	{
		$this->addBuffer('<tfoot></tfoot>');
		return $this;
	}

	/**
	 * @return jpHtmlTable
	 */
	public function addBody()
	{
		$buffer = '';

		foreach($this->data as $row) {
			$buffer .= '<tr><td>'.implode('</td><td>', $row).'</td></tr>';
		}

		if(!empty($buffer)) {
			$this->addBuffer('<tbody>'.$buffer.'</tbody>');
		}

		return $this;
	}
}
