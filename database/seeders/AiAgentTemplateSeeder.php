<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AiProviderEnum;
use App\Models\AiAgent;
use App\Models\User;
use Illuminate\Database\Seeder;

class AiAgentTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::role('admin')->first() ?? User::factory()->create();

        $templates = [
            [
                'name' => '✨ Professional Copy Editor',
                'description' => 'Fixes grammar, improves flow, and adjusts tone to be more professional and engaging.',
                'system_prompt' => 'You are an expert copy editor. Your goal is to refine the provided text. Fix all grammatical errors, improve sentence flow, and ensure the tone is professional yet engaging. Do not change the underlying meaning, but make it shine. Return only the edited text.',
                'provider' => AiProviderEnum::OpenAi->value,
                'model' => 'gpt-4o',
                'temperature' => 0.7,
                'max_tokens' => 2000,
                'is_public' => true,
            ],
            [
                'name' => '🔍 SEO Content Wizard',
                'description' => 'Generates optimized meta titles, descriptions, and keywords based on your content.',
                'system_prompt' => 'You are an SEO specialist. Based on the content provided, generate: 1. A compelling Meta Title (max 60 chars), 2. A Meta Description (max 160 chars) that encourages clicks, and 3. A list of 5 target keywords. Format the output clearly.',
                'provider' => AiProviderEnum::Anthropic->value,
                'model' => 'claude-3-5-sonnet-latest',
                'temperature' => 0.5,
                'max_tokens' => 1000,
                'is_public' => true,
            ],
            [
                'name' => '🛠️ Code Architect',
                'description' => 'Reviews code snippets for best practices, security issues, and performance optimizations.',
                'system_prompt' => 'You are a senior software architect. Review the provided code snippet. Identify any security vulnerabilities, performance bottlenecks, or violations of clean code principles. Provide specific suggestions for improvement and a refactored version of the code.',
                'provider' => AiProviderEnum::OpenAi->value,
                'model' => 'gpt-4o',
                'temperature' => 0.3,
                'max_tokens' => 3000,
                'is_public' => true,
            ],
        ];

        foreach ($templates as $template) {
            AiAgent::updateOrCreate(
                ['name' => $template['name']],
                array_merge($template, ['user_id' => $admin->id])
            );
        }
    }
}
