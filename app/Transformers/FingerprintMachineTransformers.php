<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Fingerprint_Machine;

class FingerprintMachineTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Fingerprint_Machine $FM)
    {
        return [
            'Id_Fingerprint_Machine'    => $FM->Id_Fingerprint_Machine,
            'IP'                        => $FM->IP,
            'Comkey'                    => $FM->Comkey,
            'Status'                    => $FM->Status,
        ];
    }
}