<?php

use function Livewire\Volt\{rules,state};

state([
          'email' => '',
          'done' => false,
      ]);

rules([
          'email' => 'required|email',
      ]);

$submit = function () {
    $this->validate();

    // Subscribe the user.

    $this->done = true;
};

?>

<div>
    @if ($done)
        <p>Thank you for subscribing!</p>
    @else
        <form wire:submit="submit">
            <input type="email" wire:model="email" required />

            <button>
                Subscribe
            </button>
        </form>

        @error('email')
        <p>{{ $message }}</p>
        @enderror
    @endif
</div>
