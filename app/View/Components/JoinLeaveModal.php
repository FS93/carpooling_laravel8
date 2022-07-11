<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JoinLeaveModal extends Component
{
    public $initialType;
    public $rideID;
    public $userID;
    public $departure;
    public $departureTime;
    public $destination;
    public $price;
    public $availableSeats;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($initialType, $rideID, $userID, $departure, $departureTime, $destination, $price, $availableSeats)
    {
        //
        $this->initialType = $initialType;
        $this->rideID = $rideID;
        $this->userID = $userID;
        $this->departure = $departure;
        $this->departureTime = $departureTime;
        $this->destination = $destination;
        $this->price = $price;
        $this->availableSeats = $availableSeats;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.join-leave-modal');
    }
}
