<?php

namespace App\Console\Commands;

use App\Logic\Logger;
use App\Models\DbLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $this->info('Sending logs...');

        do{
            $logs = DbLog::where(['send'=>false])
                ->limit(50)
                ->get();

            foreach($logs as $log) {
                $text = "<pre>$log->header</pre>" . PHP_EOL
                    . '<b>Timestamp:</b> ' . $log->created_at . PHP_EOL
                    . '<b>Message:</b>' . PHP_EOL;

                $first_seven_lines = array_slice(explode(PHP_EOL, $log->body), 0, 4);
                $log_detail        = htmlspecialchars(implode(PHP_EOL, $first_seven_lines));
                $final_write_log   = substr($log_detail, 0, 4096 - strlen($text));

                $message = [
                    'text'       => $text
                        . '<code>' . $final_write_log . '</code>' . PHP_EOL,
                    'parse_mode' => 'HTML',
                ];

                $response =Http::accept('application/json')
                    ->post('https://api.telegram.org/bot' . config('app.api_token') . '/sendMessage',[
                        'chat_id'    => config('app.chat_id_telegram'),
                        'text'       => $message['text'],
                        'parse_mode' => $message['parse_mode'],
                    ]);

                if (!$response->successful()) {
                    Logger::writeLog('Error send log',$response);
                    return ;
                }
                $log->send = true;
                $log->save();
            }
        }while(count($logs) == 50);



        $this->info('Stop sending logs...');
    }
}
