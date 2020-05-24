<?php

namespace App\Http\Middleware;

use Closure;
use App\Category;
class VerifyCategoriesCount
{
    /**
     * Handle an incoming request.
     *
     * @desc Must have Categories in order to create a post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Category::all()->count() === 0)
        {
            session()->flash('error', 'You need to add a category first, to be able to create a post.');
            return  redirect(route('categories.create'));
        }
        return $next($request);
    }
}
