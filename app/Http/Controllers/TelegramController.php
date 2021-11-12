<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;

class TelegramController extends Controller
{

    protected $telegram;


    public function __construct(/*$telegram*/)
    {
//        $this->telegram = new $telegram(env('TELEGRAM_BOT_TOKEN'));
    }

    /**
     *
     */
    public function getUpdates()
    {
        $updates = $this->telegram->getUpdates();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSendMessage()
    {
        return view('send-message');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSendMessage(Request $request)
    {
        $input = $request->all();
        $rules = [
            'message' => 'required'
        ];

        /*$validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return redirect()->back()
                ->with('status', 'danger')
                ->with('message', 'Message is required');
        }*/

        $this->telegram->sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $input['message']
        ]);

        return redirect()->back()
            ->with('status', 'success')
            ->with('message', 'Mensagem enviada');
    }
}
