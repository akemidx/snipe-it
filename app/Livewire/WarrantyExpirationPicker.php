<?php

namespace App\Livewire;

use App\Models\AssetModel;
use Livewire\Component;

class WarrantyExpirationPicker extends Component
{
    public $warranty_months = 0;
    public function render()
    {
        return view('livewire.warranty-expiration-picker');
    }

    public function setWarrantyMonthsFromModel($id)
    {
        $this->warranty_months = AssetModel::find($id)->warranty_months;
    }
}
