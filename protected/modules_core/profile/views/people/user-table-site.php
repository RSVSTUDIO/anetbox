<?php

$site = [];

if (!empty($user->userSite)) {
    foreach ($user->userSite as $item) {
        $site[] = CHtml::encode($item->url);
    }
}

echo(implode(', ', $site));
