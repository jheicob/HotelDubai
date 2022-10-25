<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class InvoicePayment extends Model implements Auditable
{
    use HasFactory;
    use AuditingAuditable;

    const DIVISA = 'divisa';
    const BS = 'Bs';

    const EFECTIVO = 'efectivo';
    const DIGITAL = 'digital';
    const TARJETA = 'tarjeta';

    protected $fillable = [
        'invoice_id',
        'type', // ['divisa', 'Bs']
        'method', // ['efectivo', 'digital', 'tarjeta']
        'quantity',
        'description',
    ];

    protected $auditInclude = [
        'invoice_id',
        'type',
        'method',
        'quantity',
        'description',
    ];

    /**
     * get belongs to invoice
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
