<?php namespace BackEnd\Kegiatan\Models;

class Kegiatan extends \App\Core\BaseModel
{
    protected $table        = 'kegiatan';
    protected $primaryKey   = 'kegiatan_id';
     
    protected $allowedFields = [
        'kegiatan_id',
        'kegiatan_kode',
        'kegiatan_nama',
        'kegiatan_keterangan',
        'kegiatan_aktif',
        'kegiatan_created_at',
        'kegiatan_updated_at',
        'kegiatan_program_id'
    ];
    protected $view = [
        'kegiatan'=>[
            'datatable'=>[
                'kegiatan_id',
                'kegiatan_kode',
                'kegiatan_nama',
                'kegiatan_keterangan',
                'kegiatan_aktif',
            ]
        ]
    ];
    // fields in excludeSearchFields will be excluded from searching mechanism
    protected $excludeSearchFields = [
        'kegiatan_aktif',
    ];
}