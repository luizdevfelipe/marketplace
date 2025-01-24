<?php
if (!empty($pendentPurchases)) {
    echo '<div class="container rounded border border-dark m-2"><legend class="text-center m-0">Compras Pendentes</legend><p class="fs-6 text-center m-0">Antes de realizar um novo pagamento verifique seu email.</p><ul>';

    $pedidos = [];

    foreach ($pendentPurchases as $purchases) {
        if (array_key_exists($purchases['purchase_id'], $pedidos)) {
            $pedidos[$purchases['purchase_id']][] = $purchases['name'];
        } else {
            $pedidos[$purchases['purchase_id']] = [];
            $pedidos[$purchases['purchase_id']][] = $purchases['name'];
        }
    }

    foreach ($pedidos as $id => $names) {
        $item = '<li> <a class="fs-5" href="' . $link . $id . '">' . implode(' - ', $names) . '</a> </li>';
        echo $item;
    }
    echo '</ul></div>';
}
