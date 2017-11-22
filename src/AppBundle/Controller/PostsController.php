<?php

namespace AppBundle\Controller;

use AppBundle\Services\ImageService;
use AppBundle\Services\PostsService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    private $postsService;
    private $imageService;

    /**
     * DefaultController constructor.
     */
    public function __construct(PostsService $postsService, ImageService $imageService)
    {
        $this->postsService = $postsService;
        $this->imageService = $imageService;
    }

    /**
     * @Route("/image", name="image")
     */
    public function image(Request $request)
    {
        $file = $this->imageService->generateImage(date("Y-m-d H:i:s").' browser:'.$request->query->get("browser"));

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent($file);
        $response->headers->set("Content-Type", "image/png");

        return $response;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $page = (int)$request->get('page');

        if ($page < 1) $page = 1;

        $postsPage = $this->postsService->getAllPosts($page);

        $size = $postsPage["size"];
        $posts = $postsPage["content"];
        $pages = ceil($size / $this->postsService::LIMIT_POSTS);

        // replace this example code with whatever you need
        return $this->render('posts/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'posts' => $posts,
            'count' => $size,
            'pages' => $pages,
            'users_post' => false,
            'current_page' => $page
        ]);
    }
}
