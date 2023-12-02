<?php

namespace App\Services\GatewayPayment\Gateways\MercadoPago;

use App\Services\GatewayPayment\Contracts\StatusTransactionInterface;

class StatusTransaction implements StatusTransactionInterface
{
    // Nova cobrança criada.
    const CHARGE_CREATED = 'OPENPIX:CHARGE_CREATED';

    // Cobrança concluída é quando uma cobrança é totalmente paga.
    const CHARGE_COMPLETED = 'OPENPIX:CHARGE_COMPLETED';

    // Cobrança expirada é quando uma cobrança não foi totalmente paga e expirou.
    const CHARGE_EXPIRED = 'OPENPIX:CHARGE_EXPIRED';

    // Nova transação PIX recebida.
    const TRANSACTION_RECEIVED = 'OPENPIX:TRANSACTION_RECEIVED';

    // Novo reembolso de transação PIX recebido ou reembolsado.
    const TRANSACTION_REFUND_RECEIVED = 'OPENPIX:TRANSACTION_REFUND_RECEIVED';

    // Pagamento confirmado é quando a transação do pix referente ao pagamento é confirmada.
    const MOVEMENT_CONFIRMED = 'OPENPIX:MOVEMENT_CONFIRMED';

    // Falha no pagamento é quando o pagamento é aprovado e ocorre um erro.
    const MOVEMENT_FAILED = 'OPENPIX:MOVEMENT_FAILED';

    // O pagamento foi removido por um usuário.
    const MOVEMENT_REMOVED = 'OPENPIX:MOVEMENT_REMOVED';
}
