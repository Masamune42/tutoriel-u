<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(EntityManagerInterface $entityManager)
    {

        $products = $entityManager->getRepository(Product::class)->findBy(['valid' => true]);

        return $this->render(
            'product/index.html.twig',
            [
                'products' => $products
            ]
        );
    }

    #[Route('/product/{id}', name: 'app_product_show')]
    public function show(EntityManagerInterface $entityManager, int $id)
    {

        $product = $entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);

        return $this->render(
            'product/show.html.twig',
            [
                'product' => $product
            ]
        );
    }
}