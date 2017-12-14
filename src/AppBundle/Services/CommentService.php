<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 14.12.17
 * Time: 12:11
 */

namespace AppBundle\Services;


use AppBundle\Repositories\CommentRepository;

class CommentService
{
    private $commentRepository;

    /**
     * CommentService constructor.
     * @param $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }


}