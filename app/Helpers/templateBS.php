<?php
namespace App\Helpers;

class TemplateBS
{
    public static function showItemHistory($by, $time)
    {
        $formattedTime = date(config('zvn.format.short_time'), strtotime($time));
        $xhtml = sprintf(
            '<p class="mb-0"><i class="far fa-clock"></i> %s</p>
            <p class="mb-0"><i class="far fa-user"></i> %s</p>',
            $formattedTime,
            $by
        );
        return $xhtml;
    }

    public static function showItemStatus($controllerName, $id, $status)
    {
        $statusConfig = [
            1 => ['icon' => 'fa-check', 'class' => 'btn-success'],
            0 => ['icon' => 'fa-minus', 'class' => 'btn-danger']
        ];

        $currentStatus = $statusConfig[$status] ?? $statusConfig[0];
        $link = route($controllerName . '/status', ['status' => $status, 'id' => $id]);

        $xhtml = sprintf(
            '<a href="%s" class="btn %s rounded-circle btn-sm"><i class="fas %s"></i></a>',
            $link,
            $currentStatus['class'],
            $currentStatus['icon']
        );
        return $xhtml;
    }
}
