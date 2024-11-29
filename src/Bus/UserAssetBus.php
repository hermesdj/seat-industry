<?php

namespace Seat\HermesDj\Industry\Bus;

use Illuminate\Bus\Batch;
use Seat\Eveapi\Bus\Bus;
use Seat\Eveapi\Jobs\Assets\Character\Assets;
use Seat\Eveapi\Jobs\Industry\Character\Jobs;
use Seat\Eveapi\Models\RefreshToken;
use Seat\HermesDj\Industry\Jobs\Eve\UpdateCharacterContainerNames;
use Seat\Web\Models\User;
use Throwable;

class UserAssetBus extends Bus
{
    protected int $user_id;

    public function __construct(int $user_id)
    {
        parent::__construct(null);
        $this->user_id = $user_id;
    }

    public function fire(): void
    {
        $user = User::find($this->user_id);
        $characters = $user->characters()->get();
        $mainCharacter = $user->main_character->first();

        foreach ($characters as $character) {
            $token = RefreshToken::find($character->character_id);

            if ($token) {
                $assetJob = new Assets($token);
                if (in_array($assetJob->getScope(), $token->getScopes())) {
                    $this->jobs->add($assetJob);
                }
                $namesJob = new UpdateCharacterContainerNames($token);
                if (in_array($namesJob->getScope(), $token->getScopes())) {
                    $this->jobs->add($namesJob);
                }
                $industryJob = new Jobs($token);
                if (in_array($industryJob->getScope(), $token->getScopes())) {
                    $this->jobs->add($industryJob);
                }
            }
        }

        if ($this->jobs->isEmpty()) {
            logger()->warning('No jobs scheduled');

            return;
        }

        $batch = \Illuminate\Support\Facades\Bus::batch([$this->jobs->toArray()])
            ->then(function (Batch $batch) {
                logger()->debug(
                    sprintf('[Batches][%s] User Assets batch successfully completed.', $batch->id),
                    [
                        'id' => $batch->id,
                        'name' => $batch->name,
                    ]);
            })->catch(function (Batch $batch, Throwable $throwable) {
                logger()->error(
                    sprintf('[Batches][%s] An error occurred during User Assets batch processing.', $batch->id),
                    [
                        'id' => $batch->id,
                        'name' => $batch->name,
                        'error' => $throwable->getMessage(),
                        'trace' => $throwable->getTrace(),
                    ]);
            })->finally(function (Batch $batch) {
                logger()->info(
                    sprintf('[Batches][%s] User Assets batch executed.', $batch->id),
                    [
                        'id' => $batch->id,
                        'name' => $batch->name,
                        'stats' => [
                            'success' => $batch->totalJobs - $batch->failedJobs,
                            'failed' => $batch->failedJobs,
                            'total' => $batch->totalJobs,
                        ],
                    ]);
            })->onQueue('characters')->name($mainCharacter->name.' Container Names')->allowFailures()->dispatch();
    }
}
