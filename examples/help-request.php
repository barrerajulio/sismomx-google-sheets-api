<?php

use CodeandoMexico\Sismomx\Core\Builders\CollectionCenterBuilder;
use CodeandoMexico\Sismomx\Core\Builders\HelpRequestBuilder;
use CodeandoMexico\Sismomx\Core\Builders\LinkBuilder;
use CodeandoMexico\Sismomx\Core\Builders\ShelterBuilder;
use CodeandoMexico\Sismomx\Core\Builders\SpecificOfferingsBuilder;
use CodeandoMexico\Sismomx\Core\Dictionaries\GoogleSheetsApiV4\HelpRequestDictionary;
use CodeandoMexico\Sismomx\Core\Factories\HelpRequestFactory;
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
    'URGENCIAS Y SOLICITUDES POR ZON!A6:I'
);

$helpCollection = array_map(function ($value) use ($container) {
    $options = $container->make(\CodeandoMexico\Sismomx\Core\Base\Values::class);
    $options->setValues($value);
    $value = [
        HelpRequestDictionary::URGENCY_LEVEL => $options->getValue(0),
        HelpRequestDictionary::BRIGADE_REQUIRED => $options->getValue(1),
        HelpRequestDictionary::MOST_IMPORTANT_REQUIRED => $options->getValue(2),
        HelpRequestDictionary::ADMITTED => $options->getValue(3),
        HelpRequestDictionary::NOT_REQUIRED => $options->getValue(4),
        HelpRequestDictionary::ADDRESS => $options->getValue(5),
        HelpRequestDictionary::ZONE => $options->getValue(6),
        HelpRequestDictionary::SOURCE => $options->getValue(7),
        HelpRequestDictionary::UPDATED_AT => $options->getValue(8)
    ];
    $factory = $container->make(HelpRequestFactory::class);
    $factory->values->setValues($value);
    return $factory->make();
}, $values);

