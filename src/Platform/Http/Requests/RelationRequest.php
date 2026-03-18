<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class RelationRequest extends FormRequest
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
            'search'        => 'sometimes|string|nullable',
            'model'         => 'required|string',
            'key'           => 'required|string',
            'name'          => 'required|string',
            'scope'         => 'sometimes|nullable|string',
            'append'        => 'sometimes|nullable|string',
            'searchColumns' => 'sometimes|nullable|string',
            'chunk'         => 'sometimes|integer|min:1|max:100',
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
     * Resolve and return decrypted payload for the relation loader.
     * Use this in the controller instead of manual decrypt.
     *
     * @return array{model: string, name: string, key: string, scope: array|null, append: string|null, searchColumns: array|null, search: string, chunk: int}
     */
    public function resolvedPayload(): array
    {
        $validated = $this->validatedWithDefaults();

        $decrypt = fn (mixed $value): ?string => $value === null || $value === ''
            ? null
            : Crypt::decryptString($value);

        $decryptArray = fn (mixed $value): ?array => $value === null || $value === ''
            ? null
            : Crypt::decrypt($value);

        return [
            'model'         => $decrypt($validated['model'] ?? null) ?? '',
            'name'          => $decrypt($validated['name'] ?? null) ?? '',
            'key'           => $decrypt($validated['key'] ?? null) ?? '',
            'scope'         => $decryptArray($validated['scope'] ?? null),
            'append'        => $decrypt($validated['append'] ?? null),
            'searchColumns' => $decryptArray($validated['searchColumns'] ?? null),
            'search'        => (string) ($validated['search'] ?? $this->input('search', '')),
            'chunk'         => (int) ($validated['chunk'] ?? self::DEFAULT_CHUNK),
        ];
    }
}
