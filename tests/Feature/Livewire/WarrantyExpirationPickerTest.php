<?php

namespace Tests\Feature\Livewire;

use App\Livewire\WarrantyExpirationPicker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class WarrantyExpirationPickerTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(WarrantyExpirationPicker::class)
            ->assertStatus(200);
    }
}
