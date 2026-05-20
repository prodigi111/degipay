<?php
require '../RGShenn.php';
require _DIR_('library/function/FCM/formatter');
// $page = 'Rincian Transaksi';
if (isset($_GET['code'])) {
    $post_kode = filter($_GET['code']);
    
    // if(isset($_GET['price'])) file_put_contents("debug-price-".time().".json", json_encode($_GET));

    $search = $call->query("SELECT * FROM trx WHERE wid = '$post_kode'");
    
    if ($search->num_rows == 0) redirect(1, base_url('page/riwayat'));  
    $rows = $search->fetch_assoc();
    
    
    $query_user = $call->query("SELECT * FROM users WHERE username='$rows[user]'");
    if ($query_user->num_rows == 0) {
        echo " no user";
        die;
        redirect(1, base_url('login'));
    }
    
    $data_user = $query_user->fetch_assoc();
    
    if ($data_user['level'] == 'Basic' and $rows['provider'] == 'X') {
        $price = $rows['price'] + conf('trxmanual', 3);
    } else if ($data_user['level'] == 'Premium' and $rows['provider'] == 'X') {
        $price = $rows['price'] + conf('trxmanual', 4);
    } else if ($data_user['level'] == 'Basic' and $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if ($data_user['level'] == 'Basic' and $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if ($data_user['level'] == 'Admin' and $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if ($data_user['level'] == 'Admin' and $rows['provider'] == 'X') {
        $price = $rows['price'] + conf('trxmanual', 4);
    }


    if ($rows['status'] == 'error') {
        $label = 'danger';
        $class = '';
        $icon = 'close-circle-outline';
        $status = 'Transaksi Gagal';
    } elseif ($rows['status'] == 'success') {
        $label = 'success';
        $class = '';
        $icon = 'checkmark-done-outline';
        $status = 'Transaksi Berhasil';
    } else {
        $label = 'warning';
        $class = 'rgs-r90';
        $icon = 'hourglass-outline';
        $status = 'Transaksi Sedang Di Proses';
    }

    if ($rows['trxtype'] == 'shop') {
        $table = 'produk';
        $column = 'kode';
        $value = 'kategori';
        $type = 'SHOP';
    } elseif ($rows['trxtype'] == 'donasi') {
        $table = 'srv_donasi';
        $column = 'code';
        $value = 'category';
        $type = str_replace('-', ' ', strtoupper($call->query("SELECT * FROM srv_donasi WHERE code = '" . $rows['code'] . "'")->fetch_assoc()['type']));
    } elseif ($rows['trxtype'] == 'manual') {
        $table = 'trx';
        $column = 'code';
        $value = 'name';
        $type = 'Manual Transaksi';
    } else {
        $table = 'srv';
        $column = 'code';
        $value = 'brand';
        $type = str_replace('-', ' ', strtoupper($call->query("SELECT * FROM srv WHERE code = '" . $rows['code'] . "'")->fetch_assoc()['type']));
    }

    $stat = $rows['status'] == 'error' && $rows['refund'] == '1' ? 'Refund' : $rows['status'];
    
    
$data = [];

$data[] = [
    'type' => 'text',
    'content' => '',
    'option' => [
        'bold' => 1,
        'align' => 1,
    ]
];
$data[] = [
    'type' => 'text',
    'content' => $_GET['header'] ?? 'Rincian Transaksi',
    'option' => [
        'bold' => 1,
        'align' => 1,
        // 'format' => 4,
    ]
];

$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [
        'bold' => 1,
        'align' => 1,
    ]
];


// Product Type
$data[] = [
    'type' => 'multiline',
    'content' => 'ID TRANSAKSI : '.($post_kode ?? ""),
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];

/*
$data[] = [
    'type' => 'multiline',
    'content' => $type . ' ' . $rows['name'],
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];
*/
if ($rows['trxtype'] !== 'shop') {
    // No Tujuan
    $data[] = [
        'type' => 'multiline',
        'content' => 'NO TUJUAN :  '.($rows['data'] ?? ""),
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];
    /*
    $data[] = [
        'type' => 'text',
        'content' => $rows['data'],
        'option' => [
            'bold' => 1,
            'align' => 2,
        ]
    ];
    */
}


// Kategori
$data[] = [
    'type' => 'multiline',
    'content' => 'KATEGORI  : '.(strtoupper($call->query("SELECT * FROM $table WHERE $column = '" . $rows['code'] . "'")->fetch_assoc()[$value]) ?? ""),
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];
 /*
$data[] = [
    'type' => 'text',
    'content' => strtoupper($call->query("SELECT * FROM $table WHERE $column = '" . $rows['code'] . "'")->fetch_assoc()[$value]),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];
*/

// No Tujuan
$data[] = [
    'type' => 'multiline',
    'content' => 'LAYANAN : '.($rows['name'] ?? ""),
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];

/*
$data[] = [
    'type' => 'text',
    'content' => $post_kode,
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];
*/

// Waktu Transaksi
$data[] = [
    'type' => 'multiline',
    'content' => 'WAKTU TRX : '.(format_date('id', $rows['date_cr']) ?? ""),
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];
/*
$data[] = [
    'type' => 'text',
    'content' => format_date('id', $rows['date_cr']),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];
*/
// Status
$data[] = [
    'type' => 'text',
    'content' => 'STATUS : '.(ucwords($stat) ?? ""),
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];
/*
$data[] = [
    'type' => 'text',
    'content' => ucwords($stat),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];
*/

if ($rows['status'] <> 'processing') {
    // Keterangan
    $data[] = [
        'type' => 'text',
        'content' => 'KETERANGAN : '.(nl2br($rows['note']) ?? ""),
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];
/*
    $data[] = [
        'type' => 'multiline',
        'content' => nl2br($rows['note']),
        'option' => [
            'bold' => 0,
            'align' => 2,
        ]
    ];
    */
}

$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [
        'bold' => 1,
        'align' => 1,
    ]
];
$price_struk = 0;
if($rows['trxtype'] == 'donasi') {
    // Harga
    $data[] = [
        'type' => 'text',
        'content' => 'Harga',
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

   $price_struk = $_GET['price'] ?? $rows['price'];
} else {
    // Harga 
    $price_struk = $_GET['price'] ?? $price;
    $data[] = [
        'type' => 'text',
        'content' => 'HARGA :         Rp.  '.(currency($price_struk) ?? ""),
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

    $price_struk = $_GET['price'] ?? $price;
}
/*
$data[] = [
    'type' => 'text',
    'content' => 'Rp. '.currency($price_struk),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];
*/

// if($price_struk == $_GET['price']) {
    // Biaya Transaksi
    $biaya_transaksi = 0;
    if($data_user['level'] == 'Basic' AND $rows['provider'] == 'X') {
        $biaya_transaksi = conf('trxadmin', 3);
    } elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'X') {
        $biaya_transaksi = conf('trxadmin', 4);
    } elseif($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI') {
        $biaya_transaksi = conf('trxadmin', 3);
    } elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'DIGI') {
        $biaya_transaksi = conf('trxadmin', 4);
    } elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'X') {
        $biaya_transaksi = conf('trxadmin', 4);
    } elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'DIGI') {
        $biaya_transaksi = conf('trxadmin', 4);
    }
    
    $data[] = [
        'type' => 'text',
        'content' => 'BIAYA TRANSAKSI : Rp. '.(currency($biaya_transaksi) ?? ""),
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];
    /*
    $biaya_transaksi = 0;
    if($data_user['level'] == 'Basic' AND $rows['provider'] == 'X') {
        $biaya_transaksi = conf('trxadmin', 3);
    } elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'X') {
        $biaya_transaksi = conf('trxadmin', 4);
    } elseif($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI') {
        $biaya_transaksi = conf('trxadmin', 3);
    } elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'DIGI') {
        $biaya_transaksi = conf('trxadmin', 4);
    } elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'X') {
        $biaya_transaksi = conf('trxadmin', 4);
    } elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'DIGI') {
        $biaya_transaksi = conf('trxadmin', 4);
    }
    
    $data[] = [
        'type' => 'text',
        'content' => 'Rp. '.currency($biaya_transaksi),
        'option' => [
            'bold' => 1,
            'align' => 2,
        ]
    ];
    */
