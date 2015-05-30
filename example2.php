<?php
/**
 * Holds an example of generating a responsive grid tabel containing twitter bootstrap 3.
 *
 * This is only a snippet from the jpFramework
 *
 * @package jpFramework
 * @author Philipp John <info@jplace.de>
 * @version 1.1
 * @license MIT - http://opensource.org/licenses/MIT
 */

$tableHelper = $this->viewHelper->getTable();
$row = $this->viewHelper->getRow();
$col = $this->viewHelper->getCol();

$row->begin()->flush();
	$col->begin()->flush();
		$this->viewHelper->addPageHeader($this->title);
	$col->commit();
$row->commit()->begin()->flush();
	$col->begin('md', 2)->flush();

		$this->subnavSidebar
			->begin()
			->addItems()
			->commit();
		$this->actionsSidebar
			->begin()
			->addItems()
			->commit();
	$col->commit()->begin('md', 10)->flush();
		$tableHelper
			->setResponsive(true)
			->addClass('table-striped')
			->addClass('table-hover')
			->addClass('table-condensed')
			->addClass('admin-user-list')
			->setID('adminUserList')
			->setHeader(
				array (
					'ID',
					'Benutzername',
					'Nickname',
					'E-Mail 1',
					'Registriert',
					'Geändert',
					'Aktiviert',
					'Benutzergruppe',
				))
			->setData($this->users)
			->begin()
			->addHeader()
			->addBody()
			->addFooter()
			->commit();
	$col->commit();
$row->commit();
$this->viewHelper->flush();
