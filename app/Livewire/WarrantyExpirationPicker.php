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
        //$this->purchase_date = now()->format('Y-m-d');
        $this->setExpiresAt();
        //$('#purchase_date_wrapper').datepicker('update', new Date(2024, 8, 02));
        //using the value, we can populate the datepicker on update
    }

    public function updated($property)
    {
        // $property: The name of the current property that was updated
        //dump($property);
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

    public function setPurchaseDate($date = null)
    {
        $this->purchase_date = $date;
        $this->setExpiresAt();
    }

    public function setWarrantyExpirationOnAsset($id,$date)
    {
        $this->id = $id;
        $this->id->warranty_expires_at = $date;

    }

    private function setExpiresAt()
    {
        if($this->warranty_months && $this->purchase_date) {
            $this->warranty_expires_at = Carbon::parse($this->purchase_date)->addMonths($this->warranty_months)->format('Y-m-d');
            $this->js("$('#warranty_expires_at').datepicker('update','$this->warranty_expires_at')");
        }
    }

}
