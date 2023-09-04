<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
//     public function boot()
// {
//     // ...
 
//     VerifyEmail::toMailUsing(function ($notifiable, $url) {
//         return (new MailMessage)
//             ->subject('Verify Email Address')
//             ->line('Click the button below to verify your email address.')
//             ->action('Verify Email Address', $url);
//     });
// }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
