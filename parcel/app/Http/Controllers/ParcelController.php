<?php

namespace App\Http\Controllers;

use Gate;
use Carbon\Carbon;
use App\Models\Parcel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\ParcelCreated;
use App\Events\ParcelCanceled;
use App\Events\ParcelPickedUp;
use App\Events\ParcelDelivered;
use App\Interfaces\RepositoryInterface;
use App\Http\Requests\CreateParcelRequest;
use App\Http\Requests\PickUpParcelRequest;
use App\Http\Requests\DeliverParcelRequest;

class ParcelController extends Controller
{
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function showBikerParcels(Request $request)
    {
        $parcels = Parcel::canBePickedUp(auth()->id());

        $parcels_copy = clone $parcels;

        $total = $parcels_copy->count();

        $length = $request->get('length', 10);

        $parcels = $parcels->limit($length);

        $parcels = $parcels
            ->latest()
            ->leftJoin('senders', 'senders.id', '=', 'parcels.sender_id')
            ->select(
                [
                    'parcels.id',
                    'parcels.pick_up_address',
                    'parcels.drop_off_address',
                    'parcels.status',
                    'parcels.code',
                    'parcels.created_at',
                    'parcels.sender_id',
                    'senders.first as sender_first',
                    'senders.last as sender_last'
                ]
            )
            ->cursor()
            ->each(function ($parcel) {
                if ($parcel->sender_id > 0) {
                    $parcel['sender_name'] = $parcel->sender_first . ' ' . $parcel->sender_last;
                } else {
                    $parcel['sender_name'] = '';
                }
            });

        return ['data' => $parcels, 'total' => $total];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showSenderParcels(Request $request)
    {
        $parcels = Parcel::senderIs(auth()->id());

        $page = $request->get('page', 0);
        $length = $request->get('length', 10);

        $parcels_copy = clone $parcels;

        $total = $parcels_copy->count();

        $parcels = $parcels->offset($page)->limit($length);

        $parcels = $parcels
            ->latest()
            ->select(
                [
                    'parcels.id',
                    'parcels.status',
                    'parcels.code',
                    'parcels.created_at',
                ]
            )
            ->get();

        return ['data' => $parcels, 'total' => $total];
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function show(Request $request, int $id)
    {
        return $this->repository->show($id, ['sender', 'biker']);
    }

    /**
     * @param CreateParcelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateParcelRequest $request)
    {
        $parcel = $this->repository->store(array_merge($request->all(), ['sender_id' => auth()->id()]));

        event(new ParcelCreated($parcel->toArray()));

        return response()->json(['message' => trans('messages.parcel_created')]);
    }

    /**
     * @param PickUpParcelRequest $request
     * @param int $parcel_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function pickup(PickUpParcelRequest $request, int $parcel_id)
    {
        $parcel = $this->repository->show($parcel_id);

        $response = Gate::forUser(auth()->user())->inspect('pickup', $parcel);

        if (!$response->allowed()) {
            return (new Response(['message' => $response->message()], '403'));
        }

        $parcel = $this->repository->update(
            $parcel,
            array_merge(
                $request->all(),
                [
                    'biker_id'      => auth()->id(),
                    'status'        => Parcel::PROCESSING,
                    'pick_up_date'  => Carbon::createFromTimestamp($request->get('pick_up_date'))
                ]
            )
        );

        event(new ParcelPickedUp($parcel->toArray()));

        return response()->json(['message' => trans('messages.parcel_picked_up')]);
    }

    /**
     * @param Request $request
     * @param int $parcel_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliver(DeliverParcelRequest $request, int $parcel_id)
    {
        $parcel = $this->repository->show($parcel_id);

        $response = Gate::forUser(auth()->user())->inspect('deliver', $parcel);

        if (!$response->allowed()) {
            return (new Response(['message' => $response->message()], '403'));
        }

        $parcel = $this->repository->update(
            $parcel,
            array_merge(
                $request->all(),
                [
                    'status'        => Parcel::DELIVERED,
                    'delivery_date' => Carbon::createFromTimestamp($request->get('delivery_date'))
                ]
            )
        );

        event(new ParcelDelivered($parcel->toArray()));

        return response()->json(['message' => trans('messages.parcel_delivered')]);
    }

    /**
     * @param Request $request
     * @param int $parcel_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, int $parcel_id)
    {
        $parcel = $this->repository->show($parcel_id);

        $response = Gate::forUser(auth()->user())->inspect('cancel', $parcel);

        if (!$response->allowed()) {
            return (new Response(['message' => $response->message()], '403'));
        }

        $parcel = $this->repository->update($parcel, ['status' => Parcel::CANCELED]);

        event(new ParcelCanceled($parcel->toArray()));

        return response()->json(['message' => trans('messages.parcel_canceled')]);
    }
}
