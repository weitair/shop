<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Order;
use App\Logics\Api\Payment;
use App\Models\Setting;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Order::getList()
        );
    }

    public function confirm()
    {
        $this->validate([
            'sku'           => 'required|array',
            'logistics'     => 'required|int',
            'address'       => 'required|int',
            'invoice'       => 'required|int',
            'coupon'        => 'required|int',
        ]);

        if ($order = Order::confirm($this->request->post())) {
            $this->renderSuccess($order);
        }
        $this->renderError();
    }

    public function create()
    {
        $this->validate([
            'sku'             => 'required|array',
            'logistics'       => 'required|int', // 物流方式
            'address'         => 'required|int', // 收货地址ID
            'invoice'         => 'required|int', // 是否开具发票状态
            'coupon'          => 'required|int', // 优惠卷ID
            'channel'         => 'required|int', // 来自那个客户端提交的订单
            'payment_channel' => 'required|string', // 支付渠道
            'delivery_time'   => 'string',
            'phone'           => 'string',
            'remark'          => 'string',
            'store'           => 'int',
            'day'             => 'string',
            'time'            => 'numeric',
        ]);

        if ($order = Order::create($this->request->post())) {
            if ($result = Payment::submit($order)) {
                $result['id'] = $order->id;
                $this->renderSuccess($result);
            }
        }
        $this->renderError();
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $detail          = Order::detail($this->request->get('id'));
        $detail->close   = $detail->close_time_auto - time(); // 订单自动关闭的时间
        $detail->receive = $detail->finish_time_auto - time(); // 订单自动签收的时间
        $this->renderSuccess($detail);
    }

    public function payment()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $order = Order::detail($this->request->post('id'));
        if ($result = Payment::submit($order)) {
            $this->renderSuccess($result);
        }
        $this->renderError();
    }

    public function receive()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if ($result = Order::receive($this->request->post('id'))) {
            $this->renderSuccess([], '签收成功');
        }
        $this->renderError();
    }

    public function comment()
    {
        $this->validate([
            'id'      => 'required|integer',
            'comment' => 'required|string',
        ]);

        if ($order = Order::comments($this->request->post())) {
            $this->renderSuccess([], '评论成功');
        }
        $this->renderError();
    }

    public function close()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Order::close($this->request->post('id'))) {
            $this->renderSuccess([], '订单已取消');
        }
        $this->renderError();
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Order::remove($this->request->post('id'))) {
            $this->renderSuccess([], '订单已删除');
        }
        $this->renderError();
    }

    /**
     * 核销码
     */
    public function verify()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $id     = $this->request->get('id');
        $detail = Order::verifyPage($id);
        $qrcode = QrCode::format('png')->size(200)
            ->generate(config('app.url') . '/h5/#/pages_app/verify/handle/index?code=' . $detail->fetch->verify_code);
        $detail->qrcode = 'data:image/png;base64,' . base64_encode($qrcode);

        $this->renderSuccess([
            'setting' => Setting::getInstance('app.base')->fetch(),
            'detail'  => $detail,
        ]);
    }
}
