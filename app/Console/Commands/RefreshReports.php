<?php
namespace App\Console\Commands;

use CodeandoMexico\Sismomx\Core\Base\Values;
use CodeandoMexico\Sismomx\Core\Dictionaries\GoogleSheetsApiV4\CollectionCenterDictionary;
use CodeandoMexico\Sismomx\Core\Dictionaries\GoogleSheetsApiV4\HelpRequestDictionary;
use CodeandoMexico\Sismomx\Core\Dictionaries\GoogleSheetsApiV4\LinkDictionary;
use CodeandoMexico\Sismomx\Core\Dictionaries\GoogleSheetsApiV4\ShelterDictionary;
use CodeandoMexico\Sismomx\Core\Dictionaries\GoogleSheetsApiV4\SpecificOfferingsDictionary;
use CodeandoMexico\Sismomx\Core\Factories\CollectionCenterFactory;
use CodeandoMexico\Sismomx\Core\Factories\HelpRequestFactory;
use CodeandoMexico\Sismomx\Core\Factories\LinkFactory;
use CodeandoMexico\Sismomx\Core\Factories\ShelterFactory;
use CodeandoMexico\Sismomx\Core\Factories\SpecificOfferingsFactory;
use CodeandoMexico\Sismomx\Core\Interfaces\Repositories\HereWeNeedRepositoryInterface;
use CodeandoMexico\Sismomx\Core\Mutators\CollectionCenterDbMutator;
use CodeandoMexico\Sismomx\Core\Mutators\HelpRequestDbMutator;
use CodeandoMexico\Sismomx\Core\Mutators\LinkDbMutator;
use CodeandoMexico\Sismomx\Core\Mutators\ShelterDbMutator;
use CodeandoMexico\Sismomx\Core\Mutators\SpecificOfferingsDbMutator;
use CodeandoMexico\Sismomx\Core\Repositories\Eloquent\BaseRepository;
use CodeandoMexico\Sismomx\Core\Repositories\Eloquent\CollectionCenterRepository;
use CodeandoMexico\Sismomx\Core\Repositories\Eloquent\HelpRequestRepository;
use CodeandoMexico\Sismomx\Core\Repositories\Eloquent\LinkRepository;
use CodeandoMexico\Sismomx\Core\Repositories\Eloquent\ShelterRepository;
use CodeandoMexico\Sismomx\Core\Repositories\Eloquent\SpecificOfferingRepository;
use CodeandoMexico\Sismomx\Core\Repositories\GoogleSheetsApiV4\HereWeNeedRepositoryGoogleSheetsApiV4;
use DI\ContainerBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class RefreshReports
 * @package App\Console\Commands
 */