// }

$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [
        'bold' => 1,
        'align' => 1,
    ]
];

$total_angka = 0;
if($rows['trxtype'] == 'donasi') {
    // Total Donasi
    $data[] = [
        'type' => 'text',
        'content' => 'Total Donasi',
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

   $total_angka = $price_struk+$biaya_transaksi;
} else {
    // Harga
    $total_angka = $price_struk+$biaya_transaksi;
    $data[] = [
        'type' => 'text',
        'content' => 'TOTAL PEMBAYARAN : Rp. '.(currency($total_angka) ?? ""),
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

}
/*
$data[] = [
    'type' => 'text',
    'content' => 'Rp. '.currency($total_angka),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
]; 
*/
$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [ 
        'bold' => 1,
        'align' => 1,
    ]
];
$data[] = [
    'type' => 'multiline',
    'content' => $_GET['footer'] ?? 'TERIMA KASIH SUDAH BERBELANJA',
    'option' => [ 
        'bold' => 1,
        'align' => 1,
    ]
];
$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [ 
        'bold' => 1,
        'align' => 1,
    ]
];
$data[] = [
    'type' => 'qr',
    'content' => 'https://plisspa.id',
    'option' => [
        'bold' => 1,
        'align' => 1,
        'format' => 4,
        ]
    ];

echo formatter($data);

// print_r($data);
// echo $_GET['code'];
die;
} else {
    redirect(0, base_url('page/riwayat'));
}
