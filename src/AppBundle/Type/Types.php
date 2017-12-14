<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 14.12.17
 * Time: 12:07
 */

namespace AppBundle\Type;


use AppBundle\Services\PostsService;

class Types
{
    private $postService;
    private $comment;
    private $post;

    /**
     * Types constructor.
     * @param $post
     * @param $comment
     */
    public function __construct(PostsService $postsService)
    {
        $this->postService = $postsService;
    }

    /**
     * @return PostType
     */
    public function post(): PostType
    {
        return  $this->post ?: ($this->post = new PostType($this->postService,$this));
    }


    /**
     * @return CommentType
     */
    public function comment(): CommentType
    {
        return $this->comment ?: ($this->comment = new CommentType($this));
    }

}