<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Form;

use Egils\UserBundle\Form\Factory\UserGroupsFormFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class UserType
 * @package Egils\UserBundle\Form
 */
class UserType extends AbstractType
{

    /**
     * @var string
     */
    protected $className;

    /**
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'description' => 'A name of an user',
        ));

        $builder->add('groups', 'egils_user_groups', array(
        ));
    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->className,
            'intention' => 'user',
            'translation_domain' => 'EgilsUserBundle'
        ));
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'egils_user';
    }
}
