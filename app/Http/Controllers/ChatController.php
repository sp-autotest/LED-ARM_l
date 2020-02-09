<?php

namespace App\Http\Controllers;
use App\User;
use App\Conversation;
use App\Message;
use Illuminate\Http\Request;
use Auth;
use App\Profile;
use App\Events\Message as EMessage;


class ChatController extends Controller
{
     
    public $successStatus = 200;

    public function index()
    {

        return view('admin.chat');
    }

    public function getUsers(Request $request){
        $profiles = [];
    	$users = User::where([['active', 1], ['email', 'like', '%'.$request->q.'%']])->with('profile')->orderBy('last_login_at', 'desc')->get()->toArray();
        $profilesAr = Profile::where([['first_name', 'like', '%'.$request->q.'%']])->orWhere([['second_name', 'like', '%'.$request->q.'%']])->get();
        foreach ($profilesAr as $key => $value) {
            if($value->user_id != null){
                $u = $value->user()->with('profile')->get()->toArray();
                $users[] = $u[0];
            }
        }
       
        

        return $users;
    }
    public function getConversations(){
        $this->middleware(['role_or_permission:messages.posting']);

       $conversationsAr = User::find(Auth::user()->id)->conversations()->orderBy('created_at', 'desk')->get()->toArray();

    	foreach ($conversationsAr as $key => $value) {

            if($value['name'] == 'multiple_default'){
                $convName = '';
                foreach ($value['users'] as $ukey => $uvalue) {
                   if($uvalue['profile'] == null){
                     $convName .=  $uvalue['email'];
                   }else{
                     $convName .=  $uvalue['profile']['first_name'].' '.$uvalue['profile']['second_name'];
                   }
                   $convName .= ', ';
                }
                $conversationsAr[$key]['name'] = $convName;
            }

        }
        return response()
                   ->json(['conversations' => $conversationsAr], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
    }

    public function sendMessage(Request $request){
        $this->middleware(['role_or_permission:messages.posting']);

        if(strpos($request->conversation_id, 'system_message') !== false){
            $conversation = Conversation::where('name', 'system_messages_'.Auth::user()->id)->first();
            $message = Message::create(['user_id' => Auth::user()->id, 'conversation_id' => $conversation->id, 'text' => $request->text, 'is_read' => false]);
            return $message;
        }
    	$message = Message::create(['user_id' => Auth::user()->id, 'conversation_id' => $request->conversation_id, 'text' => $request->text, 'is_read' => false]);
    	$sender = Auth::user()->email; 
    	EMessage::dispatch($message, $sender);
        return response()
                   ->json(['message' => $message], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
    }


    public function createSystemMessage(Request $request){
        $message = new Message;
        $message->conversation_id = Conversation::where('name' , 'system_messages_'. Auth::user()->id)->first()->id;
        $message->text = $request->text;
        $message->user_id = null;
        $message->is_read = false;
        $message->save();
        event(new EMessage($message, 'System Message'));
       return $message;

    }
    public function createConversation(Request $request){
        $this->middleware(['role_or_permission:messages.index']);
                
            $conversation = Conversation::create(['name' => 'multiple_default']);
            $conversation->users()->attach(Auth::user()->id);
            if(count($request->users) > 0){
                foreach ($request->users as $key => $value) {
                    $conversation->users()->attach($value['id']);
                }
            }

        return response()
                   ->json(['conversation' => $conversation], $this->successStatus)
                   ->header('Access-Control-Allow-Origin', '*');
        
    }


    
    public function getMessages(Request $request){
        $this->middleware(['role_or_permission:messages.index']);

    	$messages = [];
        if(strpos($request->id, 'system_message') !== false){
           $messagesAr = Conversation::where('name', 'system_messages_'.Auth::user()->id)->first()->messages()->orderBy('created_at', 'asc')->get()->toArray();

        }else{
    	$messagesAr = Conversation::find($request->id)->messages()->orderBy('created_at', 'asc')->get()->toArray();
        }
    	$user = Auth::user()->id;
    	foreach ($messagesAr as $key => $value) {
    		if($user == $value['user_id']){
    			$messages[$key]['to'] = 'outside-msg';
    		}else{
    			$messages[$key]['to'] = 'inside-msg';
    		}
             if($value['user_id'] != null){
                $profile = Profile::where('user_id', $value['user_id'])->first();
                if(!$profile){
                    $messages[$key]['sender'] = User::find($value['user_id'])->email;
                }else{
                    $messages[$key]['sender'] = $profile->first_name. ' ' .$profile->second_name ;
                }
    			
            }else{
                $messages[$key]['sender'] = 'System Message';
            }
    			$messages[$key]['text'] = $value['text'];
    			$messages[$key]['time'] = $value['created_at'];
    	}
        return response()
            ->json(['messages' => $messages, 'count' => count($messages)], $this->successStatus)
            ->header('Access-Control-Allow-Origin', '*');

    }
}
