<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships;
    private array $relations = ['user'];
    public function index(Event $event)
    {
        $attendees = $this->loadRelationships(
            $event->attendees()->latest()
        );
        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

    public function store(Request $request,Event $event)
    {
        $attendee = $this->loadRelationships(
            $event->attendees()->create([
                'user_id' => 1
            ])
        );

        return new AttendeeResource($attendee);
    }

    public function show(Event $event,Attendee $attendee)
    {
        return new AttendeeResource(
            $this->loadRelationships($attendee)
        );    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $event,Attendee $attendee)
    {
        $attendee->delete();
        return response(status: 204);
    }
}
