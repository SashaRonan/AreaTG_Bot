<?php

namespace App\Telegram;

use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{

    public function hello($name)
    {
        $this->reply('Привет? ' . $name . '! Это твой первый бот на laravel');
        Log::info(json_encode($this->message->toArray(), JSON_PRETTY_PRINT));

    }

    protected function handleUnknownCommand(Stringable $text): void
    {

        if ($text->value() === '/start') {
            $this->reply('Рад тебя видеть. давай начнем пользоваться моими возможностями :-)');
        } else {
            $this->reply('Неизвестная команда');
            Log::info(json_encode($this->message->toArray(), JSON_PRETTY_PRINT));
        }
    }

    protected function handleChatMessage(Stringable $text): void
    {

        // Вся информация в storage/logs/laravel.log
        // все данные можно получать с помощью $this->message->
        Log::info(json_encode($this->message->toArray(), JSON_PRETTY_PRINT));

    }

    public function help()
    {
        $this->reply('*Привет* Пока я умею говорить только привет.');
        Log::info(json_encode($this->message->toArray(), JSON_PRETTY_PRINT));
    }

    public function acti() {
        $this->chat->message('Выбери действие')->keyboard(Keyboard::make()->buttons([
            Button::make('Перейти на сайт')->url('https://www.youtube.com'),
            Button::make('Поставить лайк')->action('like'),
            Button::make('Подписаться')->action('subscribe')->param('channel_name', '@areaweb')
        ]))->send();
    }

    public function like()
    {
        $this->reply('Спасибо тебе за твой крутой лайк');
        Log::info(json_encode($this->message->toArray(), JSON_PRETTY_PRINT));
    }


    public function subscribe()
    {
//        $this->reply('Спасибо, что подписался');
        $this->reply('Спасибо за подписку на ' . $this->data->get('channel_name') );

        Log::info(json_encode($this->message->toArray(), JSON_PRETTY_PRINT));
    }


    public function game() {
        $this->chat->html('Давай поиграем 🖖🏼')->send();

        sleep(1);

        $this->chat->message('Поиграем?\n\nВыбери число от 1 до 3')
            ->keyboard(Keyboard::make()->buttons([
                Button::make('- 1 -')->action('game123')->param('value', 1),
                Button::make('- 2 -')->action('game123')->param('value', 2),
                Button::make('- 3 -')->action('game123')->param('value', 3),
            ]))
            ->send();;

    }
}


