<?php

namespace App\DataFixtures;

use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function createSector(ObjectManager $manager, string $name, ?Sector $parent = null): Sector
    {
        $sector = new Sector();
        $sector->setName($name);

        if ($parent) {
            $sector->setParent($parent);
            $manager->persist($sector);
            $manager->flush();
            $sector->setPath($parent->getPath() . '/' . $sector->getId());
        } else {
            $manager->persist($sector);
            $manager->flush();
            $sector->setPath($sector->getId());
        }

        $manager->persist($sector);
        $manager->flush();

        return $sector;
    }

    public function load(ObjectManager $manager): void
    {
        // First, persist root sectors
        $manufacturing = $this->createSector($manager, 'Manufacturing');
        $service = $this->createSector($manager, 'Service');
        $other = $this->createSector($manager, 'Other');

        // Now, add child sectors
        $constructionMaterials = $this->createSector($manager, 'Construction Materials', $manufacturing);
        $electronicsAndOptics = $this->createSector($manager, 'Electronics and Optics', $manufacturing);
        $foodAndBeverage = $this->createSector($manager, 'Food and Beverage', $manufacturing);

        // Further child sectors
        $bakery = $this->createSector($manager, 'Bakery', $foodAndBeverage);
        $dairy = $this->createSector($manager, 'Dairy', $foodAndBeverage);
        $meat = $this->createSector($manager, 'Meat', $foodAndBeverage);

        // More sectors
        $business = $this->createSector($manager, 'Business Services', $service);
        $engineering = $this->createSector($manager, 'Engineering', $service);
        $it = $this->createSector($manager, 'IT and Telecommunications', $service);

        // Other category sectors
        $education = $this->createSector($manager, 'Education', $other);
        $health = $this->createSector($manager, 'Health', $other);
        $tourism = $this->createSector($manager, 'Tourism', $other);

        $manager->clear();
    }
}
