<?php
namespace PITS\PitsLayerslider\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Sivaprasad S <sivaprasad.s@pitsolutions.com>, Pit Solution Pvt Ltd
 *  Abin Sabu <abin.sabu@pitsolutions.com>, PIT Solution Pvt Ltd
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package pits_layerslider
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Layerslider extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
   * 
	 * @var string
	 */
	protected $title = null;

	/**
	 * Returns the title
	 *
	 * @return  $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param  $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

}
