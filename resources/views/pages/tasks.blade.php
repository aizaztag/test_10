<?php

use function Livewire\Volt\state;
use App\Models\Task;

state(description: '', tasks: fn () => Task::all());

$addTask = function () {
    Task::create(['description' => $this->description]);

    $this->description = '';
    $this->tasks = Task::all();
}; ?>

<html>
<head>
    <title>Tasks</title>
</head>
<body>
@volt
<div>
    <h1>Add Task </h1>
    <form wire:submit="addTask">
        <input type="text" wire:model="description">
        <button type="submit">Add</button>
    </form>

    <h1>Tasks</h1>
    <ul>
        @foreach ($tasks as $task)
            <li>{{ $task->description }}</li>
        @endforeach
    </ul>
</div>
@endvolt
</body>
</html>