class RefreshReports extends Command
{
    const SPREADSHEET_ID = '1mo9czjIQupWSkjyM--_RSusShy-WbHi8w28oBmxeufk';
    const ITEMS = 'items';
    const TABLE = 'table';
    const SOURCE = 'source';
    const RESOLVER = 'resolver';
    const RESOLVER_PAYLOAD = 'resolver_payload';
    const RESOLVER_REPOSITORY = 'resolver_repository';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:refresh {secretPath}{credentialsPath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var ContainerBuilder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $reportsSources =  [
        [
            self::SOURCE => self::SPREADSHEET_ID,
            self::TABLE => 'CENTROS DE ACOPIO!A2:I',
            self::RESOLVER => CollectionCenterFactory::class,
            self::RESOLVER_PAYLOAD => CollectionCenterDbMutator::class,
            self::RESOLVER_REPOSITORY => CollectionCenterRepository::class,
            self::ITEMS => [
                CollectionCenterDictionary::URGENCY_LEVEL => 0,
                CollectionCenterDictionary::LOCATION => 1,
                CollectionCenterDictionary::REQUIREMENTS_DETAILS => 2,
                CollectionCenterDictionary::ADDRESS => 3,
                CollectionCenterDictionary::ZONE => 4,
                CollectionCenterDictionary::MAP => 5,
                CollectionCenterDictionary::MORE_INFORMATION => 6,
                CollectionCenterDictionary::UPDATED_AT => 7,
                CollectionCenterDictionary::CONTACT => 8
            ]
        ],
        [
            self::SOURCE => self::SPREADSHEET_ID,
            self::TABLE => 'URGENCIAS Y SOLICITUDES POR ZONA!A6:I',
            self::RESOLVER => HelpRequestFactory::class,
            self::RESOLVER_PAYLOAD => HelpRequestDbMutator::class,
            self::RESOLVER_REPOSITORY => HelpRequestRepository::class,
            self::ITEMS => [
                HelpRequestDictionary::URGENCY_LEVEL => 0,
                HelpRequestDictionary::BRIGADE_REQUIRED => 1,
                HelpRequestDictionary::MOST_IMPORTANT_REQUIRED => 2,
                HelpRequestDictionary::ADMITTED => 3,
                HelpRequestDictionary::NOT_REQUIRED => 4,
                HelpRequestDictionary::ADDRESS => 5,
                HelpRequestDictionary::ZONE => 6,
                HelpRequestDictionary::SOURCE => 7,
                HelpRequestDictionary::UPDATED_AT => 8
            ]
        ],
        [
            self::SOURCE => self::SPREADSHEET_ID,
            self::TABLE => 'OTROS ENLACES!A3:B',
            self::RESOLVER => LinkFactory::class,
            self::RESOLVER_PAYLOAD => LinkDbMutator::class,
            self::RESOLVER_REPOSITORY => LinkRepository::class,
            self::ITEMS => [
                LinkDictionary::URL => 0,
                LinkDictionary::DESCRIPTION => 1,
            ]
        ],
        [
            self::SOURCE => self::SPREADSHEET_ID,
            self::TABLE => 'ALBERGUES!A2:G',
            self::RESOLVER => ShelterFactory::class,
            self::RESOLVER_PAYLOAD => ShelterDbMutator::class,
            self::RESOLVER_REPOSITORY => ShelterRepository::class,
            self::ITEMS => [
                ShelterDictionary::LOCATION => 0,
                ShelterDictionary::RECEIVING => 1,
                ShelterDictionary::ADDRESS => 2,
                ShelterDictionary::ZONE => 3,
                ShelterDictionary::MAP => 4,
                ShelterDictionary::MORE_INFORMATION => 5,
                ShelterDictionary::UPDATED_AT => 6
            ]
        ],
        [
            self::SOURCE => self::SPREADSHEET_ID,
            self::TABLE => 'OFRECIMIENTOS ESPECÍFICOS!A4:G',
            self::RESOLVER => SpecificOfferingsFactory::class,
            self::RESOLVER_PAYLOAD => SpecificOfferingsDbMutator::class,
            self::RESOLVER_REPOSITORY => SpecificOfferingRepository::class,
            self::ITEMS => [
                SpecificOfferingsDictionary::OFFERING_FROM => 0,
                SpecificOfferingsDictionary::NOTES => 1,
                SpecificOfferingsDictionary::CONTACT => 2,
                SpecificOfferingsDictionary::OFFERING_DETAILS => 3,
                SpecificOfferingsDictionary::MORE_INFORMATION => 4,
                SpecificOfferingsDictionary::UPDATED_AT => 5,
                SpecificOfferingsDictionary::EXPIRES_AT => 6
            ]
        ]
    ];

    /**
     * ReportsRefresh constructor.
     * @param ContainerBuilder $builder
     */
    public function __construct(ContainerBuilder $builder)
    {
        $this->builder = $builder;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $secretPath = $this->argument('secretPath');
        $credentialsPath = $this->argument('credentialsPath');
        $container = $this->buildContainer();
        /** @var HereWeNeedRepositoryGoogleSheetsApiV4 $repository */
        $repository = $container->make(HereWeNeedRepositoryInterface::class, [
            'secretPath' => $secretPath,
            'credentialsPath' => $credentialsPath
        ]);
        $repository->init();
        $options = $container->make(Values::class);
        $collection = [];
        foreach ($this->reportsSources as $source) {
            $values = $repository->findAllByRange(
                $source[self::SOURCE],
                $source[self::TABLE]
            );
            /** @var BaseRepository $repository */
            $repositoryDb = $container->make($source[self::RESOLVER_REPOSITORY]);
            $collection[$source[self::RESOLVER]] = array_map(function ($_value) use (
                $container,
                $source,
                $options,
                $repositoryDb
            ) {
                $options->setValues($_value);
                $raw = [];
                foreach ($source[self::ITEMS] as $key => $position) {
                    $raw[$key] = $options->getValue($position);
                }
                $factory = $container->make($source[self::RESOLVER]);
                $factory->values->setValues($raw);
                $dto = $factory->make();
                /** @var  $mutatorPayload */
                $mutatorPayload = $container->make($source[self::RESOLVER_PAYLOAD], [
                    'dto' => $dto
                ]);
                $payload = $mutatorPayload->toArray();
                $repositoryDb->storeSingleRowFromArray($payload);
                return  $dto;
            }, $values);
        }
        return $collection;
    }

    /**
     * @return \DI\Container
     */
    protected function buildContainer()
    {
        $definitions = require __DIR__ . '/../../../config/definitions-di.php';
        $this->builder->addDefinitions($definitions);
        $this->builder->useAnnotations(true);
        return $this->builder->build();
    }
}
