<?php namespace BackEnd\Test\Models;

class Test extends \App\Core\BaseModel
{
    protected $table        = 'tests';
    protected $primaryKey   = 'test_id';
    protected $returnType   = 'object';
    protected $fieldPrefix  = 'test';
    protected $useAutoIncrement = false;

    protected $allowedFields= [
        'test_id',
        'test_code',
        'test_name',
        'test_active',
    ];
    
    protected $view     = [
        'tests'     => [
            'datatable' => [
                'test_id',
                'test_code',
                'test_name',
                'test_active',
            ]
        ],
    ];

}