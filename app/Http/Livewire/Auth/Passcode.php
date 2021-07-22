<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Http\Livewire\Modal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Passcode extends Modal
{
    use AuthorizesRequests;

    public $passcode = "";
    public $itemId;
    public $isCustom;

    protected $listeners = [
        'voidPasscode' => 'void'
    ];

    protected $rules = [
        'isCustom' => 'boolean'
    ];

    public function mount()
    {
        $this->authorize('manage');
    }

    public function void($id, $isCustom)
    {
        $this->toggleModal();
        $this->itemId = $id;
        $this->isCustom = $isCustom;
    }

    public function enterPasscode()
    {

        $user = User::where('passcode', $this->passcode)->first();

        if ($user && ($user->role->name == "admin" || $user->role->name == "operation")) {
            $this->emit('void', $this->itemId, $this->isCustom);
            $this->close();
        } else {
            $this->addError('passcode', 'Passcode incorrect');
            $this->reset('passcode');
        }
    }

    public function close()
    {
        $this->reset('passcode');
        $this->toggleModal();
    }

    public function render()
    {
        return view('livewire.auth.passcode');
    }
}
