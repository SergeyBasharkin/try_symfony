<?php

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 09.11.17
 * Time: 16:54
 */

namespace AppBundle\Repositories;
class PostsRepository
{
    public function getAllPosts($offset, $limit){
        $json = file_get_contents('../posts.json');
        $json = json_decode($json);
        $page['content'] = array_slice($json, $offset, $limit);
        $page['size'] = count($json);
        return $page;
    }


}