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
use Phproberto\Joomla\Model\State\Filter\Custom;

/**
 * Custom filter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class CustomTest extends TestCase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			[
				function ($value) {
					return 1 === $value;
				},
				null,
				[null, ''],
				[]
			],
			[
				function ($value) {
					return 1 === $value;
				},
				null,
				[0, 4, 1],
				[1]
			],
			[
				function ($value)
				{
					return $value > 1;
				},
				'strlen',
				['', ' ', '2', '223'],
				[3]
			],
			[
				function ($value)
				{
					return $value > 1;
				},
				'strlen',
				' ,2, 223',
				[3]
			],
			[[$this, 'sampleFilterFunction'], null, ['', ' ', 'allowed', 'forbidden', 'sample', 'filteredToo'], ['allowed', 'sample']]
		];
	}

	/**
	 * Sample filter function for testing purposes.
	 *
	 * @param   mixed  $value  Value to filter
	 *
	 * @return  boolean
	 */
	public function sampleFilterFunction($value)
	{
		return !in_array($value, ['forbidden', 'filteredToo'], true);
	}

	/**
	 * @test
	 *
	 * @dataProvider  filterTestData
	 *
	 * @param   callable       $filterValueFunction   Function to filter values
	 * @param   callable|null  $prepareValueFunction  Function to prepare values
	 * @param   mixed          $value                 Value to test
	 * @param   mixed          $expected              Expected result
	 *
	 * @return void
	 */
	public function filterReturnsCorrectValue(callable $filterValueFunction, $prepareValueFunction, $value, $expected)
	{
		$filterer = new Custom($filterValueFunction, $prepareValueFunction);

		$this->assertSame($filterer->filter($value), $expected);
	}
}
