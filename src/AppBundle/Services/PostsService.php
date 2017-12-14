<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 09.11.17
 * Time: 16:52
 */
namespace AppBundle\Services;

use AppBundle\Repositories\PostsRepository;

class PostsService
{

    private $postsRepository;

    const LIMIT_POSTS = 2;

    /**
     * PostsService constructor.
     */
    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository->build();
    }

    public function getAllPosts($page = 1){
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * self::LIMIT_POSTS;

        return $this->postsRepository->getAllPosts($offset, self::LIMIT_POSTS);
    }

    public function findBy($id)
    {
       return $this->postsRepository->find($id);
    }

    public function findAll()
    {
        return $this->postsRepository->findAll();
    }
}