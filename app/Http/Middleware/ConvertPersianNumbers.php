<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertPersianNumbers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $converted=$this->convertNumbers($request->all());
        $request->merge($converted);
        return $next($request);
    }

    private function convertNumbers($data)
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];

        if (is_array($data)) {
            // بازگشتی
            foreach ($data as $key => $value) {
                $data[$key] = $this->convertNumbers($value);
            }
            return $data;
        }
        if (is_string($data)) {
            return str_replace($arabic, $english, str_replace($persian, $english, $data));
        }

        return $data;
    }
}
