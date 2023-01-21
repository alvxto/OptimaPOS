<?php

namespace BackEnd\Pekerjaan\Models;

class PekerjaanDetail extends \App\Core\BaseModel
{
    protected $table        = 'pekerjaan_dokumen';
    protected $primaryKey   = 'pekerjaan_dokumen_id';
    protected $fieldPrefix  = 'pekerjaan_dokumen';

    protected $allowedFields = [
        'pekerjaan_dokumen_id',
        'pekerjaan_dokumen_pekerjaan_id',
        'pekerjaan_dokumen_no',
        'pekerjaan_dokumen_tgl',
        'pekerjaan_dokumen_created_at',
        'pekerjaan_dokumen_updated_at',
        'pekerjaan_dokumen_created_by',
        'pekerjaan_dokumen_type',
        'pekerjaan_dokumen_file',
        'pekerjaan_dokumen_file_name',
        'pekerjaan_dokumen_keterangan',
    ];
}
