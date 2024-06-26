<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\withFileUploads;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Rules\NoBlankSpace;
use Illuminate\Support\Facades\Validator;

class ChatComponent extends Component
{
    use withFileUploads;
    public $user;
    public $sender_id;
    public $receiver_id;
    public $message = '';
    public $messages = [];
    public $file;

    public function render()
    {
        return view('livewire.chat-component');
    }

    public function mount($user_id)
    {

        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;

        $messages = Message::where(function ($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })
            ->with('sender:id,name', 'receiver:id,name')
            ->get();

        foreach ($messages as $message) {
            $this->appendChatMessage($message);
        }

        $this->user = User::whereId($user_id)->first();
    }

    public function sendMessage()
    {
        $validator = Validator::make(['message' => $this->message, 'file' => $this->file], [
            'message' => ['nullable',  new NoBlankSpace, 'min:1'],
            'file' => ['nullable', 'mimes:jpeg,png,jpg,gif,mp3,wav,mp4,avi,doc,docx,pdf', 'max:10240']
        ]);

        if ($validator->fails()) {
            return;
        }

        $chatMessage = new Message();
        $chatMessage->sender_id = $this->sender_id;
        $chatMessage->receiver_id = $this->receiver_id;
        $chatMessage->message = $this->message;
        if ($this->file) {
            $filename = time() . "_" . $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs('uploads', $filename);
            $chatMessage->file = $filePath;
        }

        $chatMessage->save();

        $this->appendChatMessage($chatMessage);
        broadcast(new MessageSendEvent($chatMessage))->toOthers();
        $this->message = '';
        $this->file = null;
    }

    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])
            ->with('sender:id,name', 'receiver:id,name')
            ->first();

        $this->appendChatMessage($chatMessage);
    }


    public function appendChatMessage($message)
    {
        $this->messages[] = [
            'id' => $message->id,
            'message' => $message->message,
            'sender' => $message->sender->name,
            'receiver' => $message->receiver->name,
            'file' => $message->file
        ];
    }
}
