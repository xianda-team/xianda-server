<?php namespace App\Listeners;

use Dingo\Api\Event\ResponseWasMorphed;

/**
 * 格式化 api 响应
 * Class FormatApiResponse
 * @package App\Listeners
 */
class FormatApiResponse
{
    public function handle(ResponseWasMorphed $event)
    {
        if (!isset($event->content['exception'])) {
            $event->response->setContent([
                'code' => 200,
                'message' => 'success',
                'errors' => [],
                'data' => $event->content
            ]);
        } else {
            $event->response->setContent([
                'code' => $event->content['code'],
                'message' => $event->content['message'],
                'errors' => $event->content['errors'],
                'data' => []
            ]);
        }
    }
}