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
        }
        $this->refreshView();
    }

    public function updatedStopDate($value)
    {
        if ($value < $this->startDate) {
            $this->startDate = $value;
        }
        $this->refreshView();
    }


    public function thisYear()
    {
        $this->startDate = Carbon::now()->startOfYear()->format('Y-m-d');
        $this->stopDate = Carbon::now()->endOfYear()->format('Y-m-d');
        $this->refreshView();
    }

    public function lastYear()
    {
        $this->startDate = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
        $this->stopDate = Carbon::now()->subYear()->endOfYear()->format('Y-m-d');
        $this->refreshView();
    }

    public function thisMonth()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->stopDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->refreshView();
    }

    public function lastMonth()
    {
        $this->startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $this->stopDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $this->refreshView();
    }
    public function lastlastMonth()
    {
        $this->startDate = Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d');
        $this->stopDate = Carbon::now()->subMonths(2)->endOfMonth()->format('Y-m-d');
        $this->refreshView();
    }

    public function thisWeek()
    {
        $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->stopDate = Carbon::now()->endOfWeek()->format('Y-m-d');
        $this->refreshView();
    }

    public function lastWeek()
    {
        $this->startDate = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
        $this->stopDate = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');
        $this->refreshView();
    }

    public function thisQuarter()
    {
        $this->startDate = Carbon::now()->startOfQuarter()->format('Y-m-d');
        $this->stopDate = Carbon::now()->endOfQuarter()->format('Y-m-d');
        $this->refreshView();
    }

    public function lastQuarter()
    {
        $this->startDate = Carbon::now()->subQuarter()->startOfQuarter()->format('Y-m-d');
        $this->stopDate = Carbon::now()->subQuarter()->endOfQuarter()->format('Y-m-d');
        $this->refreshView();
    }

    public function month($Ym)
    {

        $month = Carbon::parse($Ym . '-01');
        $this->startDate = $month->day(1)->format('Y-m-d');
        $this->stopDate = $month->endOfMonth()->format('Y-m-d');
        $this->refreshView();
    }


    public function listOfMonths()
    {

        // get the number of the current month
        $nr = Carbon::now()->month;

        // if we are in the first or second quarter of the year we need to add all the months from the previous year

        if (Carbon::now()->quarter == 1 or Carbon::now()->quarter == 2) {
            $nr = $nr + 12;
        }

        // get a list of months from the current month back to the number of months
        $months = collect();
        for ($i = 0; $i < $nr; $i++) {
            $months->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }
        return $months;
    }



    public function refreshView()
    {

        session(['startDate' => $this->startDate]);
        $this->emit('startDate', $this->startDate);
        session(['stopDate' => $this->stopDate]);
        $this->emit('stopDate', $this->stopDate);

        //  $this->emit('refreshBookings');
        // TODO: I dont know why this is not working so u use a refresh instead
        // redirect back to the request uri
        $this->redirect(url()->previous());
    }
}
