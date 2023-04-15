<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/product/new', name: 'app_product_new')]
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $product->setValid(true);

            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', "Félicitation vous avez créé le produit : <b>" . $product->getName() . "</b>");

            return $this->redirectToRoute('app_product');
        }

        return $this->render(
            'product/new.html.twig', [
                'form' => $form->createView()
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