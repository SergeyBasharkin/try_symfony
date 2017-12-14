<?php

namespace AppBundle\Controller;

use AppBundle\Services\CommentService;
use AppBundle\Services\ImageService;
use AppBundle\Services\PostsService;
use AppBundle\Type\QueryType;
use AppBundle\Type\Types;
use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    private $postsService;
    private $imageService;
    private $logger;

    /**
     * DefaultController constructor.
     */
    public function __construct(PostsService $postsService, CommentService $commentService, ImageService $imageService,LoggerInterface $logger)
    {
        $this->postsService = $postsService;
        $this->imageService = $imageService;
        $this->logger = $logger;

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
     * @Route("/hello", name = "hello")
     */
    public function helloGraphQL(Request $request, QueryType $queryType){

        $query = $request->getContent();

        // Создание схемы
        $schema = new Schema([
            'query' => $queryType
        ]);

        // Выполнение запроса
        $result = GraphQL::executeQuery($schema, $query)->toArray();
        return new Response(json_encode($result),200,["Content-Type"=>"application/json;UTF-8"]);
    }
    /**
     * @Route("/test", name = "test")
     */
    public function test(Types $type){

        $s =  $type->post()->getPostService()->findAll();
        dump($s);
        return new Response(json_encode(""),200,["Content-Type"=>"application/json;UTF-8"]);
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
