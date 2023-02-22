<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;

class DateSettings extends Component
{

    public $startDate;
    public $stopDate;





    public function mount()
    {

        // unset the session variables
        //   session()->forget('startDate');
        //  session()->forget('stopDate');

        if (!session('startDate')) {
            session(['startDate' => Carbon::now()->subYear()->format('Y-m-d')]);
        }
        if (!session('stopDate')) {
            session(['stopDate' => Carbon::now()->format('Y-m-d')]);
        }

        $this->startDate = session('startDate');
        $this->stopDate = session('stopDate');
    }


    public function render()
    {


        $this->startDate = session('startDate');
        $this->stopDate = session('stopDate');
        return view('livewire.date-settings');
    }


    public function updatedStartDate($value)
    {

        if ($value > $this->stopDate) {
            $this->stopDate = $value;
            session(['stopDate' => $value]);
        }

        session(['startDate' => $value]);
        // ddl('it should refresh!');
        // $this->emit('refreshBookings');
        // ddl('did it?');

        $this->emit('startDate', $value);
        // reload the page
        $this->redirect(route('bookings.index'));
    }

    public function updatedStopDate($value)
    {

        if ($value < $this->startDate) {
            $this->startDate = $value;
            session(['startDate' => $value]);
        }

        session(['stopDate' => $value]);
        $this->emit('stopDate', $value);
        $this->redirect(route('bookings.index'));
    }


    public function thisYear()
    {
        session(['startDate' => Carbon::now()->startOfYear()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->endOfYear()->format('Y-m-d')]);
        $this->redirect(route('bookings.index'));
    }

    public function lastYear()
    {
        session(['startDate' => Carbon::now()->subYear()->startOfYear()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->subYear()->endOfYear()->format('Y-m-d')]);
        $this->redirect(route('bookings.index'));
    }

    public function thisMonth()
    {
        session(['startDate' => Carbon::now()->startOfMonth()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->endOfMonth()->format('Y-m-d')]);
        $this->redirect(route('bookings.index'));
    }

    public function lastMonth()
    {
        session(['startDate' => Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d')]);
        $this->redirect(route('bookings.index'));
    }

    public function thisWeek()
    {
        session(['startDate' => Carbon::now()->startOfWeek()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->endOfWeek()->format('Y-m-d')]);
        $this->redirect(route('bookings.index'));
    }

    public function lastWeek()
    {
        session(['startDate' => Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d')]);
    }

    public function thisQuarter()
    {
        session(['startDate' => Carbon::now()->startOfQuarter()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->endOfQuarter()->format('Y-m-d')]);
        $this->redirect(route('bookings.index'));
    }

    public function lastQuarter()
    {
        session(['startDate' => Carbon::now()->subQuarter()->startOfQuarter()->format('Y-m-d')]);
        session(['stopDate' => Carbon::now()->subQuarter()->endOfQuarter()->format('Y-m-d')]);
        $this->redirect(route('bookings.index'));
    }

    public function updating()
    {
        session(['startDate' => $this->startDate]);
        session(['stopDate' => $this->stopDate]);
    }
}
