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
        $this->setExpiresAt();
    }

    public function setPurchaseDate($date = null)
    {
        $this->purchase_date = $date;
        $this->setExpiresAt();
    }

    private function setExpiresAt()
    {
        if($this->warranty_months && $this->purchase_date) {
            $this->warranty_expires_at = Carbon::parse($this->purchase_date)->addMonths($this->warranty_months)->format('Y-m-d');
            $this->js("$('#warranty_expires_at').datepicker('update','$this->warranty_expires_at')");
        }
    }

}
