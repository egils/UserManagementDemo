<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Egils\GroupsBundle\Form;

use Egils\GroupsBundle\Model\Manager\GroupManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class GroupType
 * @package Egils\GroupsBundle\Form
 */
class GroupType extends AbstractType
{

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'description' => 'A name for a group',
        ));
    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'group',
            'translation_domain' => 'EgilsGroupsBundle'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'group';
    }
}
