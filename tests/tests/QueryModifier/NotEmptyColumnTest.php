<?php
/**
 * @package     Phproberto\Joomla\Model
 * @subpackage  Tests.Unit
 *
 * @copyright   Copyright (C) 2018 Roberto Segura López. All rights reserved.
 * @license     GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Phproberto\Joomla\Model\Tests\Unit;

defined('_JEXEC') || die;

use Joomla\CMS\Factory;
use Phproberto\Joomla\Model\QueryModifier\NotEmptyColumn;

/**
 * NotEmptyColumn tests.
 *
 * @since   __DEPLOY_VERSION__
 */
class NotEmptyColumnTest extends \TestCaseDatabase
{
	/**
	 * @test
	 *
	 * @return void
	 */
	public function modifierIsApplied()
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from('#__test');

		$modifier = new NotEmptyColumn($query, 'a.test');
		$modifier->apply();

		$this->assertSame(
			1,
			substr_count(
				(string) $query,
				"WHERE `a`.`test` IS NOT NULL AND `a`.`test` NOT IN ('', '0', '0000-00-00', '0000-00-00 00:00:00')"
			)
		);
	}

	/**
	 * @test
	 *
	 * @return void
	 */
	public function callbackIsCalled()
	{
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from('#__test');

		$executed = false;

		$callback = function () use (&$executed) {
			$executed = true;
		};

		$this->assertFalse($executed);

		$this->modifier = new NotEmptyColumn($query, 'a.test', $callback);
		$this->modifier->apply();

		$this->assertTrue($executed);
	}
}
