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
use Phproberto\Joomla\Model\State\Filter\StringQuoted;

/**
 * StringQuoted tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class StringQuotedTest extends TestCase
{
	/**
	 * Data provider for data.
	 *
	 * @return  array
	 */
	public function filterTestData() : array
	{
		return [
			[1, ['\'1\'']],
			[[null, 'sample', '', ' another string'], ['\'sample\'', '\'another string\'']],
			[[0], ['\'0\'']],
			[[false, true], []],
			[['', ' ', null], []],
			[[], []],
			[['false', '', 'true'], ['\'false\'', '\'true\'']]
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
		$filterer = new StringQuoted;

		$this->assertSame($filterer->filter($value), $expected);
	}
}
