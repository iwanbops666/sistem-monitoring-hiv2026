<?php

namespace App\Repositories\Eloquent;

use App\Models\Pasien;

class PasienRepository extends BaseEloquentRepository
{
    public function __construct(Pasien $model)
    {
        parent::__construct($model);
    }

    public function paginate($perPage = 10, $search = null, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nomor_rm', 'like', "%{$search}%")
                  ->orWhere('no_registrasi_nasional', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage, $columns);
    }
}
