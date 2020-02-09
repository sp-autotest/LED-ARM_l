<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\History;
use Auth;

class HistoryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Работает только с ивентами моделей
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $h = new History;
        $h->past_json = json_encode($event->pastdata);
        $h->now_json = json_encode($event->data);
        $h->author = Auth::user()->id;
        $h->model = $event->modelname;
        $h->save();
    }
}
