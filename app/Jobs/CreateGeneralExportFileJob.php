<?php

namespace App\Jobs;

use App\Models\GeneralExport;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateGeneralExportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 1200;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private GeneralExport $export,
        private string $exportFileName,
        private int $page = 1,
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       // ini_set('memory_limit', -1);

        try {

            $members = $this->getMembers();

            $columns = [
                'Member ID',
                'Full Name',
                'Phone Number',
                'Gender',
                'Date of Birth',
                'Email',
            ];

            $filesystemAdapter = Storage::disk('public');
            if($this->export->status === 'pending') {
                $fileName = 'general_exports/' . Carbon::now()->timestamp . '-' . $this->exportFileName . '-' . $this->export->user_id . '.csv';

                // add the headers only on the first run of this job... on subsequent runs, only append the data
                $filesystemAdapter->append($fileName, implode(',', $columns) . PHP_EOL);
            } else {
                $fileName = $this->exportFileName;
            }

            if($this->export->status !== 'processing') {
                $this->export->update([
                                          'status' => 'processing',
                                          'status_message' => "Job {$this->page} in export processing started"
                                      ]);
            } elseif($this->export->status === 'processing') {
                $this->export->update([
                                          'status_message' => "Job {$this->page} in export processing started"
                                      ]);
            }

            $fileResource = fopen($filesystemAdapter->path($fileName), 'a+');

            foreach ($members as $member) {
                fwrite($fileResource, implode(',', [
                                        $member->id,
                                        $member->name,
                                        $member->phone,
                                        $member->gender,
                                        $member->dob,
                                        $member->email,
                                    ]) . PHP_EOL);
            }

            fclose($fileResource);

            $nextPageUrl = $members->nextPageUrl();
            $nextPage = null;
            if(!is_null($nextPageUrl)) {
                $nextPage = explode('=', $nextPageUrl, 2)[1];
            }

            if(is_null($nextPage)) {
                // we are done processing
                $this->export->update([
                                          'status' => 'processed',
                                          'status_message' => 'Export file processed successfully and ready for download',
                                          'file' => $fileName,
                                      ]);
                return;
            }

            // refresh to get current state of export before using it for next job
            $this->export->refresh();

            dispatch(new static($this->export, $fileName, $nextPage));

        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
        //dd('df');

    }


    public function getMembers() {
       // dd($this->page);
    Log::info(['page no ' => $this->page]);

    return Member::paginate(10000, ['*'], 'page', $this->page);
    }

}
