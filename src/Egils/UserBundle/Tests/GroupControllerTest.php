<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class GroupControllerTest
 * @package Egils\UserBundle\Tests
 */
class GroupControllerTest extends WebTestCase
{
    /**
     * Set up test environment
     */
    public function setUp()
    {
        $className = $this->getContainer()->get('egils_user.manager.group')->getClass();
        $em = $this->getContainer()->get('doctrine')->getManager();

        $metadata = $em->getClassMetaData($className);
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $classes = array(
            'Egils\UserBundle\Tests\Fixtures\LoadGroupData',
        );
        $this->loadFixtures($classes);
    }

    /**
     * Test 404 response code
     */
    public function test404Page()
    {
        $this->fetchContent('/asdasdas', 'GET', true, false);
    }

    /**
     * Test no authentication
     */
    public function testUnauthorisedPage()
    {
        $this->fetchContent('/api/groups/1.json', 'GET', false, false);
    }

    /**
     * Get group with ID: 1
     */
    public function testGetGroupIndex()
    {
        $content = $this->fetchContent('api/groups/1.json', 'GET', true);
        $this->assertJson($content, 'Response content should be of type JSON');

        $group = json_decode($content, true);

        $this->assertEquals(1, $group['id'], 'Group id should be equal to 1');
        $this->assertEquals("Group 1", $group['name'], 'Group name should be equal to "Group 1"');
    }
}
