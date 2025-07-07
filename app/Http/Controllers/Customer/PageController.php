<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('customer.about');
    }

    public function contact()
    {
        return view('customer.contact');
    }

    public function sendContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::raw(
            "Message from: {$data['name']} <{$data['email']}>
\n{$data['message']}",
            function ($message) use ($data) {
                $message->to('uptrendclothing09@gmail.com')
                        ->subject('Customer Contact Form Submission');
            }
        );

        // Send a copy to the customer
        Mail::raw(
            "Thank you for contacting Uptrend Clothing Store!\n\nWe have received your message and will get back to you soon.\n\nHere is a copy of your message:\n\n{$data['message']}\n\nBest regards,\nUptrend Clothing Team",
            function ($message) use ($data) {
                $message->to($data['email'])
                        ->subject('Copy of your message to Uptrend Clothing Store');
            }
        );

        return redirect()->route('customer.contact')->with('success', 'Your message has been sent!');
    }
} 