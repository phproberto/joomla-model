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
use Phproberto\Joomla\Model\State\Filter\DateTimeFilter;

/**
 * DateTimeFilter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class DateTimeFilterTest extends TestCase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			// Missing time
			['2017-12-25', []],
			// Valid
			[
				['2017-12-25 23:45:55', '2017-12-25 23:00:55', '2017-12-25 00:00:00'],
				['\'2017-12-25 23:45:55\'', '\'2017-12-25 23:00:55\'', '\'2017-12-25 00:00:00\'']
			],
			// Invalid hours
			[['2019-12-25 24:45:55', '2019-12-25 23:60:55', '2019-12-25 23:05:61'], []],
			// Invalid dates
			[['0000-12-25 23:45:55', '2010-00-01 22:15:15', '2010-01-00 11:30:10'], []],
			// More invalid dates
			[['2010-13-01 23:45:55', '2010-10-32 23:45:55'], []],
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
		$filterer = new DateTimeFilter;

		$this->assertSame($filterer->filter($value), $expected);
	}
}
