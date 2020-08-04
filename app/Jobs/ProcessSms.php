<?php

namespace App\Jobs;

use App\Code;
use App\Winner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProcessSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $sender_number;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * Create a new job instance.
     *
     * @param string $code is the code user sends
     * @param string $sender_number
     * @param \DateTime $time timestamp of user request
     */
    public function __construct(string $code, string $sender_number, \DateTime $time)
    {
        $this->code =$code;
        $this->sender_number =$sender_number;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Illuminate\Contracts\Redis\LimiterTimeoutException
     */
    public function handle()
    {
        Redis::funnel('key')->limit(1)->then(function () {
            //check code is valid
            $code = Code::where('value',$this->code)->first();

            if($code==null){
                return;
            }
            //check limit is not broken

            if($code->request_number >=$code->request_limit){
                $code->request_number++;
                $code->save();
                return;
            }
            //duplicate detection
            $exists = Winner::where('code_id',$code->id)
                ->where('sender_number',$this->sender_number)->first();
//            if($exists!=null){
//                return;
//            }
            //is winner
            $code->request_number++;
            $winner = new Winner();
            $winner->sender_number = $this->sender_number;
            $winner->code_id = $code->id;
            $winner->date = $this->time->format('Y-m-d H:i:s.v');
            //commit changes and winner
            DB::transaction(function () use ($winner, $code) {
                $code->save();
                $winner->save();
            });
        }, function () {
            // Could not obtain lock...
            return $this->release(10);
        });
    }
}
