<?php

namespace Seat\HermesDj\Industry\Bus;

use Illuminate\Bus\Batch;
use Seat\Eveapi\Bus\Bus;
use Seat\Eveapi\Jobs\Assets\Corporation\Assets;
use Seat\Eveapi\Jobs\Industry\Corporation\Jobs;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\RefreshToken;
use Seat\HermesDj\Industry\Jobs\Eve\UpdateCorpContainerNames;
use Throwable;

class CorpAssetBus extends Bus
{
    protected int $corporation_id;

    public function __construct(int $corporation_id, RefreshToken $token)
    {
        parent::__construct($token);
        $this->corporation_id = $corporation_id;
    }

    public function fire(): void
    {
        $this->addAuthenticatedJob(new Assets($this->corporation_id, $this->token));
        $this->addAuthenticatedJob(new UpdateCorpContainerNames($this->corporation_id, $this->token));
        $this->addAuthenticatedJob(new Jobs($this->corporation_id, $this->token));

        $corporation = CorporationInfo::firstOrNew(
            ['corporation_id' => $this->corporation_id],
            ['name' => "Unknown Corporation: {$this->corporation_id}"]
        );

        $batch = \Illuminate\Support\Facades\Bus::batch([$this->jobs->toArray()])
            ->then(function (Batch $batch) {
                logger()->debug(
                    sprintf('[Batches][%s] Corporation Assets batch successfully completed.', $batch->id),
                    [
                        'id' => $batch->id,
                        'name' => $batch->name,
                    ]);
            })->catch(function (Batch $batch, Throwable $throwable) {
                logger()->error(
                    sprintf('[Batches][%s] An error occurred during Corporation Assets batch processing.', $batch->id),
                    [
                        'id' => $batch->id,
                        'name' => $batch->name,
                        'error' => $throwable->getMessage(),
                        'trace' => $throwable->getTrace(),
                    ]);
            })->finally(function (Batch $batch) {
                logger()->info(
                    sprintf('[Batches][%s] Corporation Assets batch executed.', $batch->id),
                    [
                        'id' => $batch->id,
                        'name' => $batch->name,
                        'stats' => [
                            'success' => $batch->totalJobs - $batch->failedJobs,
                            'failed' => $batch->failedJobs,
                            'total' => $batch->totalJobs,
                        ],
                    ]);
            })->onQueue('corporations')->name($corporation->name . " Container Names")->allowFailures()->dispatch();
    }
}