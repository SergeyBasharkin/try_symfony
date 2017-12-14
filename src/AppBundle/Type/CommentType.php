<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 14.12.17
 * Time: 12:10
 */

namespace AppBundle\Type;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CommentType extends ObjectType
{


    /**
     * CommentType constructor.
     */
    public function __construct(Types $types)
    {
        $config = [
            'fields' => function() use ($types) {
                return [
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function ($root){
                            return $root->getId();
                        }
                    ],
                    'body' => [
                        'type' => Type::string(),
                        'resolve' => function ($root){
                            return $root->getBody();
                        }
                    ],
                    'parentPosts' => [
                        'type' => $types->post(),
                        'resolve' => function ($root) {
                            return $root->getPost();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}