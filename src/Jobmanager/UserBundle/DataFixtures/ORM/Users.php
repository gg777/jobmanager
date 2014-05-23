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

class Users implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $noms = array('gerard');

        foreach ($noms as $i => $nom) {
            $users[$i] = new User();
            $users[$i]->setUsername($nom);
            $users[$i]->setPassword($nom);
            $users[$i]->setSalt('');
            $users[$i]->setRoles(array('ROLE_ADMIN'));

            $manager->persist($users[$i]);
        }

        $manager->flush();
    }
} 