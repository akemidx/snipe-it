<?php

namespace App\Livewire;

use App\Models\AssetModel;
use App\Models\Asset;
use Illuminate\Support\Carbon;
use Livewire\Component;

class WarrantyExpirationPicker extends Component
{
    public $warranty_months = 0;
    public $purchase_date = null;
    public $warranty_expires_at = null;
    public function render()
    {
        return view('livewire.warranty-expiration-picker');
    }

    public function setWarrantyMonthsFromModel($id)
    {
        $this->warranty_months = AssetModel::find($id)->warranty_months;
        $this->purchase_date = now()->format('Y-m-d');
        $this->warranty_expires_at = Carbon::parse($this->purchase_date)->addMonths($this->warranty_months)->format('Y-m-d');
        $this->js("$('#warranty_expires_at').datepicker('update','warranty_expires_at')");
        //using the value, we can populate the datepicker on update



    }

    public function setPurchaseDateFromAsset($id = null) //id will be null for an asset that has not yet been created, so easy to use this as a flag.
    {
        //if new then choose now
        if($id=='') {
            $this->purchase_date = now();
        }

        //if edit then grab it from asset id
        else {
            $this->purchase_date = Asset::find($id)->purchase_date;
        }
    }

    public function setWarrantyExpirationOnAsset($id,$date)
    {
        $this->id = $id;
        $this->id->warranty_expires_at = $date;

    }

}
