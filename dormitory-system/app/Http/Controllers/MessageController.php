<?php
namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Admin;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function tenantToAdmin()
    {
        return view('tenant.messaging.message');
    }

    public function adminToTenants()
    {
        $tenants = Tenant::all(); 
        return view('admin.messaging.message', compact('tenants'));
    }


    public function tenantMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::guard('tenant')->id(),
            'receiver_id' => 999999,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function adminMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:tenants,id',
            'content' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::guard('admin')->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function tenantInbox()
    {
        $messages = Message::where('receiver_id', Auth::guard('tenant')->id())->latest()->get();

        return view('tenant.inbox.inbox', compact('messages'));
    }

    public function adminInbox()
    {
        $messages = Message::where('receiver_id', Auth::guard('admin')->id())
            ->with('sender')
            ->latest()
            ->get();
        return view('admin.inbox.inbox', compact('messages'));
    }
}