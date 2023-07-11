<?php

namespace OnrampLab\CloudCost\Console;

use Exception;
use Illuminate\Console\Command;
use OnrampLab\CloudCost\Services\SyncAwsCostService;

class Sync extends Command
{
    /**
     * @var string
     */
    protected $signature = 'cloud-cost:sync {providerName} {year} {month}';

    /**
     * @var string
     */
    protected $description = 'sync costs';
    private int $year;
    private int $month;
    private string $providerDriver;
    private array $providerConfig;

    public function __construct()
    {
        ini_set('memory_limit', '512M');
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        $this->preprocessing();
        $this->info('sync from ' . $this->providerDriver);

        if ($this->providerDriver === 'aws') {
            /**
             * @var SyncAwsCostService $service
             */
            $service = app(SyncAwsCostService::class);
            $service->perform(
                $this->providerConfig['filter'] ?? [],
                $this->year,
                $this->month
            );
        }

        $this->info('sync finished');
        return Command::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private function preprocessing(): void
    {
        $providerName = (string)$this->argument('providerName');
        $this->year = (int)$this->argument('year');
        $this->month = (int)$this->argument('month');

        $providers = config('cloud-cost.providers');
        if (!isset($providers[$providerName])) {
            $this->warn('provider name not found, Please check config/cloud-cost.php');
            exit;
        }

        $this->providerDriver = $providers[$providerName]['driver'];
        $this->providerConfig = $providers[$providerName]['config'];
    }
}
