<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;

class PatternFilter extends Filter
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = ['*'])
    {
        parent::__construct();
        $this->parameters = $parameters;
    }

    /**
     * @var array
     */
    public $parameters = [
        'pattern.*',
    ];

    public function name(): string
    {
        return 'Pattern';
    }

    public function run(Builder $builder): Builder
    {
        return $builder->where('pattern', 'is enabled');
    }
}
