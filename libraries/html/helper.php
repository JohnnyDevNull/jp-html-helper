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
class jpHtmlHelper extends jpHtmlBase
{
	/**
	 * @return jpHtmlContainer
	 */
	public function getContainer()
	{
		return new jpHtmlContainer($this);
	}

	/**
	 * @return jpHtmlRow
	 */
	public function getRow()
	{
		return new jpHtmlRow($this);
	}

	/**
	 * @return jpHtmlCol
	 */
	public function getCol()
	{
		return new jpHtmlCol($this);
	}

	/**
	 * @return jpHtmlTable
	 */
	public function getTable()
	{
		return new jpHtmlTable($this);
	}

	/**
	 * @return jpHtmlList
	 */
	public function getList()
	{
		return new jpHtmlList($this);
	}

	/**
	 * @return jpHtmlNavlist
	 */
	public function getNavList()
	{
		return new jpHtmlNavlist($this);
	}

	/**
	 * @return jpHtmlForm
	 */
	public function getForm()
	{
		return new jpHtmlForm($this);
	}

	/**
	 * Generates and returns a page header html box.
	 *
	 * @param string $title
	 * @param int $size
	 * @param string $class
	 * @return jpHtmlHelper
	 */
	public function addPageHeader($title, $size = 1, $class = '')
	{
		$this->addBuffer (
			'<div class="page-header'.$class.'">'
				.'<h'.$size.'>'.$title.'</h'.$size.'>'
			.'</div>'
		);
		return $this;
	}

	/**
	 * Generates a twitter bootstrap panel box with type, title and given body html.
	 *
	 * @param string $title
	 * @param string $content
	 * @param string $type
	 * @param string $class
	 * @return jpHtmlHelper
	 */
	public function addPanel($title, $content, $type = 'default', $class = '')
	{
		$this->addBuffer(
			'<div class="panel panel-'.trim($type).$class.'">
				<div class="panel-heading">
					<h3 class="panel-title">'.$title.'</h3>
				</div>
				<div class="panel-body">'.$content.'</div>
			</div>'
		);

		return $this;
	}

	/**
	 * Generates a sidebar-module box.
	 *
	 * @param string $title
	 * @param html $content
	 * @param bool $inset
	 * @param string $class
	 * @return jpHtmlHelper
	 */
	public function addModule($title, $content, $inset = false, $class = '')
	{
		$cssInset = '';

		if($inset) {
			$cssInset = 'sidebar-module-inset ';
		}

		$this->addBuffer (
			'<div class="sidebar-module '.$cssInset.$class.'">
				<div class="module-heading">
					<h3 class="module-title">'.$title.'</h3>
				</div>
				<div class="module-body">'.$content.'</div>
			</div>'
		);

		return $this;
	}
}
