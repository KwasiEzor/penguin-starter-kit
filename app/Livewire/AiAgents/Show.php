<?php

declare(strict_types=1);

namespace App\Livewire\AiAgents;

use App\Livewire\Concerns\HasToast;
use App\Models\AiAgent;
use App\Models\AiExecution;
use App\Services\Ai\AiService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Show extends Component
{
    use HasToast;

    public AiAgent $aiAgent;

    public string $taskInput = '';

    public ?AiExecution $latestExecution = null;

    public bool $isExecuting = false;

    public function mount(AiAgent $aiAgent): void
    {
        $this->authorize('view', $aiAgent);
        $this->aiAgent = $aiAgent;
    }

    public function executeTask(AiService $aiService): void
    {
        $this->validate([
            'taskInput' => ['required', 'string'],
        ]);

        $this->authorize('execute', $this->aiAgent);

        $this->isExecuting = true;

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->latestExecution = $aiService->execute($this->aiAgent, $this->taskInput, $user);

        $this->isExecuting = false;

        if ($this->latestExecution->status === 'failed') {
            $this->toastError($this->latestExecution->error_message ?? 'Execution failed.');
        } else {
            $this->toastSuccess('Task executed successfully.');
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $recentExecutions = AiExecution::where('ai_agent_id', $this->aiAgent->id)
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.ai-agents.show', [
            'recentExecutions' => $recentExecutions,
        ]);
    }
}
