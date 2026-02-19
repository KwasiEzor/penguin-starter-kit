<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Payments;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

final class TransactionList extends Component
{
    use WithPagination;

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.admin.payments.transaction-list', [
            'orders' => Order::with(['user', 'product'])
                ->latest()
                ->paginate(15),
        ]);
    }
}
