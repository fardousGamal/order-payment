<?php
namespace Modules\Payment\App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Payment\App\Http\Requests\API\PaymentRequest;
use Modules\Payment\app\Http\resources\API\PaymentResource;
use Modules\Order\App\Models\Order;
use Modules\Payment\App\Models\Payment;
use Modules\Payment\App\Services\PaymentService;


class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function index(Request $request)
    {
        $payments = Payment::with('order')->filter($request->filters)->paginate(10);

        return ApiResponse::paginateResponse(PaymentResource::collection($payments), $payments);

    }

    public function store(PaymentRequest $request)
    {
        $order = Order::findOrFail($request->order_id);
        try {
        $payment = $this->paymentService->process(
            $order,
            $request->payment_method
        );
        } catch (\Exception $e) {
            return ApiResponse::errorResponse(message: __($e->getMessage()));
        }
        return ApiResponse::successResponse(new PaymentResource($payment), code: Response::HTTP_CREATED);


    }


}
