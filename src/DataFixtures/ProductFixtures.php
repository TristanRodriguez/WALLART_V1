<?php
/**
 * Fixtures Product
 * 
 * @author Tristan
 * @version 1.0
 */

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Récupération de l'artiste Salvador Dali
        $artist = $manager->getRepository(User::class)
            ->findOneBy([
                'firstname' => 'Salvador',
                'lastname' => 'Dali'
            ]);

        // Vérification de son existence
        if (!$artist) {
            throw new \Exception('Artiste Salvador Dali introuvable.');
        }

        $data = [
            [
                "name" => "Envers tout",
                "description" => "Abstraction visuelle adjacente",
                "price" => 750.50,
                "image" => "/IMG/Artistes/Dali/Envers_tout.jpg"
            ],
            [
                "name" => "L'horloge",
                "description" => "Le temps suspendu déformant la réalité",
                "price" => 3200.50,
                "image" => "/IMG/Artistes/Dali/Le_temps.jpg"
            ],
        ];

        foreach ($data as $field) {
            $product = new Product();

            $product->setName($field['name']);
            $product->setDescription($field['description']);
            $product->setPrice($field['price']);
            $product->setImage($field['image']);

            // Association du produit à l'artiste
            $product->setArtist($artist);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
