<?php

namespace App\Fixtures;

use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $iphone = new Product();
        $iphone->setName('Iphone');
        $iphone->setPrice(100);
        $manager->persist($iphone);

        $headphones = new Product();
        $headphones->setName('Headphones');
        $headphones->setPrice(20);
        $manager->persist($headphones);

        $case = new Product();
        $case->setName('Case');
        $case->setPrice(10);
        $manager->persist($case);

        $couponP10 = new Coupon();
        $couponP10->setCode('P10');
        $couponP10->setType('percentage');
        $couponP10->setValue(10);
        $manager->persist($couponP10);

        $couponD15 = new Coupon();
        $couponD15->setCode('D15');
        $couponD15->setType('fixed');
        $couponD15->setValue(15);
        $manager->persist($couponD15);

        $manager->flush();
    }
}