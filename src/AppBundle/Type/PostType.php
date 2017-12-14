<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 14.12.17
 * Time: 11:57
 */

namespace AppBundle\Type;


use AppBundle\Services\PostsService;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PostType extends ObjectType
{
    private $postService;
    public function __construct(PostsService $postService, Types $types)
    {
        $this->postService = $postService;
        $config = [
            'fields' => function() use ($types){
                return [
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root){
                            return $root->getId();
                        }
                    ],
                    'title' => [
                        'type' => Type::string(),
                        'resolve' => function ($root){
                            return $root->getTitle();
                        }
                    ],
                    'body' => [
                        'type' => Type::string(),
                        'resolve' => function ($root){
                            return $root->getBody();
                        }
                    ],
                    'comments' => [
                        'type' => Type::listOf($types->comment()),
                        'resolve' => function ($root) {
                            return $root->getComments();
                        }
                    ],
                    'countComments' => [
                        'type' => Type::int(),
                        'resolve' => function ($root) {
                            return $root->getComments()->count();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }

    /**
     * @return PostsService
     */
    public function getPostService(): PostsService
    {
        return $this->postService;
    }


}