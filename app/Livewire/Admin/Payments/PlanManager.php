<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Payments;

use App\Livewire\Concerns\HasToast;
use App\Models\Plan;
use Livewire\Component;

/**
 * Livewire component for managing subscription plans.
 *
 * Provides CRUD operations for subscription plans including creating,
 * editing, deleting, and toggling the active status of plans. Plans
 * can be linked to Stripe price IDs for payment processing.
 */
final class PlanManager extends Component
{
    use HasToast;

    public bool $showModal = false;

    public ?int $editingPlanId = null;

    public ?int $deletingPlanId = null;

    public string $name = '';

    public string $description = '';

    public int $price = 0;

    public string $stripe_price_id = '';

    public string $interval = 'month';

    public string $featuresText = '';

    public bool $is_active = true;

    public bool $is_featured = false;

    /**
     * Open the modal form for creating a new subscription plan.
     *
     * Resets all form fields to defaults and displays the creation modal.
     *
     * @return void
     */
    public function createPlan(): void
    {
        $this->reset(['editingPlanId', 'name', 'description', 'price', 'stripe_price_id', 'interval', 'featuresText', 'is_active', 'is_featured']);
        $this->is_active = true;
        $this->showModal = true;
    }

    /**
     * Open the modal form for editing an existing subscription plan.
     *
     * Loads the plan data into the form fields and displays the modal.
     *
     * @param  int  $id  The ID of the plan to edit.
     * @return void
     */
    public function editPlan(int $id): void
    {
        $plan = Plan::findOrFail($id);
        $this->editingPlanId = $plan->id;
        $this->name = $plan->name;
        $this->description = $plan->description ?? '';
        $this->price = $plan->price;
        $this->stripe_price_id = $plan->stripe_price_id ?? '';
        $this->interval = $plan->interval;
        $this->featuresText = is_array($plan->features) ? implode("\n", $plan->features) : '';
        $this->is_active = $plan->is_active;
        $this->is_featured = $plan->is_featured;
        $this->showModal = true;
    }

    /**
     * Validate and save the subscription plan (create or update).
     *
     * Validates form inputs, parses the features text into an array,
     * and creates a new plan or updates the existing one.
     *
     * @return void
     */
    public function savePlan(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stripe_price_id' => ['nullable', 'string', 'max:255'],
            'interval' => ['required', 'in:month,year'],
        ]);

        $features = array_filter(array_map(trim(...), explode("\n", $this->featuresText)));

        $data = [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'price' => $this->price,
            'stripe_price_id' => $this->stripe_price_id ?: null,
            'interval' => $this->interval,
            'features' => array_values($features),
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
        ];

        if ($this->editingPlanId) {
            $plan = Plan::findOrFail($this->editingPlanId);
            $plan->update($data);
            $this->toastSuccess('Plan updated successfully.');
        } else {
            Plan::create($data);
            $this->toastSuccess('Plan created successfully.');
        }

        $this->showModal = false;
        $this->reset(['editingPlanId', 'name', 'description', 'price', 'stripe_price_id', 'interval', 'featuresText', 'is_active', 'is_featured']);
    }

    /**
     * Set the plan ID pending deletion to show the confirmation dialog.
     *
     * @param  int  $id  The ID of the plan to confirm deletion for.
     * @return void
     */
    public function confirmDelete(int $id): void
    {
        $this->deletingPlanId = $id;
    }

    /**
     * Cancel the pending plan deletion and dismiss the confirmation dialog.
     *
     * @return void
     */
    public function cancelDelete(): void
    {
        $this->deletingPlanId = null;
    }

    /**
     * Delete the plan pending deletion.
     *
     * @return void
     */
    public function deletePlan(): void
    {
        Plan::findOrFail($this->deletingPlanId)->delete();
        $this->deletingPlanId = null;
        $this->toastSuccess('Plan deleted successfully.');
    }

    /**
     * Toggle the active status of a subscription plan.
     *
     * @param  int  $id  The ID of the plan to toggle.
     * @return void
     */
    public function toggleActive(int $id): void
    {
        $plan = Plan::findOrFail($id);
        $plan->update(['is_active' => ! $plan->is_active]);
        $this->toastSuccess($plan->is_active ? 'Plan activated.' : 'Plan deactivated.');
    }

    /**
     * Render the plan manager view with all plans ordered by sort order and name.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.admin.payments.plan-manager', [
            'plans' => Plan::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
