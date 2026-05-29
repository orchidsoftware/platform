<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Orchid\Screen\Fields\Support\ChoicePayload;
use Throwable;

class ChoicesRequest extends FormRequest
{
    /**
     * Default chunk size for lazy select options.
     */
    public const DEFAULT_CHUNK = 10;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'search'  => 'sometimes|string|nullable',
            'choices' => 'required|string',
            'chunk'   => 'sometimes|integer|min:1|max:100',
        ];
    }

    /**
     * Get validated input with sensible defaults for optional fields.
     *
     * @return array<string, mixed>
     */
    protected function validatedWithDefaults(): array
    {
        $validated = $this->validated();

        return [
            ...$validated,
            'search' => (string) ($validated['search'] ?? $this->input('search', '')),
            'chunk'  => isset($validated['chunk']) ? (int) $validated['chunk'] : self::DEFAULT_CHUNK,
        ];
    }

    /**
     * Resolve and return decrypted payload for the choices loader.
     */
    public function payload(): ChoicePayload
    {
        $validated = $this->validatedWithDefaults();

        try {
            $payload = ChoicePayload::fromEncrypted($validated['choices']);

            return $payload
                ->withSearch((string) ($validated['search'] ?? ''))
                ->withChunk((int) ($validated['chunk'] ?? $payload->chunk))
                ->assertValid();
        } catch (Throwable) {
            throw ValidationException::withMessages([
                'choices' => __('The choices payload is invalid.'),
            ]);
        }
    }
}
