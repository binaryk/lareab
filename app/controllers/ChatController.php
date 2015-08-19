<?php

class ChatController extends BaseController {

    public function sendMessage()
    {
        $chat = new ChatMessage();
        $chat->sender = Auth::user()->id;
        $chat->send_to = Input::get('send_to');
        $chat->message = Input::get('message');
        $chat->save();

        return date("Y-m-d H:i:s");
    }

    public function updateActivity()
    {
        $u = User::find(Auth::id());
        $u->last_activity = time();
        $u->save();
    }

    public function checkActivity()
    {
        $users = User::lists('last_activity','id');
        return $users;
    }

    public function checkForMessages()
    {
        $new_messages = ChatMessage::where('send_to', Auth::user()->id)->where('read', 0)->with('sender', 'send_to')->get();
        ChatMessage::where('send_to', Auth::user()->id)->where('read', 0)->where('showed', 0)->update(['showed' => 1]);
        return $new_messages->toArray();
    }

    public function getConversation()
    {
        $id = Input::get('id');
        $messages = ChatMessage::where(function ($query) use ($id) {
            $query->where('send_to', '=', Auth::id())
                ->where('sender', '=', $id);
        })->orWhere(function ($query)  use ($id) {
            $query->where('send_to', '=', $id)
                ->where('sender', '=', Auth::id());
        })->with('sender', 'send_to')->get();

        ChatMessage::where('send_to', '=', Auth::user()->id)->where('sender', '=', $id)->update(['read' => 1]);
        return View::make('chat.conversation', compact('messages'));
        
    }

}
