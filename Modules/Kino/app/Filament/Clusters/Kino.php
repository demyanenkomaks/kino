<?php

namespace Modules\Kino\Filament\Clusters;

use Filament\Clusters\Cluster;
use Nwidart\Modules\Facades\Module;

class Kino extends Cluster
{
    protected static ?string $clusterBreadcrumb = 'Кино';

    public static function getModuleName(): string
    {
        return 'Kino';
    }

    public static function getModule(): \Nwidart\Modules\Module
    {
        return Module::findOrFail(static::getModuleName());
    }

    public static function getNavigationLabel(): string
    {
        return __('Кино');
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-s-video-camera';
    }
}
