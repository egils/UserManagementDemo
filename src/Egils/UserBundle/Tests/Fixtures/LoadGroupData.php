<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Egils\SandboxBundle\Entity\Group;

/**
 * Class LoadGroupData
 * @package Egils\UserBundle\Tests\Fixtures
 */
class LoadGroupData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $group = new Group();
        $group->setId(1);
        $group->setName('Group 1');
        $manager->persist($group);

        $group = new Group();
        $group->setId(2);
        $group->setName('Group 2');
        $manager->persist($group);

        $manager->flush();
    }
}
