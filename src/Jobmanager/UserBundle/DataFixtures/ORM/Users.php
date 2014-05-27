<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 23/05/2014
 * Time: 23:08
 */

namespace Jobmanager\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jobmanager\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Users implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $logins = array(
            'gerard' => '137paf6',
            'b0soleil' => 'auj0urdhu1'
        );

        foreach ($logins as $login => $password) {
            $users[$login] = new User();
            $users[$login]->setUsername($login);
            $users[$login]->setSalt(uniqid(mt_rand()));

            // call encoder service
            $encoder = $this->container
                ->get('security.encoder_factory')
                ->getEncoder($users[$login])
            ;

            $password = $encoder->encodePassword($password, $users[$login]->getSalt());

            $users[$login]->setPassword($password);

            $users[$login]->setRoles(array('ROLE_ADMIN'));

            $manager->persist($users[$login]);
        }

        $manager->flush();
    }
} 