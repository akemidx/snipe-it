<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class LocationObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Location  $location
     * @return void
     */
    public function updated(Location $location)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Location::class;
        $logAction->item_id = $location->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('update');
    }

    /**
     * Listen to the Location created event when
     * a new location is created.
     *
     * @param  Location  $location
     * @return void
     */
    public function created(Location $location)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Location::class;
        $logAction->item_id = $location->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        if($location->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('create');
    }

    /**
     * Listen to the Location deleting event.
     *
     * @param  Location  $location
     * @return void
     */
    public function deleting(Location $location)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Location::class;
        $logAction->item_id = $location->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('delete');
    }
}
