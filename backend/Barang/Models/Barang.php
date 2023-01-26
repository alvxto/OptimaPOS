<?php

namespace BackEnd\Barang\Models;

class Barang extends \App\Core\BaseModel
{
    protected $table        = 'barang';
    protected $primaryKey   = 'barang_id';
    // protected $fieldPrefix  = 'barang'; 

    protected $allowedFields = [
        'barang_id',
        'barang_kode',
        'barang_nama',
        'barang_stok',
        'barang_harga',
        'barang_kategori_id',
        'barang_satuan_id',
        'barang_aktif',
        'barang_perusahaan_id',
        'barang_user_id',
    ];
    protected $view = [
        'barang' => [
            'datatable' => [
                'barang_id',
                'barang_kode',
                'barang_nama',
                'barang_stok',
                'barang_harga',
                'barang_aktif',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'program_aktif',
    ];
}
