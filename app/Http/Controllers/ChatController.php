<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getOrCreateChat(Request $request)
    {
        $chat = Chat::where(function ($query) use ($request) {
            $query->where('user1', $request->user1)
                ->where('user2', $request->user2);
        })->orWhere(function ($query) use ($request) {
            $query->where('user1', $request->user2)
                ->where('user2', $request->user1);
        })->first();

        if (!$chat) {
            $chat = Chat::create([
                'user1' => $request->user1,
                'user2' => $request->user2,
            ]);
        }

        return response()->json($chat);
    }

    public function getMessages($chat_id)
    {
        $messages = Message::where('chat_id', $chat_id)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer',
            'sender' => 'required|integer',
            'receiver' => 'required|integer',
            'message' => '',
            'image' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $message = Message::create([
                'chat_id' => $request->chat_id,
                'sender' => $request->sender,
                'receiver' => $request->receiver,
                'message' => $request->message,
                'image' => $request->image,
            ]);

            event(new MessageSent($message));

            return response()->json($message);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send message.'], 500);
        }
    }

    public function getUserChats($userId)
    {
        $chats = Chat::with(['messages' => function ($query) {
            $query->orderBy('created_at', 'desc')->first();
        }])->where('user1', $userId)
            ->orWhere('user2', $userId)
            ->get();

        foreach ($chats as $chat) {
            $chat->last_message = $chat->messages->first();
        }

        return response()->json($chats);
    }

    public function getAllChats()
    {
        // Retrieve all chats with the latest message included
        $chats = Chat::with(['messages' => function ($query) {
            $query->orderBy('created_at', 'desc')->first();
        }])->get();

        // Attach the latest message to each chat
        foreach ($chats as $chat) {
            $chat->last_message = $chat->messages->first();
        }

        return response()->json($chats);
    }
}
