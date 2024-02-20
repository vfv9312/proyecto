<?php

namespace App\Livewire;

use Livewire\Component;

class QuantityComponent extends Component
{
    public function render()
    {
        return view('livewire.quantity-component');
    }
    public $cantidadM;


    public function updatedCantidadM($value)
    {
        // Aquí puedes hacer algo con el nuevo valor de $cantidadM
        $this->cantidadM = $value;

        // Emite un evento con el nuevo valor
        $this->emit('cantidadUpdated', $this->cantidadM);
    }
}
