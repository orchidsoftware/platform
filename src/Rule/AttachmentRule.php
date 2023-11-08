<?php

namespace Orchid\Rule;

use Closure;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Collection;
use Orchid\Attachment\Models\Attachment;
use Storage;
use Symfony\Component\HttpFoundation\File\File as FileSymfony;

class AttachmentRule implements ValidationRule
{
    /** @var Collection<Attachment>} */
    protected Collection $attachment;

    /**
     * @param mixed $rules правила валидации файлов Attachment см. документацию по валидации файлов.
     *                     Например: File::image()->dimensions(Rule::dimensions()->maxWidth(960)->maxHeight(639)) или
     *                     то-же самое 'image|dimensions:min_width=960,min_height=639'
     * @param bool $removeFailed удалять или нет файлы, не прошедшие валидацию
     */
    public function __construct(protected mixed $rules, protected bool $removeFailed = true)
    {
    }

    /**
     * Получение Attachment для валидации
     * @param mixed $ids
     * @return void
     */
    protected function setAttachment(mixed $ids): void
    {
        $this->attachment = is_array($ids)
            ? Attachment::whereIn('id', $ids)->get()
            : Attachment::where('id', $ids)->get();

        $this->attachment = $this->attachment->mapWithKeys(fn(Attachment $attachment) => ["_{$attachment->id}" => $attachment]);
    }

    /**
     * Получение объекта типа \Symfony\Component\HttpFoundation\File\File из AttachmentModel
     *
     * @param Attachment $attachment
     * @return FileSymfony|null
     */
    protected function getFileObjectFromAttachment(Attachment $attachment): ?FileSymfony
    {
        if ($attachment->exists) {
            /** @var Filesystem|Cloud $disk */
            $disk = Storage::disk($attachment->disk);
            return new FileSymfony($disk->path($attachment->physicalPath()));
        }

        return null;
    }

    /**
     * Генерация валидатора
     *
     * @return Validator
     */
    protected function getValidator(): Validator
    {
        $data = $this->attachment->mapWithKeys(fn(Attachment $attachment, $key) => [$key => $this->getFileObjectFromAttachment($attachment)])->filter(fn($item) => !empty($item))->toArray();
        $rules = $this->attachment->mapWithKeys(fn(Attachment $attachment, $key) => [$key => $this->rules])->toArray();
        $attributes = $this->attachment->mapWithKeys(fn(Attachment $attachment, $key) => [$key => $attachment->original_name])->toArray();

        return validator(data: $data, rules: $rules, attributes: $attributes);
    }

    /**
     * @param \Illuminate\Support\Collection $errors
     * @return void
     */
    protected function removeFiles(\Illuminate\Support\Collection $errors): void
    {
        $errors->each(function ($message, $key) {
            if ($this->attachment->has($key)) {
                $this->attachment[$key]->delete();
            }
        });
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->setAttachment($value);
        $validator = $this->getValidator();

        if ($validator->fails()) {
            $errors = collect($validator->errors()->toArray());

            if ($this->removeFailed) {
                $this->removeFiles($errors);
            }

            $fail($errors->flatten()->implode(' '));
        }
    }
}
