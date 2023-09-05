<?php
// ce fichier se trouve dans le dossier datafixtures
namespace App\DataFixtures;

// Ici on fait appelle aux classes que l'on utilise pour créér des données fictives ainsi qu'au dependance (gestionnaire d'objet->manager)
// qui permettent de créer des donées fictives, et de faire des operations d'écritures.
use App\Entity\User;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;

// Fournit des méthodes pour la création de données fictives
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

// C'est le gestionnaire d'objet
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

// Permet de hascher le mot de passe
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Cette classe contient un constructeur et des propriétés privées pour la création de données et de gestion de ces données.
class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $hasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }
    // Cette méthode précise à quelle groupe la classe appartient -> au groupe test.
    public static function getGroups(): array
    {
        return ['test'];
    }

    // Cette méthode est utilisée pour charger les données de test dans la BDD à l'aide de Doctrine (qui est un gestionnaire d'objet)
    public function load(ObjectManager $manager): void
    {
        //  Cette ligne de code assigne l'objet $manager passé en argument à l'attribut $manager de la classe AppFixtures
        // Grace à ca, cela permet à la classe d'accéder au gestionnaire d'objet tout au long de la méthode load.
        $this->manager = $manager;
        $this->loadAuteurs();
        $this->loadGenres();
        $this->loadLivres();
    }

    // Méthode qui permet de créér les données Auteur
    public function loadAuteurs(): void
    {
        // Permet de de faire des opérations d'ajout, modifications d'auteurs.
        $repository = $this->manager->getRepository(Auteur::class);

        // données statiques

        $datas = [
            [
                'nom' => 'auteur inconnu',
                'prenom' => 'auteur inconnu',

            ],
            [
                'nom' => 'Cartier',
                'prenom' => 'Hugues',

            ],
            [
                'nom' => 'Lambert',
                'prenom' => 'Armand',

            ],
            [
                'nom' => 'Moitessier',
                'prenom' => 'Thomas',

            ],
        ];

        foreach ($datas as $data) {
            $auteur = new Auteur();
            $auteur->setNom($data['nom']);
            $auteur->setPrenom($data['nom']);

            $this->manager->persist($auteur);
        }
        $this->manager->flush();
    }

    public function loadGenres(): void
    {
        $repository = $this->manager->getRepository(Genre::class);

        // données statiques

        $datas = [
            [
                'nom' => 'poesie',
                'description' => null,
            ],
            [
                'nom' => 'nouvelle',
                'description' => null,
            ],
            [
                'nom' => 'roman historique',
                'description' => null,
            ],
            [
                'nom' => "roman d'amour ",
                'description' => null,
            ],
            [
                'nom' => "roman d'aventure",
                'description' => null,
            ],
            [
                'nom' => 'science fiction',
                'description' => null,
            ],
            [
                'nom' => 'fantasy',
                'description' => null,
            ],
            [
                'nom' => 'biographie',
                'description' => null,
            ],
            [
                'nom' => 'conte',
                'description' => null,
            ],
            [
                'nom' => 'temoignage',
                'description' => null,
            ],
            [
                'nom' => 'theatre',
                'description' => null,
            ],
            [
                'nom' => 'essai',
                'description' => null,
            ],
            [
                'nom' => 'journal intime',
                'description' => null,
            ],
        ];
        foreach ($datas as $data) {
            $genre = new Genre();
            $genre->setNom($data['nom']);
            $genre->setDescription($data['description']);

            $this->manager->persist($genre);
        }
        $this->manager->flush();
    }
    public function loadLivres(): void
    {
        $repositoryAuteur = $this->manager->getRepository(Auteur::class);
        $auteurs = $repositoryAuteur->findAll();
        $auteur1 = $repositoryAuteur->find(1);
        $auteur2 = $repositoryAuteur->find(2);
        $auteur3 = $repositoryAuteur->find(3);
        $auteur4 = $repositoryAuteur->find(4);

        $repositoryGenre = $this->manager->getRepository(Genre::class);
        $genres = $repositoryGenre->findAll();
        $genre1 = $repositoryGenre->find(1);
        $genre2 = $repositoryGenre->find(2);
        $genre3 = $repositoryGenre->find(3);
        $genre4 = $repositoryGenre->find(4);



        // données statiques

        $datas = [
            [
                'titre' => 'Lorem ipsum dolor sit amet',
                'anneeEdition' => 2010,
                'nombrePages' => 100,
                'codeIsbn' => '9785786930024',
                'auteurs' => [$auteur1],
                'genres' => [$genre1],

            ],
            [
                'titre' => 'Consectetur adipiscing elit',
                'anneeEdition' => 2011,
                'nombrePages' => 150,
                'codeIsbn' => '9783817260935',
                'auteurs' => [$auteur2],
                'genres' => [$genre2],


            ],
            [
                'titre' => 'Mihi quidem Antiochum',
                'anneeEdition' => 2012,
                'nombrePages' => 200,
                'codeIsbn' => '9782020493727',
                'auteurs' => [$auteur3],
                'genres' => [$genre3],


            ],
            [
                'titre' => 'Quem audis satis belle',
                'anneeEdition' => 2013,
                'nombrePages' => 250,
                'codeIsbn' => '9794059561353',
                'auteurs' => [$auteur4],
                'genres' => [$genre4],


            ],
        ];
        foreach ($datas as $data) {
            $livre = new Livre();
            $livre->setTitre($data['titre']);
            $livre->setAnneeEdition($data['anneeEdition']);
            $livre->setNombrePages($data['nombrePages']);
            $livre->setCodeIsbn($data['codeIsbn']);
            $livre->setAuteur($data['auteurs'][0]);

            $livre->addGenre($data['genres'][0]);


            $this->manager->persist($livre);
        }
        $this->manager->flush();
    }
}
