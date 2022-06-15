<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ResetController extends Controller
{
    public function __invoke()
    {
        Artisan::call('migrate:fresh --seed');

        $directories = ['categories', 'products'];

        foreach ($directories as $directory)
        {
            Storage::deleteDirectory($directory);
            Storage::makeDirectory($directory);

            $files = Storage::disk('reset')->files($directory);

            foreach ($files as $file)
            {
                Storage::disk('public')->put($file, Storage::disk('reset')->get($file));
            }
        }

        session()->flash('successReset', 'Проект успешно сброшен в начальное состояние!');

        return to_route('index');
    }
}
