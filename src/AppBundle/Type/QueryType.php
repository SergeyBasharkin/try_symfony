<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 14.12.17
 * Time: 12:18
 */

namespace AppBundle\Type;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{

    public function __construct(Types $types)
    {
        $config = [
            'fields' => function() use ($types){
                return [
                    'postById' => [
                        'type' => $types->post(),
                        'args' => [
                            'id' => Type::int()
                        ],
                        'resolve' => function ($root, $args) use ($types) {
                            return $types->post()->getPostService()->findBy($args['id']);
                        }
                    ],
                    'allPosts' => [
                        'type' => Type::listOf($types->post()),
                        'resolve' => function () use ($types) {
                            return $types->post()->getPostService()->findAll();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}