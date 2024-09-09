<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Contracts\Container\BindingResolutionException;
use Orchid\Screen\Repository;
use Throwable;

trait Autofill
{
	/**
	 * @throws BindingResolutionException
	 * @throws Throwable
	 */
	public function render(): string
	{
		$fields     = array_map(fn($field) => $field->form('filters'), $this->display());
		$params     = $this->request->only($this->parameters(), []);
		$repository = new Repository($params);
		
		$builder = new \Orchid\Screen\Builder($fields, $repository);
		
		return $builder->generateForm();
	}
}
