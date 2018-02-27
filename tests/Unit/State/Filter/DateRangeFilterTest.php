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

use PHPUnit\Framework\TestCase;
use Phproberto\Joomla\Model\State\Filter\DateRangeFilter;

/**
 * DateRangeFilter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class DateRangeFilterTest extends TestCase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			// Missing to date
			['2017-12-25', []],
			// Valid
			['2017-12-25 - 2018-12-30', ['\'2017-12-25 - 2018-12-30\'']],
			// From date greater than to date
			['2019-12-25 - 2018-12-30', []],
			// Missing from date
			[' - 2018-12-30', []],
			// Various invalid formats
			[['0000-01-01 - 2018-12-30', '2010-00-01 - 2018-12-30', '2010-01-00 - 2018-12-30'], []],
			// Month > 12 || Day > 31
			[['2010-13-00 - 2018-12-23', '2010-13-32 - 2018-12-23'], []],
			// Empty values
			[[null, ''], []],
			[[false, true], []]
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
		$filterer = new DateRangeFilter;

		$this->assertSame($filterer->filter($value), $expected);
	}
}
