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

use Phproberto\Joomla\Model\State\Filter\Escaped;

/**
 * Escaped filter tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class EscapedTest extends \TestCaseDatabase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			["'s Hertogenbosch", ["''s Hertogenbosch"]],
			['\sample string', ['\\sample string']],
			[[0], ['0']],
			[[false, true], []],
			[['', ' ', null], []],
			[[], []],
			[['false', '', 'true'], ['false', 'true']]
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
		$filterer = new Escaped;

		$this->assertSame($filterer->filter($value), $expected);
	}
}
