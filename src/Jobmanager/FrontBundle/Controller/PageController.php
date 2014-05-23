<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 23/05/2014
 * Time: 22:39
 */

namespace Jobmanager\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function indexAction()
    {
        return new Response('YEAH');
    }
} 