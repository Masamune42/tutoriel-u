# Tutoriel Symfony 6 Udemy

## Créer des services
On peut créer des services et les utiliser via les autowiring
- On crée un dossier avec un fichier de classe à l'intérieur, ex : Tax/Calculator.php
- On crée dans la classe une fonction
```php
namespace App\Tax;

class Calculator
{
    public function calculTTC(float $prixht): float
    {
        return $prixht * 1.2;
    }
}
```
- On peut ensuite appeler cette classe dans un controlleur
```php
// Option 1 : on le déclare dans un constructeur
protected $calculator;

public function __construct(Calculator $calculator)
{
    $this->calculator = $calculator;
}

#[Route('/', name: 'app_main')]
public function main(Request $request, LoggerInterface $logger)
{
    dd($this->$calculator->calculTTC(100));
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

// Option 2 : Autowiring (sans contructeur)
 #[Route('/', name: 'app_main')]
public function main(Request $request, LoggerInterface $logger, Calculator $calculator)
{
    dd($calculator->calculTTC(100));
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
```

## Configuration des services
On peut passer à la fois le LoggerInterface et une variable dans le constructeur
```php
class Calculator
{
    private $logger;
    private $marge;

    public function __construct(LoggerInterface $logger, float $marge)
    {
        $this->logger = $logger;
        $this->marge = $marge;
    }

    public function calculTTC(float $prixht): float
    {
        $this->logger->info('Une demande de prix TTC a été effectuée ');
        return $prixht * 1.2;
    }
}
```
Pour la variable, il faut passer la variable dans services.yaml
```yaml
    App\Tax\Calculator:
        arguments:
            $marge: 50
```

## Utiliser des bibliothèques tierces avec le Container de services
```php
public function main(Request $request, LoggerInterface $logger, Calculator $calculator, Slugify $slugify)
```
Pour pouvoir appeler Slugify avec l'autowiring, il faut ajouter le service dans services.yaml
```yaml
# ~ car pas d'argument
Cocur\Slugify\Slugify: ~
```