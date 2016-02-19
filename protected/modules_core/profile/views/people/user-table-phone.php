<?php

$phone = [];
if (!empty($item->phone_private)) {
    $phone[] = $item->phone_private;
}
if (!empty($item->phone_work)) {
    $phone[] = $item->phone_work;
}
if (!empty($item->mobile)) {
    $phone[] = $item->mobile;
}

echo(implode(', ', $phone));
