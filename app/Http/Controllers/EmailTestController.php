<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class EmailTestController extends Controller
{
    public function sendTestEmail()
    {
        $details = [
            'title' => 'Test Email from Laravel',
            'body' => 'This is for testing email using Mailgun in Laravel'
        ];

        Mail::to('recipient@example.com')->send(new TestMail($details));
        return 'Email has been sent!';
    }
}
