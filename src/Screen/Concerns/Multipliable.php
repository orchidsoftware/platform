<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

use Illuminate\Support\Str;

trait Multipliable
{
    /**
     * @return $this
     */
    public function multiple(): self
    {
        $this->set('multiple', 'multiple');
        $this->set('allowEmpty', '1'); // TODO do NOT allow null value when multiple is on

        $this->inlineAttributes[] = 'multiple';

        return $this->addBeforeRender(function () {
            $name = $this->get('name');

            $this->set('name', Str::finish($name, '[]'));
        });
    }
}
