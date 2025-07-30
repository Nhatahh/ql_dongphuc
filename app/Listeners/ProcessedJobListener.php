<?php

namespace App\Listeners;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessedJobListener implements ShouldQueue
{
    public function handle(JobProcessed $event)
    {
        // Xử lý công việc sau khi hoàn thành
        $job = $event->job;
        // $result = $job->result; // Kết quả của công việc
        // Lưu trữ kết quả vào cơ sở dữ liệu, bạn có thể sử dụng model tương ứng với bảng lưu trữ kết quả
        // Ví dụ:
        DB::table('24_testqueue')
        ->insert([
            'id_queue' => 111,
        ]);
        // dd(1111);
        // $queueResult = new QueueResult();
        // $queueResult->job_id = $job->getJobId();
        // $queueResult->result = $result;
        // $queueResult->save();
    }
}
