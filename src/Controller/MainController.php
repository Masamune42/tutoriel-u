<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'app_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function main(Request $request, LoggerInterface $logger)
    {
        // Nous n'avons pas besoin de créer de constructeur pour logger grâce à l'injection de dépendance
        $logger->info('Bonjour, ceci est un message de log');
        $logger->error('Bonjour, ceci est une erreur');
        return $this->render(
            'main.html.twig',
            [
                'age' => 20,
                'name' => "Alex"
            ]
        );
    }

    #[Route('/main/{name}/{age}', name: 'main')]
    public function test($name = "Alex", $age = 30)
    {

        return $this->render(
            'main.html.twig',
            [
                'name' => $name,
                'age' => $age,
            ]
        );
    }

    #[Route('/age/{age}', name: 'main2')]
    public function age($age = 30)
    {

        $date = new \Datetime('now');

        $fruits = ["Tomates", "Pommes", "Poires"];
        return $this->render(
            'main2.html.twig',
            [
                'age' => $age,
                'date' => $date,
                'fruits' => $fruits,
            ]
        );
    }

    #[Route('/contact/{id}', name: 'contact', condition: "params['id'] < 1000")]
    public function contact($id = 42)
    {
        return $this->render(
            'contact.html.twig', [
                'id' => $id
            ]
        );
    }

    #[Route('/contact2', name: 'contact2')]
    public function contact2($id)
    {
        return $this->render(
            'contact2.html.twig', [
                'id' => $id
            ]
        );
    }
}
