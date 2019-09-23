<?php

namespace App\Console\Commands;

use App\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class PublishSchedulePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = Post::where('status', Config::get('constants.POST_STATUS.SCHEDULING'))->where('published_at', '<=', Carbon::now()->format('Y-m-d h:i:s'))->get();
        foreach ($posts as $post) {
            $post->status = Config::get('constants.POST_STATUS.PUBLISHED');
            $post->save();
        }
    }
}
