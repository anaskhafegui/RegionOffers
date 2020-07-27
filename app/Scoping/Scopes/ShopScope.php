<?php

namespace App\Scoping\Scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class ShopScope implements Scope
{
	public function apply(Builder $builder, $value)
	{
		return $builder->where('name','LIKE','%'.$value.'%')->orwhere('name_ar','LIKE','%'.$value.'%');
	}
}