<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;

use App\User;
use App\Link;

class PocketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $links;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($links)
    {
        //
        $this->links = $links;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*foreach($this->links as $link) {
            Log::info("Adding {$link['title']} to DB.");            
            
            $dblink = Link::firstOrNew(['user_id'=>$link['user_id'], 'link'=>$link['link']]);
            $dblink->user_id = $link['user_id'];
            $dblink->title = $link['title'];
            $dblink->link = $link['link'];
            // rtconner tags
            if($link['tags'] != null) {
                $dblink->save();
                $dblink->tag(explode(' ', $link['tags']));
            }
            $dblink->save();
        }*/
        
        foreach ($this->links as $link) {
            $user = Auth::find($link['user_id']);
            
        }
    }
}
