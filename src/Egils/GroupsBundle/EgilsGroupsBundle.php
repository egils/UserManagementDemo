<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Egils\GroupsBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EgilsGroupsBundle
 * @package Egils\GroupsBundle
 */
class EgilsGroupsBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $this->addRegisterMappingsPass($container);
    }


    /**
     * Add register mappings pass.
     *
     * @param ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Egils\GroupsBundle\Model',
        );

        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array()));
    }
}
