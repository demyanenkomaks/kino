<?php

namespace Modules\Kino\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class KinoPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Kino';
    }

    public function getId(): string
    {
        return 'kino';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
