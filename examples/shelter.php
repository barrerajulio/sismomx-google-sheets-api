<?php

use CodeandoMexico\Sismomx\Core\Builders\CollectionCenterBuilder;
use CodeandoMexico\Sismomx\Core\Builders\HelpRequestBuilder;
use CodeandoMexico\Sismomx\Core\Builders\LinkBuilder;
use CodeandoMexico\Sismomx\Core\Builders\ShelterBuilder;
use CodeandoMexico\Sismomx\Core\Builders\SpecificOfferingsBuilder;
use CodeandoMexico\Sismomx\Core\Dictionaries\GoogleSheetsApiV4\ShelterDictionary;
use CodeandoMexico\Sismomx\Core\Interfaces\Builders\CollectionCenterBuilderInterface;
use CodeandoMexico\Sismomx\Core\Interfaces\Builders\HelpRequestBuilderInterface;
use CodeandoMexico\Sismomx\Core\Interfaces\Builders\LinkBuilderInterface;
use CodeandoMexico\Sismomx\Core\Interfaces\Builders\ShelterBuilderInterface;
use CodeandoMexico\Sismomx\Core\Interfaces\Builders\SpecificOfferingsBuilderInterface;
use CodeandoMexico\Sismomx\Core\Interfaces\Repositories\HereWeNeedRepositoryInterface;
use CodeandoMexico\Sismomx\Core\Repositories\GoogleSheetsApiV4\HereWeNeedRepositoryGoogleSheetsApiV4;

require_once(__DIR__ . '/../vendor/autoload.php');

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions([
    CollectionCenterBuilderInterface::class => \DI\object(CollectionCenterBuilder::class),
    HelpRequestBuilderInterface::class => \DI\object(HelpRequestBuilder::class),
    LinkBuilderInterface::class => \DI\object(LinkBuilder::class),
    ShelterBuilderInterface::class => \DI\object(ShelterBuilder::class),
    SpecificOfferingsBuilderInterface::class => \DI\object(SpecificOfferingsBuilder::class),
    HereWeNeedRepositoryInterface::class => \DI\object(HereWeNeedRepositoryGoogleSheetsApiV4::class)
]);
$containerBuilder->useAnnotations(true);
$container = $containerBuilder->build();

$credentialsPath = __DIR__ . '/../config/credentials.json';
$secretPath = __DIR__ . '/../config/secret.json';

/** @var HereWeNeedRepositoryGoogleSheetsApiV4 $repository */
$repository = $container->make(HereWeNeedRepositoryInterface::class, [
    'secretPath' => $secretPath,
    'credentialsPath' => $credentialsPath
]);
$repository->init();

$values = $repository->findAllByRange(
    '1e21rEEz89y5hnN4GoqfPVNJ8hQRGOYWMfTjigAuWT8k',
    'ALBERGUES!A2:G'
);

$collection = array_map(function ($value) use ($container) {
    $value = [
        ShelterDictionary::LOCATION => $value[0],
        ShelterDictionary::RECEIVING => $value[1],
        ShelterDictionary::ADDRESS => $value[2],
        ShelterDictionary::ZONE => $value[3],
        ShelterDictionary::MAP => $value[4],
        ShelterDictionary::MORE_INFORMATION => $value[5],
        ShelterDictionary::UPDATED_AT => $value[6]
    ];
    $factory = $container->make(\CodeandoMexico\Sismomx\Core\Factories\ShelterFactory::class);
    $factory->values->setValues($value);
    return $factory->make();
}, $values);

var_dump($collection);
