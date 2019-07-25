<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Stage;
use App\Entity\Documents;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class StageFixtures extends Fixture implements DependentFixtureInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer=$serializer;
    }

    public function getDependencies(): array
    {
        return [
            SizeFixtures::class,
            StyleFixtures::class,
            ThemeFixtures::class,
            AgencyFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // get csv for some stages /!\ some fake or complete datas
        $data = $this->serializer->decode(file_get_contents('test.csv'), 'csv', [CsvEncoder::DELIMITER_KEY => ";"]);
        foreach ($data as $key => $row) {
            $stage = new Stage();
            $themes=explode("  ", $row["THEMATIQUES"]);
            foreach ($themes as $theme) {
                if (strpos($theme, "CULTURE")!==false) {
                    $stage->addTheme($this->getReference('theme_0'));
                } elseif (strpos($theme, "SPORT")!==false) {
                    $stage->addTheme($this->getReference('theme_1'));
                } elseif (strpos($theme, "BIEN")!==false) {
                    $stage->addTheme($this->getReference('theme_2'));
                } elseif (strpos($theme, "NATURE")!==false) {
                    $stage->addTheme($this->getReference('theme_3'));
                } elseif (strpos($theme, "FESTIVAL")!==false) {
                    $stage->addTheme($this->getReference('theme_4'));
                } elseif (strpos($theme, "ILE")!==false) {
                    $stage->addTheme($this->getReference('theme_5'));
                } elseif (strpos($theme, "RESPONSABLE")!==false) {
                    $stage->addTheme($this->getReference('theme_6'));
                }
            }
            $sizes=explode("/", $row["AVEC QUI PARTIR"]);
            foreach ($sizes as $size) {
                if (strpos($size, "SOLO")!==false) {
                    $stage->addSize($this->getReference('size_0'));
                } elseif (strpos($size, "COUPLE")!==false) {
                    $stage->addSize($this->getReference('size_1'));
                } elseif (strpos($size, "FAMILLE")!==false) {
                    $stage->addSize($this->getReference('size_2'));
                } elseif (strpos($size, "AMIS")!==false) {
                    $stage->addSize($this->getReference('size_3'));
                } elseif (strpos($size, "GROUPE")!==false) {
                    $stage->addSize($this->getReference('size_4'));
                }
            }
            $styles=explode("/", $row["STYLE"]);
            foreach ($styles as $style) {
                if (strpos($style, "STANDARD")!==false) {
                    $stage->addStyle($this->getReference('style_0'));
                } elseif (strpos($style, "CHEZ")!==false) {
                    $stage->addStyle($this->getReference('style_1'));
                } elseif (strpos($style, "CHARME")!==false) {
                    $stage->addStyle($this->getReference('style_2'));
                } elseif (strpos($style, "LUXE")!==false) {
                    $stage->addStyle($this->getReference('style_3'));
                } elseif (strpos($style, "RESPONSABLE")!==false) {
                    $stage->addStyle($this->getReference('style_4'));
                }
            }
            $faker = Factory::create('fr_FR');
            $stage->setValidate(true)
                  ->setReference($row["Ref"])
                  ->setDestination($row["DESTINATION"])
                  ->setNameStage($row["nameStage"])
                  ->setDuration(strval(trim($row["Duration"])))
                  ->setAgency($this->getReference('agency_'.$row["agency_id"]))
                  ->setBestMonth(rand(1, 12))
                  ->setDetails($faker->text(2000))
                  ->setAgency($this->getReference('agency_'.$row["agency_id"]));
                  $this->addReference('stage_'.strval($key), $stage);
            $manager->persist($stage);
        }
        $manager->flush();
    }
}
