<?php
namespace Ticket2\V1\Rest\ShowTickets;

class ShowTicketsEntity
{
    public $uuid;
    public $user_profile_uuid;
    public $name;
    public $code;
    public $description;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function populate($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
