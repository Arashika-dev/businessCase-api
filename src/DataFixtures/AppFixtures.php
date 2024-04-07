<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Customer;
use App\Entity\Services;
use App\Entity\Staff;
use App\Entity\State;
use App\Entity\Status;
use App\Entity\User;
use App\Repository\CityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(private CityRepository $cityRepository)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $country = new Country;
            $country
                ->setName($faker->country)
                ->setCode($faker->countryISOALpha3);
            $manager->persist($country);

            
            for ($j = 0; $j < 4; $j++) {
                $city = new City;
                $city
                    ->setName($faker->city)
                    ->setZipCode($faker->postcode)
                    ->setCountry($country);
                $manager->persist($city);
            }

        }
        
        $manager->flush();
        
        $admin = new User;
        $admin
            ->setEmail('admin@test.com')
            ->setPassword('admin')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for ($i = 0; $i < 5; $i++) {
            $staff = new Staff;
            $staff
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword('staff')
                ->setStaffNumber($faker->randomNumber(5))
                ->setRoles(['ROLE_STAFF']);
                
            $manager->persist($staff);
        }

        
       
        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer;
            $city = $this->cityRepository->find($faker->numberBetween(1,30) );
            $customer
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail('customer' . $i . '@test.com')
                ->setPassword('customer')
                ->setSociety($faker->company)
                ->setAdresse($faker->address)
                ->setCity($city)
                ->setRoles(['ROLE_CUSTOMER']);
            $manager->persist($customer);
        }
      

        $statusArray = ['En cours de traitement', 'En attente', 'Terminé'];
        foreach ($statusArray as $value) {
            $status = new Status;
            $status
                ->setName($value);
            $manager->persist($status);
        }

        $stateArray = ['Neuf', 'Mauvais', 'Bon', 'Très bon','Très Mauvais'];
        foreach ($stateArray as $value) {
            $state = new State;
            $state
                ->setName($value);
            $manager->persist($state);
        }

        $categoryArray = ['Chemises', 'Haut', 'Bas', 'Robes', 'Costumes', 'Manteaux', 'Cuir et peaux', 'Maison', 'Accessoires'];
        foreach ($categoryArray as $value) {
            $category = new Category;
            $category
                ->setName($value);
            $manager->persist($category);
        }
        $manager->flush();

        $basArray = ['Pantalon', 'Short', 'Jupe', 'Legging', 'Jean', 'Jogging'];
        $category = $manager->getRepository(Category::class)->findOneBy(['name' => 'Bas']);
        foreach ($basArray as $value) {
            $bas = new Category;
            $bas
                ->setName($value)
                ->setParent($category);
            $manager->persist($bas);
        }

        $hautArray = ['T-shirt', 'Chemise', 'Pull', 'Sweat', 'Gilet', 'Veste'];
        $category = $manager->getRepository(Category::class)->findOneBy(['name' => 'Haut']);
        foreach ($hautArray as $value) {
            $haut = new Category;
            $haut
                ->setName($value)
                ->setParent($category);
            $manager->persist($haut);
        }

        $manager->flush();

        $services = ['Repassage', 'Nettoyage à sec', 'Lavage', 'Pliage', 'Lavage et repassage', 'Lavage et pliage', 'Repassage et pliage', 'Lavage, repassage et pliage'];
        foreach ($services as $value) {
            $service = new Services;
            $service
                ->setName($value)
                ->setPrice($faker->randomFloat(2, 5, 50))
                ->setDescription($faker->text);
            $manager->persist($service);
        }

        $articleChemiseArray = ['Chemise en lin', 'Chemise', 'Chemise en soie', 'Chemisier', 'Veste'];
        $category = $manager->getRepository(Category::class)->findOneBy(['name' => 'Chemises']);
        foreach ($articleChemiseArray as $value) {
            $article = new Article;
            $article
                ->setName($value)
                ->setPrice($faker->randomFloat(2, 5, 50))
                ->setUrlImg($faker->imageUrl())
                ->setCategory($category);
            $manager->persist($article);
        }

        $shortArray = ['Short en jean', 'Short en lin', 'Short en coton', 'Short en soie', 'Short en laine', 'Short de sport'];
        $category = $manager->getRepository(Category::class)->findOneBy(['name' => 'Short']);
        foreach ($shortArray as $value) {
            $short = new Article;
            $short
                ->setName($value)
                ->setPrice($faker->randomFloat(2, 5, 50))
                ->setUrlImg($faker->imageUrl())
                ->setCategory($category);
            $manager->persist($short);
        }

        $manteauArray = ['Veste/Manteau en fourrure', 'Manteau en cuir', 'Manteau en soie', 'Doudoune', 'Manteau en jean', 'Manteau imperméable'];
        $category = $manager->getRepository(Category::class)->findOneBy(['name' => 'Manteaux']);
        foreach ($manteauArray as $value) {
            $manteau = new Article;
            $manteau
                ->setName($value)
                ->setPrice($faker->randomFloat(2, 5, 50))
                ->setUrlImg($faker->imageUrl())
                ->setCategory($category);
            $manager->persist($manteau);
        }



        $manager->flush();
    }
}
