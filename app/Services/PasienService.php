<?php

namespace App\Services;

use App\Repositories\Eloquent\PasienRepository;

class PasienService extends BaseService
{
    public function __construct(PasienRepository $repository)
    {
        parent::__construct($repository);
    }

    // Add specific business logic for Pasien
}
