<?php

namespace Modules\Order\App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Order\App\Http\Requests\API\OrderRequest;
use Modules\Order\App\Http\Requests\API\OrderStatusRequest;
use Modules\Order\app\Http\resources\API\OrderResource;
use Modules\Order\App\Models\Order;
use Modules\Order\App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(Request $request)
    {
        $orders = Order::where('user_id', Auth::id())->filter($request->filters)->with('items')->paginate(10);

        return ApiResponse::paginateResponse(OrderResource::collection($orders), $orders);

    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->create(
            $request->items,
            Auth::id()
        );

        return ApiResponse::successResponse(new OrderResource($order), code: Response::HTTP_CREATED);
    }

    public function updateStatus(OrderStatusRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($order) {
            if ($order->status !== $request->status) {
                $order->update(['status' => $request->status]);
            }
        }
        return ApiResponse::successResponse();
    }


    public function update(OrderRequest $request, int $id)
    {
        try {
            $order = $this->orderService->update($id, $request->validated());

        } catch (\Exception $e) {
            return ApiResponse::errorResponse(message: __($e->getMessage()));
        }
        return ApiResponse::successResponse(new OrderResource($order));
    }

    public function destroy(int $id)
    {
        try {
            $this->orderService->delete($id);

        }catch (\Exception $e) {
            return ApiResponse::errorResponse(message: __($e->getMessage()));
        }
        return ApiResponse::noContent();
    }

}
