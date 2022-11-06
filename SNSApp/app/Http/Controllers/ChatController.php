<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // メッセージ送信時の処理
    public function sendMessage( Request $request )
    {
        $user = $request->user();
        
        // リクエストからデータの取り出し
        $strMessage = $request->input('message');
        
        // メッセージオブジェクトの作成と公開メンバー設定
        $message = new Message;
        $message->username = $user->name;
        $message->userid = $user->id;
        $message->body = $strMessage;
       
        // 送信者を含めてメッセージを送信
        event( new MessageSent( $message ) ); // Laravel V7までの書き方
        // MessageSent::dispatch($message);    // Laravel V8以降の書き方
        
        // 送信者を除いて他者にメッセージを送信
        // Note : toOthersメソッドを呼び出すには、
        //        イベントでIlluminate\Broadcasting\InteractsWithSocketsトレイトをuseする必要がある。
        //broadcast( new MessageSent($message))->toOthers();
        
        return ['message' => $strMessage];
        // return $request;
    }
}
