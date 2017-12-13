<?php

namespace AppBundle\Command;

use AppBundle\Entity\City;
use AppBundle\Entity\Hero;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 23.11.17
 * Time: 14:21
 */
class FillDbCommand extends ContainerAwareCommand
{

    private $cityRepository;
    private $heroRepository;
    private $em;

    protected function configure()
    {
        $this->setName('app:fill-db')->setDescription('fill database')->setHelp('');
    }



    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->init();
        $restClient = $this->getContainer()->get('circle.restclient');
        $content = $restClient->get("http://31.186.96.6:9090")->getContent();
        $json = json_decode((string)$content);

        foreach ($json as $entry) {
            $city = $this->cityRepository->findOneByName($entry->city);
            $hero = $this->heroRepository->findOneByName($entry->name);
            if ($city === null) {
                $city = new City();
                $city->setName($entry->city);
                $this->em->persist($city);
                $this->em->flush();
            }
            if ($hero === null) {
                $hero = new Hero();
                $hero->setName($entry->name);
                $hero->setCity($city);
                $this->em->persist($hero);
                $this->em->flush();
            }
            if (!$this->isHeroInCity($hero, $city)) {
                $city->getHeroes()->add($hero);
            }
            $this->em->persist($city);
        }
    }

    private function isHeroInCity(Hero $hero, City $city)
    {
        $inCity = false;
        foreach ($city->getHeroes() as $heroInCity) {
            if ($hero->getName() === $heroInCity->getName()) {
                $inCity = true;
            }
        }
        return $inCity;
    }

    private function init(){
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->cityRepository = $this->getContainer()->get('doctrine')
            ->getRepository('AppBundle\Entity\City');
        $this->heroRepository = $this->getContainer()->get('doctrine')
            ->getRepository('AppBundle\Entity\Hero');
    }
}