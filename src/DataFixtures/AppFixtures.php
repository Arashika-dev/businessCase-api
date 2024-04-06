<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Customer;
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
            var_dump($city);
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


        


        $manager->flush();
    }
}
