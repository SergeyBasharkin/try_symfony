<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 09.11.17
 * Time: 16:54
 */

namespace AppBundle\Repositories;
use Doctrine\ORM\EntityManagerInterface;

class PostsRepository
{
    public function getAllPosts($offset, $limit){
        $json = file_get_contents('../posts.json');
        $json = json_decode($json);
        $page['content'] = array_slice($json, $offset, $limit);
        $page['size'] = count($json);
        return $page;
    }

    private $em;
    /**
     * CommentRepository constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function build(){
        return $this->em->getRepository('AppBundle:Post');
    }

}