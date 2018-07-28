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
            $content = [
                'code' => 200,
                'message' => 'success',
                'errors' => [],
            ];
            if (isset($event->content['data'])) {
                $content = array_merge($content, $event->content);
            } else {
                $content['data'] = $event->content;
            }

            $event->response->setContent($content);

        } else {
            $event->response->setContent([
                'code' => $event->content['code'] ?? $event->content['status_code'],
                'message' => $event->content['message'],
                'errors' => $event->content['errors'] ?? [],
                'data' => []
            ]);
        }
    }
}