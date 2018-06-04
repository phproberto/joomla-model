<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Tests\Unit\State\Filter;

defined('_JEXEC') || die;

use Phproberto\Joomla\Model\State\Filter\DateFilter;

/**
 * DateFilter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class DateFilterTest extends \TestCaseDatabase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			['2017-12-25', ['\'2017-12-25\'']],
			['2016,2017-12-25', ['\'2017-12-25\'']],
			['2016-03-12 - 2017-12-25', []],
			[[false, true], []],
			[['0000-11-16', '1976-00-16', '\'1976-11-00', '1976-11-16'], ['\'1976-11-16\'']],
			['', []],
			[['', null], []]
		];
	}

	/**
	 * @test
	 *
	 * @dataProvider  filterTestData
	 *
	 * @param   mixed  $value     Value to test
	 * @param   mixed  $expected  Expected result
	 *
	 * @return void
	 */
	public function filterReturnsCorrectValue($value, $expected)
	{
		$filterer = new DateFilter;

		$this->assertSame($filterer->filter($value), $expected);
	}
}
