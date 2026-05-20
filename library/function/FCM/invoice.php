<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
require _DIR_('library/function/FCM/formatter');
$page = 'Rincian Transaksi';

if (isset($_GET['code'])) {
    $post_kode = filter($_GET['code']);
    $search = $call->query("SELECT * FROM trx WHERE wid = '$post_kode' AND user = '$sess_username'");
    if ($search->num_rows == 0) redirect(1, base_url('page/riwayat'));
    $rows = $search->fetch_assoc();
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
} else {
    redirect(0, base_url('page/riwayat'));
}

$data = [];

$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];
$data[] = [
    'type' => 'text',
    'content' => $page,
    'option' => [
        'bold' => 1,
        'align' => 2,
        'format' => 3,
    ]
];

$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];


// Product Type
$data[] = [
    'type' => 'text',
    'content' => 'Layanan',
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];

$data[] = [
    'type' => 'multiline',
    'content' => $type . ' ' . $rows['name'],
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];

if ($rows['trxtype'] !== 'shop') {
    // No Tujuan
    $data[] = [
        'type' => 'text',
        'content' => 'No. Tujuan',
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

    $data[] = [
        'type' => 'text',
        'content' => $rows['data'],
        'option' => [
            'bold' => 1,
            'align' => 2,
        ]
    ];
}


// Kategori
$data[] = [
    'type' => 'text',
    'content' => 'Kategori',
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];

$data[] = [
    'type' => 'text',
    'content' => strtoupper($call->query("SELECT * FROM $table WHERE $column = '" . $rows['code'] . "'")->fetch_assoc()[$value]),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];

// No Tujuan
$data[] = [
    'type' => 'text',
    'content' => 'ID Transaksi',
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];

$data[] = [
    'type' => 'text',
    'content' => $post_kode,
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];

// Waktu Transaksi
$data[] = [
    'type' => 'text',
    'content' => 'Waktu Transaksi',
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];

$data[] = [
    'type' => 'text',
    'content' => format_date('id', $rows['date_cr']),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];

// Status
$data[] = [
    'type' => 'text',
    'content' => 'Status',
    'option' => [
        'bold' => 1,
        'align' => 0,
    ]
];

$data[] = [
    'type' => 'text',
    'content' => ucwords($stat),
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];

if ($rows['status'] <> 'processing') {
    // Keterangan
    $data[] = [
        'type' => 'text',
        'content' => 'Keterangan',
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

    $data[] = [
        'type' => 'text',
        'content' => nl2br($rows['note']),
        'option' => [
            'bold' => 1,
            'align' => 2,
        ]
    ];
}

$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];

if($rows['trxtype'] === 'donasi') {
    // Harga
    $data[] = [
        'type' => 'text',
        'content' => 'Harga',
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

    $data[] = [
        'type' => 'text',
        'content' => currency($rows['price']),
        'option' => [
            'bold' => 1,
            'align' => 2,
        ]
    ];
} else {
    // Harga
    $data[] = [
        'type' => 'text',
        'content' => 'Harga',
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

    $data[] = [
        'type' => 'text',
        'content' => currency($price),
        'option' => [
            'bold' => 1,
            'align' => 2,
        ]
    ];
}
    
    // Keterangan
    $data[] = [
        'type' => 'text',
        'content' => 'Biaya Transaksi',
        'option' => [
            'bold' => 1,
            'align' => 0,
        ]
    ];

    if($data_user['level'] == 'Basic' AND $rows['provider'] == 'X') {
        $data[] = [
            'type' => 'text',
            'content' => conf('trxadmin', 3),
            'option' => [
                'bold' => 1,
                'align' => 2,
            ]
        ];
    } elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'X') {
        $data[] = [
            'type' => 'text',
            'content' => "Rp. ".currency(conf('trxadmin', 4)),
            'option' => [
                'bold' => 1,
                'align' => 2,
            ]
        ];
    } elseif($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI') {
        $data[] = [
            'type' => 'text',
            'content' => "Rp. ".currency(conf('trxadmin', 3)),
            'option' => [
                'bold' => 1,
                'align' => 2,
            ]
        ];
    } elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'DIGI') {
        $data[] = [
            'type' => 'text',
            'content' => "Rp. ".currency(conf('trxadmin', 4)),
            'option' => [
                'bold' => 1,
                'align' => 2,
            ]
        ];
    } elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'X') {
        $data[] = [
            'type' => 'text',
            'content' => "Rp. ".currency(conf('trxadmin', 4)),
            'option' => [
                'bold' => 1,
                'align' => 2,
            ]
        ];
    } elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'DIGI') {
        $data[] = [
            'type' => 'text',
            'content' => "Rp. ".currency(conf('trxadmin', 4)),
            'option' => [
                'bold' => 1,
                'align' => 2,
            ]
        ];
    }
$data[] = [
    'type' => 'text',
    'content' => '-----------------------------',
    'option' => [
        'bold' => 1,
        'align' => 2,
    ]
];

echo formatter($data);
