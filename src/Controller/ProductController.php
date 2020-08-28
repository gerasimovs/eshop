<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    protected const ITEMS_PER_PAGE = 5;

    /**
     * @var PaginationService
     */
    protected $paginationService;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * ProductController constructor.
     *
     * @param ProductRepository $productRepository
     * @param PaginationService $paginationService
     */
    public function __construct(ProductRepository $productRepository, PaginationService $paginationService)
    {
        $this->productRepository = $productRepository;
        $this->paginationService = $paginationService;
    }

    /**
     * @Route("api/products", name="products")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->productRepository->getQuery();
        $results = $this->paginationService->paginate($query, $request, self::ITEMS_PER_PAGE);

        return $this->json([
            'items' => $results->getIterator(),
            'perPage' => self::ITEMS_PER_PAGE,
            'lastPage' => $this->paginationService->lastPage($results),
            'total' => $this->paginationService->total($results),
        ]);
    }

    /**
     * @Route("api/products/random", name="products-random")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function random()
    {
        return $this->json($this->productRepository->findOneByRandom());
    }
}
